<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class MessageRateLimiter
{
    /**
     * التحكم في معدل إرسال الرسائل من نموذج الاتصال
     * مع تطبيق ضوابط أمنية متعددة المستويات
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // إنشاء معرّفات متعددة للحماية من محاولات الالتفاف حول الحدود
        $ipKey = 'message_ip_' . md5($request->ip());
        $emailKey = 'message_email_' . strtolower(md5($request->email ?? 'guest'));
        $combinedKey = 'message_combined_' . md5($request->ip() . '|' . strtolower($request->email ?? 'guest'));

        // الحدود القصوى المختلفة لكل معرّف
        $limits = [
            // 3 رسائل كل ساعة لكل عنوان IP + بريد إلكتروني
            [$combinedKey, 3, 60 * 60],
            // 5 رسائل كل ساعة لكل عنوان IP (بغض النظر عن البريد الإلكتروني)
            [$ipKey, 5, 60 * 60],
            // 10 رسائل كل يوم لكل عنوان IP
            [$ipKey . '_daily', 10, 24 * 60 * 60],
            // 10 رسائل كل يوم لكل بريد إلكتروني
            [$emailKey . '_daily', 10, 24 * 60 * 60],
        ];

        // فحص جميع المحددات
        foreach ($limits as [$key, $maxAttempts, $decaySeconds]) {
            if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
                // الوقت المتبقي قبل إعادة ضبط الحد (بالثواني)
                $seconds = RateLimiter::availableIn($key);

                // تحويل الثواني إلى دقائق أو ساعات حسب المدة
                $waitTime = $this->formatWaitTime($seconds);

                // تسجيل محاولة تجاوز الحد في السجلات
                Log::warning('Rate limit exceeded for contact form', [
                    'ip' => $request->ip(),
                    'email' => $request->email ?? 'not_provided',
                    'user_agent' => $request->userAgent() ?? 'unknown',
                    'key' => $key,
                    'limit_type' => str_contains($key, 'daily') ? 'daily' : 'hourly'
                ]);

                $message = "لقد تجاوزت الحد المسموح به من الرسائل. يرجى المحاولة بعد {$waitTime}.";

                // في حالة واجهات API
                if ($request->expectsJson()) {
                    return response()->json(['error' => $message], 429);
                }

                // في حالة واجهات الويب
                return redirect()->back()
                    ->withInput($request->except(['message', '_token']))
                    ->with('error', $message);
            }

            // زيادة عدد المحاولات
            RateLimiter::hit($key, $decaySeconds);
        }

        // التحقق من وجود كلمات محظورة أو نمط محتوى غير مرغوب فيه
        if ($this->containsSuspiciousContent($request)) {
            Log::warning('Suspicious content detected in contact form submission', [
                'ip' => $request->ip(),
                'email' => $request->email ?? 'not_provided',
                'subject' => $request->subject ?? 'not_provided'
            ]);

            return redirect()->back()
                ->withInput($request->except(['message', '_token']))
                ->with('error', 'تم رفض الرسالة لاحتوائها على محتوى غير مسموح.');
        }

        return $next($request);
    }

    /**
     * تنسيق وقت الانتظار بشكل مقروء للإنسان
     */
    protected function formatWaitTime(int $seconds): string
    {
        if ($seconds < 60) {
            return $seconds . ' ثانية';
        } elseif ($seconds < 60 * 60) {
            return ceil($seconds / 60) . ' دقيقة';
        } else {
            $hours = floor($seconds / 3600);
            $minutes = ceil(($seconds % 3600) / 60);
            return $hours . ' ساعة' . ($minutes > 0 ? ' و ' . $minutes . ' دقيقة' : '');
        }
    }

    /**
     * التحقق من وجود محتوى مشبوه في الرسالة
     */
    protected function containsSuspiciousContent(Request $request): bool
    {
        $message = $request->input('message', '');
        $subject = $request->input('subject', '');
        $content = $subject . ' ' . $message;

        // قائمة بالأنماط المشبوهة المحتملة (تعبيرات منتظمة)
        $suspiciousPatterns = [
            // أنماط حقن SQL بسيطة
            '/\b(SELECT|INSERT|UPDATE|DELETE|DROP|UNION|ALTER)\b.*\b(FROM|INTO|WHERE|TABLE|DATABASE)\b/i',
            // روابط مشبوهة
            '/\b(porn|casino|pill|viagra|cialis|forex|crypto|coin|betting|gambling|loan|hack|crack)\b/i',
            // أنماط حقن JavaScript الأساسية
            '/<\s*script\b[^>]*>/i',
            '/javascript\s*:/i',
            '/on(load|click|mouseover|submit|focus|blur)\s*=/i',
            // روابط data URI مشبوهة
            '/data\s*:\s*[^;]*base64/i',
            // محتوى iframe مشبوه
            '/<\s*iframe\b[^>]*>/i',
        ];

        // فحص المحتوى باستخدام الأنماط المشبوهة
        foreach ($suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $content)) {
                return true;
            }
        }

        // فحص العدد الزائد من الروابط (يمكن أن يكون دليلاً على البريد العشوائي)
        $urlCount = preg_match_all('/https?:\/\/\S+/i', $content);
        if ($urlCount > 5) {
            return true;
        }

        return false;
    }
}
