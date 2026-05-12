<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatbotMessage;
use App\Services\ChatbotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    /**
     * الحد الأقصى لعدد الطلبات المسموح بها في الفترة الزمنية
     */
    protected $maxAttempts = 10;

    /**
     * الفترة الزمنية (بالدقائق) للحماية من التكرار
     */
    protected $decayMinutes = 1;

    /**
     * الرد على رسالة المستخدم
     *
     * @param Request $request
     * @param ChatbotService $chatbotService
     * @return \Illuminate\Http\JsonResponse
     */
    public function reply(Request $request, ChatbotService $chatbotService)
    {
        // التحقق من عدد الطلبات وتطبيق الحماية من التكرار
        $ipAddress = $request->ip();
        $cacheKey = 'chatbot_rate_limit:' . $ipAddress;
        $requestCount = Cache::get($cacheKey, 0);

        if ($requestCount >= $this->maxAttempts) {
            return response()->json([
                'error' => 'تم تجاوز الحد المسموح به من الرسائل، يرجى المحاولة بعد قليل.'
            ], 429);
        }

        // زيادة عداد الطلبات
        Cache::put($cacheKey, $requestCount + 1, now()->addMinutes($this->decayMinutes));

        // التحقق من صحة المدخلات بشكل أكثر تفصيلاً
        $validator = Validator::make($request->all(), [
            'message' => [
                'required',
                'string',
                'max:500', // الحد الأقصى لطول الرسالة
                function ($attribute, $value, $fail) {
                    // التحقق من وجود محتوى خبيث في الرسالة
                    $suspiciousPatterns = [
                        '/<script\b[^>]*>(.*?)<\/script>/i',
                        '/<iframe\b[^>]*>(.*?)<\/iframe>/i',
                        '/javascript:/i',
                        '/on\w+\s*=/i', // مثل onclick, onload, إلخ
                        '/data:text\/html/i'
                    ];

                    foreach ($suspiciousPatterns as $pattern) {
                        if (preg_match($pattern, $value)) {
                            $fail('الرسالة تحتوي على محتوى غير مسموح به.');
                            break;
                        }
                    }
                }
            ]
        ], [
            'message.required' => 'يجب إدخال رسالة.',
            'message.string' => 'يجب أن تكون الرسالة نصية.',
            'message.max' => 'الرسالة طويلة جدًا.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'خطأ في البيانات المدخلة',
                'messages' => $validator->errors()
            ], 422);
        }

        // تعقيم البيانات قبل معالجتها
        $message = $this->sanitizeInput($request->input('message'));

        // التأكد من أن الرسالة ليست فارغة بعد التعقيم
        if (empty(trim($message))) {
            return response()->json([
                'error' => 'الرسالة فارغة بعد إزالة المحتوى غير المسموح به.'
            ], 422);
        }

        try {
            $responseText = $chatbotService->getResponse($message);

            // تخزين المحادثة
            ChatbotMessage::create([
                'message' => $message,
                'response' => $responseText,
                'ip_address' => $ipAddress,
                'user_agent' => $request->userAgent() ? substr($request->userAgent(), 0, 255) : null
            ]);

            return response()->json(['response' => $responseText]);
        } catch (\Exception $e) {
            // تسجيل الخطأ في السجلات بدلاً من عرضه للمستخدم
            Log::error('Chatbot error: ' . $e->getMessage());

            return response()->json([
                'error' => 'حدث خطأ أثناء معالجة الطلب، يرجى المحاولة مرة أخرى.'
            ], 500);
        }
    }

    /**
     * تعقيم المدخلات وإزالة أي محتوى خبيث محتمل
     *
     * @param string $input
     * @return string
     */
    protected function sanitizeInput($input)
    {
        if (empty($input)) {
            return '';
        }

        // إزالة علامات HTML والمحتوى الضار
        $sanitized = htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // إزالة أكواد JavaScript المخفية
        $sanitized = preg_replace('/&#x([0-9a-f]+);/i', '', $sanitized);
        $sanitized = preg_replace('/&#([0-9]+);/i', '', $sanitized);

        // إزالة روابط data URI الضارة
        $sanitized = preg_replace('/data:\s*[^\s]*?base64[^\s]*?/i', '', $sanitized);

        // التأكد من التشفير السليم للنص
        $sanitized = mb_convert_encoding($sanitized, 'UTF-8', 'UTF-8');

        return trim($sanitized);
    }
}
