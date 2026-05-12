<?php

namespace App\Http\Controllers;

use App\Models\PlanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlanRequestController extends Controller
{
    /**
     * حفظ طلب خطة جديد
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // تسجيل البيانات المستلمة للتشخيص
        Log::info('Plan request data received:', $request->all());

        // التحقق من صحة البيانات
        $validatedData = $request->validate([
            'client_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'country_code' => 'required|string|max:10',
            'country' => 'required|string|max:50',
            'project_details' => 'nullable|string',
            'plan_name' => 'required|string|max:255',
            'plan_price' => 'required|string|max:50',
            'plan_period' => 'nullable|string|max:50',
        ]);

        try {
            // معالجة رقم الهاتف وحذف الصفر في البداية إذا وجد
            $phoneNumber = $validatedData['phone_number'];
            if (!empty($phoneNumber) && substr($phoneNumber, 0, 1) === '0') {
                $phoneNumber = substr($phoneNumber, 1);
            }

            // تحويل البيانات لتتطابق مع هيكل جدول قاعدة البيانات
            $planRequestData = [
                'client_name' => $validatedData['client_name'],
                'phone_number' => $phoneNumber, // استخدام رقم الهاتف بعد معالجته
                'country_code' => $validatedData['country_code'], // استخدام مفتاح الدولة المرسل من النموذج
                'country' => $validatedData['country'],
                'project_details' => $validatedData['project_details'] ?? null,
                'plan_name' => $validatedData['plan_name'],
                'plan_price' => $validatedData['plan_price'],
                'plan_period' => $validatedData['plan_period'] ?? null,
                'status' => 'new', // تعيين حالة افتراضية للطلب الجديد
            ];

            // تسجيل البيانات بعد المعالجة للتأكد من صحتها
            Log::info('Plan request data after processing:', $planRequestData);

            // إنشاء طلب جديد
            $planRequest = PlanRequest::create($planRequestData);

            // إرجاع استجابة نجاح
            return response()->json([
                'success' => true,
                'message' => 'تم إرسال طلبك بنجاح. سنتواصل معك قريباً.',
                'data' => $planRequest
            ]);
        } catch (\Exception $e) {
            // تسجيل الخطأ للتشخيص
            Log::error('Error processing plan request:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // إرجاع استجابة خطأ
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء معالجة طلبك. الرجاء المحاولة مرة أخرى.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
