<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingFeature;
use App\Models\PricingPlan;
use App\Models\PricingSection;
use Illuminate\Http\Request;

class PricingSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $section = PricingSection::first();
        $plans = PricingPlan::orderBy('ordering', 'asc')->get();

        return view('admin.pricing_section.index', compact('section', 'plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.pricing-section.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->boolean('is_active');

        $section = PricingSection::first();
        if ($section) {
            $section->update($data);
        } else {
            PricingSection::create($data);
        }

        return redirect()->route('admin.pricing-section.index')
            ->with('success', 'تم حفظ بيانات قسم التسعير بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(PricingSection $pricingSection)
    {
        return redirect()->route('admin.pricing-section.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PricingSection $pricingSection)
    {
        return view('admin.pricing_section.edit', compact('pricingSection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PricingSection $pricingSection)
    {
        return redirect()->route('admin.pricing-section.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PricingSection $pricingSection)
    {
        return redirect()->route('admin.pricing-section.index')
            ->with('error', 'لا يمكن حذف هذا القسم');
    }

    /**
     * Store a new pricing plan
     */
    public function storePlan(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'currency' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'btn_text' => 'nullable|string|max:255',
            'btn_url' => 'nullable|string|max:255',
        ]);

        $section = PricingSection::first();
        if (!$section) {
            $section = PricingSection::create([
                'title' => 'قسم التسعير',
                'description' => 'وصف قسم التسعير',
                'is_active' => true
            ]);
        }

        PricingPlan::create([
            'pricing_section_id' => $section->id,
            'plan_name' => $request->title,
            'price' => $request->price,
            'currency' => $request->currency,
            'price_period' => $request->duration,
            'is_featured' => $request->boolean('is_featured'),
            'btn_text' => $request->btn_text,
            'btn_link' => $request->btn_url,
            'is_active' => $request->boolean('is_active'),
            'ordering' => PricingPlan::count() + 1
        ]);

        return redirect()->route('admin.pricing-section.index')
            ->with('success', 'تمت إضافة خطة تسعير جديدة بنجاح');
    }

    /**
     * Show pricing plan details
     */
    public function showPlan(PricingPlan $plan)
    {
        $features = $plan->features()->orderBy('ordering', 'asc')->get();
        return view('admin.pricing_section.plan', compact('plan', 'features'));
    }

    /**
     * Update a pricing plan
     */
    public function updatePlan(Request $request, PricingPlan $plan)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'currency' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'btn_text' => 'nullable|string|max:255',
            'btn_url' => 'nullable|string|max:255',
        ]);

        $plan->update([
            'plan_name' => $request->title,
            'price' => $request->price,
            'price_period' => $request->duration,
            'currency' => $request->currency,
            'is_featured' => $request->boolean('is_featured'),
            'btn_text' => $request->btn_text,
            'btn_link' => $request->btn_url,
            'is_active' => $request->boolean('is_active')
        ]);

        return redirect()->route('admin.pricing-section.index')
            ->with('success', 'تم تحديث خطة التسعير بنجاح');
    }

    /**
     * Remove a pricing plan
     */
    public function destroyPlan(PricingPlan $plan)
    {
        $plan->features()->delete(); // حذف جميع ميزات الخطة أولاً
        $plan->delete();

        return redirect()->route('admin.pricing-section.index')
            ->with('success', 'تم حذف خطة التسعير بنجاح');
    }

    /**
     * Store a new pricing feature
     */
    public function storePlanFeature(Request $request, PricingPlan $plan)
    {
        $request->validate([
            'feature_text' => 'required|string|max:255',
        ]);

        PricingFeature::create([
            'pricing_plan_id' => $plan->id,
            'feature_text' => $request->feature_text,
            'is_included' => $request->has('is_included'),
            'ordering' => $plan->features()->count() + 1
        ]);

        return redirect()->route('admin.pricing-section.plans.show', $plan->id)
            ->with('success', 'تمت إضافة ميزة جديدة للخطة بنجاح');
    }

    /**
     * Update a pricing feature
     */
    public function updatePlanFeature(Request $request, PricingPlan $plan, PricingFeature $feature)
    {
        $request->validate([
            'feature_text' => 'required|string|max:255',
        ]);

        $feature->update([
            'feature_text' => $request->feature_text,
            'is_included' => $request->has('is_included')
        ]);

        return redirect()->route('admin.pricing-section.plans.show', $plan->id)
            ->with('success', 'تم تحديث ميزة الخطة بنجاح');
    }

    /**
     * Remove a pricing feature
     */
    public function destroyPlanFeature(PricingPlan $plan, PricingFeature $feature)
    {
        $feature->delete();

        return redirect()->route('admin.pricing-section.plans.show', $plan->id)
            ->with('success', 'تم حذف ميزة الخطة بنجاح');
    }

    /**
     * Update plans ordering
     */
    public function updatePlansOrder(Request $request)
    {
        $plans = $request->input('plans', []);
        foreach ($plans as $order => $planId) {
            PricingPlan::where('id', $planId)->update(['ordering' => $order + 1]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Update plan features ordering
     */
    public function updatePlanFeaturesOrder(Request $request, PricingPlan $plan)
    {
        $features = $request->input('features', []);
        foreach ($features as $order => $featureId) {
            PricingFeature::where('id', $featureId)->update(['ordering' => $order + 1]);
        }

        return response()->json(['success' => true]);
    }
}
