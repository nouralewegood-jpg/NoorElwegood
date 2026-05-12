<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    /**
     * عرض قائمة الرسائل في لوحة التحكم
     */
    public function index()
    {
        $messages = Message::orderBy('created_at', 'desc')->get();
        return view('admin.messages.index', compact('messages'));
    }

    /**
     * عرض تفاصيل رسالة معينة
     */
    public function show($id)
    {
        $message = Message::findOrFail($id);

        // تحديث حالة الرسالة لتصبح مقروءة
        if (!$message->is_read) {
            $message->is_read = true;
            $message->save();
        }

        return view('admin.messages.show', compact('message'));
    }

    /**
     * حذف رسالة
     */
    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'تم حذف الرسالة بنجاح');
    }

    /**
     * استلام الرسائل المرسلة من نموذج الاتصال بالموقع
     * تم تبسيط هذه الدالة لتجنب المشاكل التي تمنع حفظ الرسائل
     */
    public function store(Request $request)
    {
        // قواعد التحقق الأساسية
        $rules = [
            'name' => 'required|string|max:255|min:2',
            'email' => 'required|email|max:255',
            'country_id' => 'required|exists:countries,id',
            'phone_number' => [
                'nullable',
                'string',
                'max:15',
                function ($attribute, $value, $fail) use ($request) {
                    // تجاهل التحقق إذا كان رقم الهاتف فارغًا
                    if (empty($value)) {
                        return;
                    }

                    // التحقق من أن القيمة تحتوي على أرقام فقط
                    if (!preg_match('/^[0-9]+$/', $value)) {
                        $fail('يجب أن يحتوي رقم الهاتف على أرقام فقط');
                        return;
                    }

                    // الحصول على معلومات الدولة المحددة
                    $countryId = $request->input('country_id');
                    $country = Country::find($countryId);

                    if ($country) {
                        $length = strlen($value);

                        if ($length < $country->min_length || $length > $country->max_length) {
                            $fail(sprintf(
                                'عدد أرقام الهاتف لدولة %s يجب أن يكون بين %d و %d رقمًا',
                                $country->name_ar,
                                $country->min_length,
                                $country->max_length
                            ));
                        }
                    }
                },
            ],
            'subject' => 'required|string|max:255|min:5',
            'message' => 'required|string|min:10|max:5000',
        ];

        // رسائل الخطأ المخصصة
        $messages = [
            'name.required' => 'يرجى إدخال الاسم.',
            'name.min' => 'يجب أن لا يقل الاسم عن حرفين.',
            'email.required' => 'يرجى إدخال البريد الإلكتروني.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صالح.',
            'country_id.required' => 'يرجى اختيار الدولة.',
            'country_id.exists' => 'الدولة المختارة غير متاحة.',
            'subject.required' => 'يرجى إدخال موضوع الرسالة.',
            'subject.min' => 'يجب أن لا يقل الموضوع عن 5 أحرف.',
            'message.required' => 'يرجى إدخال نص الرسالة.',
            'message.min' => 'يجب أن لا تقل الرسالة عن 10 أحرف.',
        ];

        // إجراء التحقق
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // الحصول على معلومات الدولة
            $country = Country::find($request->country_id);

            // معالجة رقم الهاتف وحذف الصفر في البداية إذا وجد
            $phoneNumber = $request->phone_number;
            if (!empty($phoneNumber)) {
                // إذا بدأ الرقم بصفر، قم بإزالته
                if (substr($phoneNumber, 0, 1) === '0') {
                    $phoneNumber = substr($phoneNumber, 1);
                }
            }

            // حفظ الرسالة بشكل مباشر
            $message = new Message();
            $message->name = $request->name;
            $message->email = $request->email;
            // تخزين رقم الهاتف بمفتاح الدولة (بعد حذف الصفر في البداية إن وجد)
            $message->whatsapp = $country && $phoneNumber ?
                $country->country_code . $phoneNumber : null;
            $message->subject = $request->subject;
            $message->message = $request->message;
            $message->ip_address = $request->ip();
            $message->user_agent = substr($request->userAgent() ?? '', 0, 255);
            $message->is_suspicious = false;
            $message->is_read = false;

            // حفظ الرسالة في قاعدة البيانات
            $success = $message->save();

            // تسجيل نتيجة الحفظ في السجل للتوثيق
            Log::info('Message save attempt', [
                'success' => $success,
                'message_id' => $message->id ?? 'not saved',
                'email' => $request->email,
                'ip' => $request->ip()
            ]);

            if (!$success) {
                throw new \Exception('Failed to save message to database');
            }

            return redirect()->back()->with('success', 'تم إرسال رسالتك بنجاح، سنتواصل معك قريباً!');
        } catch (\Exception $e) {
            // تسجيل الخطأ بالتفصيل في السجلات
            Log::error('Failed to send message - Detailed Error', [
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'ip' => $request->ip(),
                'email' => $request->email ?? 'not_provided',
                'request_data' => $request->except(['_token'])
            ]);

            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء إرسال رسالتك. يرجى المحاولة مرة أخرى.')
                ->withInput();
        }
    }

    /**
     * تحديث حالة عدة رسائل دفعة واحدة
     */
    public function bulkUpdate(Request $request)
    {
        $action = $request->input('action');
        $ids = $request->input('message_ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'الرجاء اختيار رسالة واحدة على الأقل');
        }

        if ($action === 'mark_read') {
            Message::whereIn('id', $ids)->update(['is_read' => true]);
            return redirect()->back()->with('success', 'تم تحديث الرسائل بنجاح');
        } elseif ($action === 'mark_unread') {
            Message::whereIn('id', $ids)->update(['is_read' => false]);
            return redirect()->back()->with('success', 'تم تحديث الرسائل بنجاح');
        } elseif ($action === 'delete') {
            Message::whereIn('id', $ids)->delete();
            return redirect()->back()->with('success', 'تم حذف الرسائل المحددة بنجاح');
        }

        return redirect()->back()->with('error', 'إجراء غير صالح');
    }

    /**
     * الحصول على إحصائيات الرسائل للوحة التحكم
     */
    public function getStats()
    {
        $stats = [
            'total' => Message::count(),
            'read' => Message::where('is_read', true)->count(),
            'unread' => Message::where('is_read', false)->count(),
            'today' => Message::whereDate('created_at', today())->count(),
            'suspicious' => Message::where('is_suspicious', true)->count(),
        ];

        return $stats;
    }

    /**
     * تنظيف وتعقيم البيانات المدخلة
     *
     * @param string $input النص المدخل
     * @param array $allowedTags العلامات المسموح بها (اختياري)
     * @return string النص بعد التنظيف
     */
    protected function sanitizeInput(string $input, array $allowedTags = [])
    {
        // إزالة الأكواد الخطرة والمحتوى الضار
        $allowedTagsString = '';
        if (!empty($allowedTags)) {
            $allowedTagsString = implode('', $allowedTags);
        }

        // تنظيف المدخلات من علامات HTML غير المسموح بها
        $cleaned = strip_tags($input, $allowedTagsString);

        // تحويل الرموز الخاصة إلى كيانات HTML
        $cleaned = htmlspecialchars($cleaned, ENT_QUOTES | ENT_HTML5, 'UTF-8', false);

        // إزالة التعليمات البرمجية المخفية
        $cleaned = preg_replace('/&#?[a-z0-9]+;/i', '', $cleaned);

        // إزالة المسافات المتعددة والأحرف غير المرئية
        $cleaned = preg_replace('/\s+/', ' ', $cleaned);

        return trim($cleaned);
    }

    /**
     * التحقق من وجود علامات تشير إلى محتوى مشبوه
     *
     * @param array $data البيانات المراد فحصها
     * @return array قائمة بالعلامات المشبوهة إن وجدت
     */
    protected function checkForSuspiciousContent(array $data): array
    {
        $flags = [];

        // فحص وجود أنماط مشبوهة في المحتوى
        $nameAndSubject = $data['name'] . ' ' . $data['subject'];

        // التحقق من الروابط المشبوهة في العنوان والاسم
        if (preg_match_all('/https?:\/\/\S+/i', $nameAndSubject, $matches)) {
            $flags[] = 'links_in_name_or_subject';
        }

        // التحقق من وجود كلمات مفتاحية مشبوهة
        $suspiciousWords = [
            'bitcoin',
            'investment',
            'loan',
            'forex',
            'casino',
            'gambling',
            'crypto',
            'wealth',
            'millionaire',
            'earn money',
            'quick money',
            'instant cash',
            'lottery',
            'prize',
            'winner',
            'pills',
            'medicine',
            'pharmacy',
            'discount'
        ];

        foreach ($suspiciousWords as $word) {
            if (stripos($data['message'], $word) !== false || stripos($nameAndSubject, $word) !== false) {
                $flags[] = 'suspicious_keywords';
                break;
            }
        }

        // التحقق من وجود عدد كبير من الروابط
        $urlCount = preg_match_all('/https?:\/\/\S+/i', $data['message']);
        if ($urlCount > 3) {
            $flags[] = 'excessive_urls';
        }

        // التحقق من وجود رسائل متشابهة في الساعة الأخيرة من نفس عنوان IP
        $similarMessagesCount = Message::where('ip_address', $data['ip_address'])
            ->where('created_at', '>=', now()->subHour())
            ->count();

        if ($similarMessagesCount > 1) {
            $flags[] = 'repeated_messages_same_ip';
        }

        return $flags;
    }

    /**
     * عرض نموذج الاتصال مع قائمة الدول
     */
    public function showContactForm()
    {
        // استدعاء الدول النشطة ومرتبة حسب الأهمية
        $countries = Country::active()->sorted()->get();

        return view('contact', compact('countries'));
    }
}
