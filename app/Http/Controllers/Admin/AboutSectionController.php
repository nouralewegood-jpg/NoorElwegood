<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutFeature;
use App\Models\AboutSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AboutSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $section = AboutSection::first();
        $features = AboutFeature::orderBy('ordering', 'asc')->get();
        return view('admin.about_section.index', compact('section', 'features'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.about-section.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'meta_text' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'secondary_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'ceo_name' => 'nullable|string|max:255',
            'ceo_position' => 'nullable|string|max:255',
            'ceo_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'phone_label' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'years_experience' => 'nullable|string|max:255',
            'experience_text' => 'nullable|string',
        ]);

        $data = $request->except(['main_image', 'secondary_image', 'ceo_image']);

        // التأكد من وجود مجلد التخزين
        $storage_path = storage_path('app/public/about-section');
        if (!File::exists($storage_path)) {
            File::makeDirectory($storage_path, 0755, true);
        }

        if ($request->hasFile('main_image')) {
            if ($request->old_main_image && Storage::disk('public')->exists($request->old_main_image)) {
                Storage::disk('public')->delete($request->old_main_image);
            }
            $data['main_image'] = $request->file('main_image')->store('about-section', 'public');
        }

        if ($request->hasFile('secondary_image')) {
            if ($request->old_secondary_image && Storage::disk('public')->exists($request->old_secondary_image)) {
                Storage::disk('public')->delete($request->old_secondary_image);
            }
            $data['secondary_image'] = $request->file('secondary_image')->store('about-section', 'public');
        }

        if ($request->hasFile('ceo_image')) {
            if ($request->old_ceo_image) {
                Storage::disk('public')->delete($request->old_ceo_image);
            }
            $data['ceo_image'] = $request->file('ceo_image')->store('about-section', 'public');
        }

        $data['is_active'] = $request->boolean('is_active');

        $section = AboutSection::first();
        if ($section) {
            $section->update($data);
        } else {
            AboutSection::create($data);
        }

        return redirect()->route('admin.about-section.index')
            ->with('success', 'تم حفظ بيانات قسم "من نحن" بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(AboutSection $aboutSection)
    {
        return redirect()->route('admin.about-section.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AboutSection $aboutSection)
    {
        return view('admin.about_section.edit', compact('aboutSection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AboutSection $aboutSection)
    {
        return redirect()->route('admin.about-section.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AboutSection $aboutSection)
    {
        return redirect()->route('admin.about-section.index')
            ->with('error', 'لا يمكن حذف هذا القسم');
    }

    /**
     * Store a new feature
     */
    public function storeFeature(Request $request)
    {
        $request->validate([
            'feature_text' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        // الحصول على قسم "من نحن" الحالي أو إنشاء واحد جديد إذا لم يكن موجودًا
        $section = AboutSection::first();
        if (!$section) {
            $section = AboutSection::create([
                'title' => 'من نحن',
                'is_active' => true
            ]);
        }

        AboutFeature::create([
            'about_section_id' => $section->id, // ربط الميزة بقسم "من نحن"
            'feature_text' => $request->feature_text,
            'is_active' => $request->boolean('is_active'),
            'ordering' => AboutFeature::count() + 1
        ]);

        return redirect()->route('admin.about-section.index')
            ->with('success', 'تمت إضافة الميزة بنجاح');
    }

    /**
     * Update a feature
     */
    public function updateFeature(Request $request, AboutFeature $feature)
    {
        $request->validate([
            'feature_text' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $feature->update([
            'feature_text' => $request->feature_text,
            'is_active' => $request->boolean('is_active')
        ]);

        return redirect()->route('admin.about-section.index')
            ->with('success', 'تم تحديث الميزة بنجاح');
    }

    /**
     * Remove a feature
     */
    public function destroyFeature(AboutFeature $feature)
    {
        $feature->delete();

        return redirect()->route('admin.about-section.index')
            ->with('success', 'تم حذف الميزة بنجاح');
    }

    /**
     * Update features ordering
     */
    public function updateFeaturesOrder(Request $request)
    {
        $features = $request->input('features', []);
        foreach ($features as $order => $featureId) {
            AboutFeature::where('id', $featureId)->update(['ordering' => $order + 1]);
        }

        return response()->json(['success' => true]);
    }
}
