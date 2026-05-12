<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\ServiceItem;
use App\Models\ContactSection;
use App\Models\HomeSection;
use App\Models\AboutSection;
use App\Models\AboutFeature;
use App\Models\FeatureSection;
use App\Models\ServiceSection;
use App\Models\Testimonial;
use App\Models\PricingSection;
use App\Models\BlogPost;
use App\Models\Country;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // إزالة التحقق من المصادقة للصفحة الرئيسية
        // $this->middleware('auth');
    }

    /**
     * Display the home page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // استدعاء قسم الاتصال
        $contactSection = ContactSection::where('is_active', true)->first();
        if (!$contactSection) {
            $contactSection = ContactSection::first();
        }

        // استدعاء القسم الرئيسي
        $homeSection = HomeSection::where('is_active', true)
            ->orderBy('ordering')
            ->first();

        // استدعاء قسم "نبذة عنا"
        $aboutSection = AboutSection::where('is_active', true)->first();

        // استدعاء قسم المميزات
        $featureSection = FeatureSection::where('is_active', true)->first();

        // استدعاء قسم الخدمات
        $serviceSection = ServiceSection::where('is_active', 1)->first();

        // استدعاء آراء العملاء
        $testimonials = Testimonial::where('is_active', true)->orderBy('ordering')->get();

        // استدعاء قسم الأسعار
        $pricingSection = PricingSection::where('is_active', true)->first();

        // استدعاء أحدث المقالات
        $recentPosts = BlogPost::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // استدعاء الأعمال المميزة من معرض الأعمال
        $featuredPortfolios = \App\Models\Portfolio::active()
            ->featured()
            ->orderBy('display_order', 'asc')
            ->limit(6)
            ->get();

        // استدعاء قائمة الدول لنموذج الاتصال
        $countries = Country::active()->sorted()->get();

        return view('index', compact(
            'contactSection',
            'homeSection',
            'aboutSection',
            'featureSection',
            'serviceSection',
            'testimonials',
            'pricingSection',
            'recentPosts',
            'countries',
            'featuredPortfolios'
        ));
    }

    /**
     * Display the service details page.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function serviceDetails($slug)
    {
        // استخدام ServiceItem بدلاً من Service ليتوافق مع الخدمات في الصفحة الرئيسية
        $service = ServiceItem::findOrFail($slug);

        // الحصول على باقي الخدمات للعرض في قسم "خدمات أخرى"
        $otherServices = ServiceItem::where('id', '!=', $slug)
            ->where('is_active', true)
            ->orderBy('ordering')
            ->take(4)
            ->get();

        // إضافة قسم الاتصال للصفحة
        $contactSection = ContactSection::where('is_active', true)->first();
        if (!$contactSection) {
            $contactSection = ContactSection::first();
        }

        // إضافة الخدمات للشريط الجانبي
        $sidebarServices = ServiceItem::where('is_active', true)
            ->orderBy('ordering')
            ->get();

        return view('service-details', compact('service', 'otherServices', 'contactSection', 'sidebarServices'));
    }

    /**
     * Display a specific page by slug.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function page($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // إضافة قسم الاتصال للصفحة
        $contactSection = ContactSection::where('is_active', true)->first();
        if (!$contactSection) {
            $contactSection = ContactSection::first();
        }

        return view('page', compact('page', 'contactSection'));
    }
}
