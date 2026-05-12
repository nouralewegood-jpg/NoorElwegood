<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    /**
     * عرض صفحة سياسة الخصوصية
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // الحصول على أحدث سياسة خصوصية نشطة
        $privacyPolicy = PrivacyPolicy::where('is_active', true)
            ->latest('last_updated_at')
            ->first();

        // إذا لم يتم العثور على سياسة خصوصية، قم بإنشاء واحدة افتراضية
        if (!$privacyPolicy) {
            $privacyPolicy = new PrivacyPolicy([
                'title' => 'سياسة الخصوصية',
                'content' => 'محتوى سياسة الخصوصية الافتراضية. يرجى تعديل هذا المحتوى من لوحة التحكم.',
                'is_active' => true,
                'last_updated_at' => now(),
            ]);
        }

        return view('privacy-policy', compact('privacyPolicy'));
    }
}
