<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TermsOfService;

class TermsOfServiceController extends Controller
{
    /**
     * عرض صفحة شروط الخدمة
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $termsOfService = TermsOfService::where('is_active', true)
            ->latest('last_updated_at')
            ->first();

        if (!$termsOfService) {
            // إذا لم يتم العثور على شروط خدمة نشطة، قم بإنشاء واحدة افتراضية
            $termsOfService = new TermsOfService([
                'title' => 'شروط الخدمة',
                'content' => '',
                'is_active' => true,
                'last_updated_at' => now(),
            ]);
        }

        // ضبط عناوين SEO إذا كانت موجودة
        $metaTitle = $termsOfService->meta_title ?? 'شروط الخدمة | ' . config('app.name');
        $metaDescription = $termsOfService->meta_description ?? 'شروط وأحكام استخدام خدمات ' . config('app.name');

        return view('terms-of-service', compact('termsOfService', 'metaTitle', 'metaDescription'));
    }
}
