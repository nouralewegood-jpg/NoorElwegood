<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlanRequest;
use Illuminate\Http\Request;

class PlanRequestController extends Controller
{
    /**
     * عرض قائمة بجميع طلبات الخطط
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $planRequests = PlanRequest::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.plan_requests.index', [
            'planRequests' => $planRequests,
        ]);
    }

    /**
     * عرض طلب محدد
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $planRequest = PlanRequest::findOrFail($id);

        return view('admin.plan_requests.show', [
            'planRequest' => $planRequest,
        ]);
    }

    /**
     * تحديث طلب محدد
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $planRequest = PlanRequest::findOrFail($id);

        $validatedData = $request->validate([
            'status' => 'required|in:new,in_progress,completed,cancelled',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $planRequest->update($validatedData);

        return redirect()->route('admin.plan-requests.show', $id)
            ->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    /**
     * حذف طلب محدد
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $planRequest = PlanRequest::findOrFail($id);
        $planRequest->delete();

        return redirect()->route('admin.plan-requests.index')
            ->with('success', 'تم حذف الطلب بنجاح');
    }

    /**
     * تحديث مجموعة من الطلبات دفعة واحدة
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bulkUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:plan_requests,id',
            'action' => 'required|in:mark_in_progress,mark_completed,mark_cancelled,delete',
        ]);

        $ids = $validatedData['ids'];
        $action = $validatedData['action'];

        switch ($action) {
            case 'mark_in_progress':
                PlanRequest::whereIn('id', $ids)->update(['status' => 'in_progress']);
                $message = 'تم تحديث الطلبات المحددة إلى "قيد المعالجة"';
                break;

            case 'mark_completed':
                PlanRequest::whereIn('id', $ids)->update(['status' => 'completed']);
                $message = 'تم تحديث الطلبات المحددة إلى "مكتمل"';
                break;

            case 'mark_cancelled':
                PlanRequest::whereIn('id', $ids)->update(['status' => 'cancelled']);
                $message = 'تم تحديث الطلبات المحددة إلى "ملغي"';
                break;

            case 'delete':
                PlanRequest::whereIn('id', $ids)->delete();
                $message = 'تم حذف الطلبات المحددة بنجاح';
                break;

            default:
                $message = 'تم تنفيذ العملية بنجاح';
        }

        return redirect()->route('admin.plan-requests.index')
            ->with('success', $message);
    }
}
