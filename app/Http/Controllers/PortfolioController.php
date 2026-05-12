<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    /**
     * عرض صفحة قائمة الأعمال
     */
    public function index(Request $request)
    {
        // إعداد التصنيفات المتاحة
        $categories = Portfolio::active()
            ->select('category')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->toArray();

        // التصنيف المطلوب
        $category = $request->query('category');

        // البحث عن الأعمال
        $query = Portfolio::active()->ordered();

        // تصفية حسب التصنيف
        if ($category) {
            $query->where('category', $category);
        }

        // استرجاع الأعمال بالترقيم
        $portfolios = $query->paginate(9);

        return view('front.portfolio.index', compact('portfolios', 'categories', 'category'));
    }

    /**
     * عرض صفحة تفاصيل العمل
     */
    public function show(Portfolio $portfolio)
    {
        // التأكد من أن العمل نشط
        if (!$portfolio->active) {
            abort(404);
        }

        // استرجاع الأعمال ذات الصلة
        $relatedWorks = $portfolio->related_works;

        return view('front.portfolio.show', compact('portfolio', 'relatedWorks'));
    }

    /**
     * تضمين الأعمال المميزة في الصفحة الرئيسية
     */
    public function featured()
    {
        // استرجاع الأعمال المميزة
        $featuredPortfolios = Portfolio::active()
            ->featured()
            ->ordered()
            ->take(6)
            ->get();

        return view('front.portfolio.featured-section', compact('featuredPortfolios'));
    }
}
