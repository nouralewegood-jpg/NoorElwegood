<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use App\Models\HomeStat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $section = HomeSection::first();
        $stats = HomeStat::orderBy('ordering', 'asc')->get();
        return view('admin.home_section.index', compact('section', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.home-section.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_badge' => 'nullable|string|max:255',
            'main_title_line1' => 'required|string|max:255',
            'main_title_line2' => 'nullable|string|max:255',
            'main_title_line3' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'btn_text' => 'nullable|string|max:255',
            'btn_link' => 'nullable|string|max:255',
            'video_btn_text' => 'nullable|string|max:255',
            'video_link' => 'nullable|string|max:255',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'customer_count' => 'nullable|string|max:255',
            'customer_text' => 'nullable|string',
            'is_active' => 'nullable|boolean'
        ]);

        $data = $request->except(['hero_image']);

        if ($request->hasFile('hero_image')) {
            if ($request->old_hero_image) {
                Storage::disk('public')->delete($request->old_hero_image);
            }
            $data['hero_image'] = $request->file('hero_image')->store('home-section', 'public');
        }

        $data['is_active'] = $request->boolean('is_active');

        $section = HomeSection::first();
        if ($section) {
            $section->update($data);
        } else {
            HomeSection::create($data);
        }

        return redirect()->route('admin.home-section.index')
            ->with('success', 'تم حفظ بيانات قسم الصفحة الرئيسية بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(HomeSection $homeSection)
    {
        return redirect()->route('admin.home-section.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomeSection $homeSection)
    {
        return view('admin.home_section.edit', compact('homeSection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HomeSection $homeSection)
    {
        return redirect()->route('admin.home-section.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomeSection $homeSection)
    {
        return redirect()->route('admin.home-section.index')
            ->with('error', 'لا يمكن حذف هذا القسم');
    }

    /**
     * Store a new stat
     */
    public function storeStat(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        HomeStat::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'icon' => $request->icon,
            'is_active' => $request->boolean('is_active'),
            'ordering' => HomeStat::count() + 1
        ]);

        return redirect()->route('admin.home-section.index')
            ->with('success', 'تمت إضافة الإحصائية بنجاح');
    }

    /**
     * Update a stat
     */
    public function updateStat(Request $request, HomeStat $stat)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $stat->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'icon' => $request->icon,
            'is_active' => $request->boolean('is_active')
        ]);

        return redirect()->route('admin.home-section.index')
            ->with('success', 'تم تحديث الإحصائية بنجاح');
    }

    /**
     * Remove a stat
     */
    public function destroyStat(HomeStat $stat)
    {
        $stat->delete();

        return redirect()->route('admin.home-section.index')
            ->with('success', 'تم حذف الإحصائية بنجاح');
    }

    /**
     * Update stats ordering
     */
    public function updateStatsOrder(Request $request)
    {
        $stats = $request->input('stats', []);
        foreach ($stats as $order => $statId) {
            HomeStat::where('id', $statId)->update(['ordering' => $order + 1]);
        }

        return response()->json(['success' => true]);
    }
}
