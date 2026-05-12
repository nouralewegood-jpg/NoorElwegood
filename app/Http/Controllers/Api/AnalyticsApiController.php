<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsSetting;
use App\Models\VisitorAnalytic;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class AnalyticsApiController extends Controller
{
    /**
     * تسجيل زيارة جديدة من طلب API
     */
    public function recordVisit(Request $request)
    {
        // التحقق من تفعيل التحليلات
        $settings = AnalyticsSetting::getSettings();
        if (!$settings->is_enabled) {
            return response()->json(['success' => false, 'message' => 'Analytics is disabled']);
        }

        // نقوم بتسجيل الزيارة باستخدام خدمة التحليلات
        AnalyticsService::recordVisit($request);
        
        // نحصل على معرف آخر زيارة تم تسجيلها لهذا المستخدم
        $visit = VisitorAnalytic::where('ip_address', $request->ip())
            ->latest()
            ->first();
            
        if ($visit) {
            return response()->json([
                'success' => true, 
                'visit_id' => $visit->id
            ]);
        }
        
        return response()->json(['success' => false]);
    }
    
    /**
     * تحديث مدة الزيارة
     */
    public function updateDuration(Request $request)
    {
        $request->validate([
            'visit_id' => 'required|integer',
            'duration' => 'required|integer|min:1',
        ]);
        
        AnalyticsService::updateVisitDuration(
            $request->visit_id,
            $request->duration
        );
        
        return response()->json(['success' => true]);
    }
}
