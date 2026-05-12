<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeatureItem;
use App\Models\FeatureSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeatureSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $section = FeatureSection::first();
        $items = FeatureItem::orderBy('ordering', 'asc')->get();
        $tabs = FeatureItem::select('tab_name')->distinct()->pluck('tab_name')->toArray();

        return view('admin.feature_section.index', compact('section', 'items', 'tabs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.feature-section.index');
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

        $section = FeatureSection::first();
        if ($section) {
            $section->update($data);
        } else {
            $section = FeatureSection::create($data);
        }

        return redirect()->route('admin.feature-section.index')
            ->with('success', 'تم حفظ بيانات قسم الميزات بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(FeatureSection $featureSection)
    {
        return redirect()->route('admin.feature-section.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FeatureSection $featureSection)
    {
        return view('admin.feature_section.edit', compact('featureSection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FeatureSection $featureSection)
    {
        return redirect()->route('admin.feature-section.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FeatureSection $featureSection)
    {
        return redirect()->route('admin.feature-section.index')
            ->with('error', 'لا يمكن حذف هذا القسم');
    }

    /**
     * Store a new feature item
     */
    public function storeItem(Request $request)
    {
        $request->validate([
            'tab_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'icon' => 'nullable|string|max:255',
        ]);

        $data = $request->except(['image']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('feature-items', 'public');
        }

        $section = FeatureSection::first();
        if (!$section) {
            $section = FeatureSection::create([
                'title' => 'قسم الميزات',
                'description' => 'وصف قسم الميزات',
                'is_active' => true
            ]);
        }

        $data['feature_section_id'] = $section->id;
        $data['is_active'] = $request->boolean('is_active');
        $data['ordering'] = FeatureItem::count() + 1;

        FeatureItem::create($data);

        return redirect()->route('admin.feature-section.index')
            ->with('success', 'تمت إضافة ميزة جديدة بنجاح');
    }

    /**
     * Update a feature item
     */
    public function updateItem(Request $request, FeatureItem $item)
    {
        $request->validate([
            'tab_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->except(['image', 'current_image_path']);

        if ($request->hasFile('image')) {
            // إذا تم تحميل صورة جديدة، احذف الصورة القديمة وقم بتخزين الصورة الجديدة
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $data['image'] = $request->file('image')->store('feature-items', 'public');
        } else {
            // إذا لم يتم تحميل صورة جديدة، استخدم الصورة القديمة كما هي
            $data['image'] = $item->image;
        }

        $data['is_active'] = $request->boolean('is_active');

        $item->update($data);

        return redirect()->route('admin.feature-section.index')
            ->with('success', 'تم تحديث الميزة بنجاح');
    }

    /**
     * Remove a feature item
     */
    public function destroyItem(FeatureItem $item)
    {
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return redirect()->route('admin.feature-section.index')
            ->with('success', 'تم حذف الميزة بنجاح');
    }

    /**
     * Update items ordering
     */
    public function updateItemsOrder(Request $request)
    {
        $items = $request->input('items', []);
        foreach ($items as $order => $itemId) {
            FeatureItem::where('id', $itemId)->update(['ordering' => $order + 1]);
        }

        return response()->json(['success' => true]);
    }
}
