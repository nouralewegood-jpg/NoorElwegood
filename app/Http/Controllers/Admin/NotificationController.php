<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlanRequest;
use App\Models\ChatbotUnansweredQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotificationController extends Controller
{
    /**
     * عرض صفحة الإشعارات
     */
    public function index()
    {
        // يمكن تنفيذ صفحة للإشعارات مستقبلاً
        return view('admin.notifications.index');
    }

    /**
     * الحصول على أحدث الإشعارات بتنسيق JSON
     */
    public function getLatest()
    {
        // الحصول على طلبات الخطط الجديدة
        $planRequests = PlanRequest::where('status', 'new')
            ->with('plan:id,name')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($request) {
                return [
                    'id' => $request->id,
                    'name' => $request->name,
                    'plan_name' => $request->plan->name ?? 'خطة غير معروفة',
                    'created_at' => $request->created_at->diffForHumans()
                ];
            });

        // الحصول على أسئلة الشات بوت
        $chatbotQuestions = ChatbotUnansweredQuestion::where('status', 'pending')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($question) {
                return [
                    'id' => $question->id,
                    'question' => Str::limit($question->question, 30),
                    'created_at' => $question->created_at->diffForHumans()
                ];
            });

        return response()->json([
            'plan_requests' => $planRequests,
            'chatbot_questions' => $chatbotQuestions
        ]);
    }

    /**
     * تمييز جميع الإشعارات كمقروءة
     */
    public function markAllRead()
    {
        // تمييز طلبات الخطط كمقروءة (تغيير حالتها)
        PlanRequest::where('status', 'new')
            ->update(['status' => 'processing']);

        return response()->json(['message' => 'تم تمييز جميع الإشعارات كمقروءة']);
    }
}
