<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsSetting;
use App\Models\VisitorAnalytic;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    /**
     * عرض لوحة التحليلات الرئيسية
     */
    public function index()
    {
        try {
            // الحصول على إعدادات التحليلات
            $settings = AnalyticsSetting::getSettings();

            // إذا كانت التحليلات غير مفعلة، نعرض صفحة التفعيل فقط
            if (!$settings->is_enabled) {
                return view('admin.analytics.disabled', compact('settings'));
            }

            // الإحصاءات العامة
            $totalVisits = VisitorAnalytic::count();
            $uniqueVisits = VisitorAnalytic::where('is_unique', true)->count();
            $totalVisitorsToday = VisitorAnalytic::whereDate('created_at', Carbon::today())->count();

            // معدل الارتداد (نسبة الزيارات لصفحة واحدة فقط)
            $bounceRate = $totalVisits > 0
                ? round((VisitorAnalytic::where('is_bounce', true)->count() / $totalVisits) * 100, 2)
                : 0;

            // متوسط مدة الزيارة بالثواني
            $avgVisitDuration = VisitorAnalytic::where('visit_duration', '>', 0)->avg('visit_duration') ?? 0;

            // الزيارات حسب الدول (أعلى 10 دول)
            $visitorsByCountry = VisitorAnalytic::select('country', DB::raw('count(*) as total'))
                ->whereNotNull('country')
                ->where('country', '!=', '')
                ->groupBy('country')
                ->orderBy('total', 'desc')
                ->limit(10)
                ->get();

            // الزيارات حسب نوع الجهاز
            $visitorsByDevice = VisitorAnalytic::select('device_type', DB::raw('count(*) as total'))
                ->whereNotNull('device_type')
                ->where('device_type', '!=', '')
                ->groupBy('device_type')
                ->orderBy('total', 'desc')
                ->get();

            // الزيارات حسب المتصفح (أعلى 5 متصفحات)
            $visitorsByBrowser = VisitorAnalytic::select('browser', DB::raw('count(*) as total'))
                ->whereNotNull('browser')
                ->where('browser', '!=', '')
                ->groupBy('browser')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get();

            // الصفحات الأكثر زيارة (أعلى 10 صفحات) - تم التحسين لمنع الروابط الفارغة أو العناوين الفارغة
            $topPages = VisitorAnalytic::select('page_url', 'page_title', DB::raw('count(*) as total'))
                ->whereNotNull('page_url')
                ->where('page_url', '!=', '')
                ->whereNotNull('page_title')
                ->where('page_title', '!=', '')
                ->groupBy('page_url', 'page_title')
                ->orderBy('total', 'desc')
                ->limit(10)
                ->get();

            // بيانات المخطط الزمني (آخر 30 يوم)
            $last30Days = collect(range(29, 0))->map(function ($day) {
                $date = Carbon::today()->subDays($day);

                return [
                    'date' => $date->format('Y-m-d'),
                    'label' => $date->format('d M'),
                    'visits' => VisitorAnalytic::whereDate('created_at', $date)->count(),
                ];
            });

            // تسجيل في السجلات للتأكد من البيانات التي يتم استرجاعها
            Log::info('تم استرجاع بيانات التحليلات', [
                'totalVisits' => $totalVisits,
                'uniqueVisits' => $uniqueVisits,
                'totalVisitorsToday' => $totalVisitorsToday,
                'bounceRate' => $bounceRate,
                'visitorsByCountry_count' => $visitorsByCountry->count(),
                'topPages_count' => $topPages->count(),
                'visitorsByDevice_count' => $visitorsByDevice->count(),
                'visitorsByBrowser_count' => $visitorsByBrowser->count(),
            ]);

            return view('admin.analytics.index', compact(
                'settings',
                'totalVisits',
                'uniqueVisits',
                'totalVisitorsToday',
                'bounceRate',
                'avgVisitDuration',
                'visitorsByCountry',
                'topPages',
                'visitorsByDevice',
                'visitorsByBrowser',
                'last30Days'
            ));
        } catch (\Exception $e) {
            Log::error('خطأ في عرض صفحة التحليلات: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect()->route('admin.dashboard')
                ->with('error', 'حدث خطأ أثناء تحميل بيانات التحليلات. يرجى المحاولة مرة أخرى لاحقًا.');
        }
    }

    /**
     * عرض صفحة إعدادات التحليلات
     */
    public function settings()
    {
        $settings = AnalyticsSetting::getSettings();
        return view('admin.analytics.settings', compact('settings'));
    }

    /**
     * تحديث إعدادات التحليلات
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'is_enabled' => 'required|boolean',
            'track_bots' => 'required|boolean',
            'data_retention_days' => 'required|integer|min:1|max:365',
        ]);

        $settings = AnalyticsSetting::getSettings();
        $settings->update($request->only(['is_enabled', 'track_bots', 'data_retention_days']));

        // تنظيف البيانات القديمة إذا تم تغيير فترة الاحتفاظ بالبيانات
        AnalyticsService::cleanupOldData();

        return redirect()->route('admin.analytics.settings')
            ->with('success', 'تم تحديث إعدادات التحليلات بنجاح');
    }

    /**
     * تنزيل تقرير التحليلات بتنسيق CSV
     */
    public function exportCsv(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $fileName = 'analytics-' . $request->start_date . '-to-' . $request->end_date . '.csv';

        $visits = VisitorAnalytic::whereBetween('created_at', [
            $request->start_date . ' 00:00:00',
            $request->end_date . ' 23:59:59'
        ])
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $columns = [
            'IP Address',
            'Page URL',
            'Page Title',
            'Referrer URL',
            'Country',
            'City',
            'Device Type',
            'Browser',
            'OS',
            'Visit Duration (seconds)',
            'Unique Visit',
            'Bounce',
            'Date & Time'
        ];

        $callback = function () use ($visits, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($visits as $visit) {
                $row = [
                    $visit->ip_address,
                    $visit->page_url,
                    $visit->page_title,
                    $visit->referrer_url,
                    $visit->country,
                    $visit->city,
                    $visit->device_type,
                    $visit->browser,
                    $visit->os,
                    $visit->visit_duration,
                    $visit->is_unique ? 'Yes' : 'No',
                    $visit->is_bounce ? 'Yes' : 'No',
                    $visit->created_at
                ];

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * حذف جميع بيانات التحليلات
     */
    public function clearAllData()
    {
        if (auth()->user()->isAdmin()) {
            VisitorAnalytic::truncate();
            return redirect()->route('admin.analytics')
                ->with('success', 'تم مسح جميع بيانات التحليلات بنجاح');
        }

        return redirect()->route('admin.analytics')
            ->with('error', 'ليس لديك صلاحية حذف بيانات التحليلات');
    }
}
