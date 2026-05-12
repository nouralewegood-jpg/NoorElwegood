<?php

namespace App\Http\Middleware;

use App\Models\AnalyticsSetting;
use App\Services\AnalyticsService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TrackVisits
{
    /**
     * تسجيل الزيارة ومعالجة الطلب
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // نحصل على الإعدادات للتحقق من تفعيل النظام
            $settings = AnalyticsSetting::getSettings();

            // نسجل الزيارة إذا كانت التحليلات مفعلة
            if ($settings->is_enabled) {
                // نسجل الزيارات فقط للصفحات العامة (وليس لوحة التحكم)
                if (!$this->isAdminRoute($request)) {
                    AnalyticsService::recordVisit($request);
                    Log::info('تم معالجة طلب تتبع الزيارة', [
                        'url' => $request->fullUrl(),
                        'method' => $request->method()
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('خطأ في middleware تتبع الزيارات: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }

        // نكمل معالجة الطلب
        $response = $next($request);

        return $response;
    }

    /**
     * التحقق مما إذا كانت الصفحة الحالية من لوحة التحكم
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    private function isAdminRoute(Request $request): bool
    {
        $path = $request->path();

        // نتحقق مما إذا كان المسار يبدأ بـ admin
        if (str_starts_with($path, 'admin')) {
            return true;
        }

        return false;
    }
}
