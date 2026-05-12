<?php

namespace App\Services;

use App\Models\AnalyticsSetting;
use App\Models\VisitorAnalytic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;

class AnalyticsService
{
    /**
     * تسجيل زيارة جديدة
     *
     * @param Request $request
     * @return void
     */
    public static function recordVisit(Request $request)
    {
        try {
            // تجاهل الطلبات إلى endpoint تسجيل التحليلات نفسه لمنع التسجيل المزدوج
            if (str_contains($request->path(), 'api/analytics/record')) {
                return;
            }

            // التحقق من تفعيل نظام التحليلات
            $settings = AnalyticsSetting::getSettings();
            if (!$settings->is_enabled) {
                return;
            }

            // التعرف على عميل المستخدم (متصفح، نظام التشغيل، الجهاز)
            $agent = new Agent();
            $userAgent = $request->userAgent();
            $agent->setUserAgent($userAgent);

            // تخطي روبوتات البحث إذا لم يتم تفعيل تتبعها
            if (!$settings->track_bots && $agent->isRobot()) {
                return;
            }

            // الحصول على بيانات الزائر (الدولة، المدينة)
            $ipAddress = $request->ip();
            $geoData = self::getGeoData($ipAddress);

            // التحقق من الزيارة الفريدة (فقط زيارة واحدة لكل عنوان IP في اليوم)
            $isUnique = !VisitorAnalytic::where('ip_address', $ipAddress)
                ->whereDate('created_at', Carbon::today())
                ->exists();

            // إنشاء سجل الزيارة
            VisitorAnalytic::create([
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'country' => $geoData['country'] ?? null,
                'city' => $geoData['city'] ?? null,
                'page_url' => $request->fullUrl(),
                'page_title' => $request->get('page_title', null),
                'referrer_url' => $request->header('referer'),
                'device_type' => self::getDeviceType($agent),
                'browser' => $agent->browser(),
                'os' => $agent->platform(),
                'is_unique' => $isUnique,
                'is_bounce' => true, // سيتم تحديثه لاحقاً إذا زار المستخدم صفحات أخرى
                'visit_duration' => 0 // سيتم تحديثه لاحقاً
            ]);

            Log::info('تم تسجيل زيارة جديدة', [
                'ip' => $ipAddress,
                'url' => $request->fullUrl(),
                'is_unique' => $isUnique
            ]);
        } catch (\Exception $e) {
            Log::error('خطأ في تسجيل الزيارة: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    }

    /**
     * تحديث مدة الزيارة
     *
     * @param int $visitId
     * @param int $duration
     * @return void
     */
    public static function updateVisitDuration(int $visitId, int $duration)
    {
        try {
            $visit = VisitorAnalytic::find($visitId);
            if ($visit) {
                $visit->update([
                    'visit_duration' => $duration,
                    'is_bounce' => false
                ]);

                Log::info('تم تحديث مدة الزيارة', [
                    'visit_id' => $visitId,
                    'duration' => $duration
                ]);
            }
        } catch (\Exception $e) {
            Log::error('خطأ في تحديث مدة الزيارة: ' . $e->getMessage());
        }
    }

    /**
     * الحصول على نوع الجهاز
     *
     * @param Agent $agent
     * @return string
     */
    private static function getDeviceType(Agent $agent): string
    {
        if ($agent->isPhone()) {
            return 'mobile';
        } elseif ($agent->isTablet()) {
            return 'tablet';
        } elseif ($agent->isDesktop()) {
            return 'desktop';
        } else {
            return 'other';
        }
    }

    /**
     * الحصول على بيانات الموقع الجغرافي للزائر
     *
     * @param string $ipAddress
     * @return array
     */
    private static function getGeoData(string $ipAddress): array
    {
        if (in_array($ipAddress, ['127.0.0.1', 'localhost', '::1'])) {
            return [
                'country' => 'Local',
                'city' => 'Development'
            ];
        }

        try {
            $response = Http::get("http://ip-api.com/json/{$ipAddress}");
            $data = $response->json();

            if ($response->successful() && isset($data['status']) && $data['status'] === 'success') {
                return [
                    'country' => $data['country'] ?? null,
                    'city' => $data['city'] ?? null
                ];
            }
        } catch (\Exception $e) {
            Log::error('خطأ في الحصول على بيانات الموقع الجغرافي: ' . $e->getMessage());
        }

        return [
            'country' => null,
            'city' => null
        ];
    }

    /**
     * حذف البيانات القديمة بناءً على فترة الاحتفاظ بالبيانات
     *
     * @return void
     */
    public static function cleanupOldData()
    {
        try {
            $settings = AnalyticsSetting::getSettings();
            $cutoffDate = Carbon::now()->subDays($settings->data_retention_days);

            $deleted = VisitorAnalytic::where('created_at', '<', $cutoffDate)->delete();

            Log::info("تم حذف {$deleted} سجل قديم من بيانات التحليلات");
        } catch (\Exception $e) {
            Log::error('خطأ في تنظيف البيانات القديمة: ' . $e->getMessage());
        }
    }
}
