<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceItem;
use App\Models\ServiceSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $section = ServiceSection::first();
        $items = ServiceItem::orderBy('ordering', 'asc')->get();

        return view('admin.service_section.index', compact('section', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.service-section.index');
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
        ]);

        $data = $request->all();
        $data['is_active'] = $request->boolean('is_active');

        $section = ServiceSection::first();
        if ($section) {
            $section->update($data);
        } else {
            ServiceSection::create($data);
        }

        return redirect()->route('admin.service-section.index')
            ->with('success', 'تم حفظ بيانات قسم الخدمات بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceSection $serviceSection)
    {
        return redirect()->route('admin.service-section.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceSection $serviceSection)
    {
        return view('admin.service_section.edit', compact('serviceSection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceSection $serviceSection)
    {
        return redirect()->route('admin.service-section.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceSection $serviceSection)
    {
        return redirect()->route('admin.service-section.index')
            ->with('error', 'لا يمكن حذف هذا القسم');
    }

    /**
     * Store a new service item
     */
    public function storeItem(Request $request)
    {
        $request->validate([
            'icon' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->except(['image']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('service-items', 'public');
        }

        $section = ServiceSection::first();
        if (!$section) {
            $section = ServiceSection::create([
                'title' => 'قسم الخدمات',
                'description' => 'وصف قسم الخدمات',
                'is_active' => true
            ]);
        }

        $data['service_section_id'] = $section->id;
        $data['is_active'] = $request->boolean('is_active');
        $data['ordering'] = ServiceItem::count() + 1;

        ServiceItem::create($data);

        return redirect()->route('admin.service-section.index')
            ->with('success', 'تمت إضافة خدمة جديدة بنجاح');
    }

    /**
     * Update a service item
     */
    public function updateItem(Request $request, ServiceItem $item)
    {
        // 1️⃣ تحقق من المدخلات
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'description'       => 'nullable|string',
            'icon'              => 'nullable|string|max:255',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        // 2️⃣ تأمين قيمة is_active
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // 3️⃣ رفع الصورة إن وُجدت
        if ($request->hasFile('image')) {
            // احذف القديمة إذا كانت موجودة
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            // خزّن الجديدة
            $validated['image'] = $request
                ->file('image')
                ->store('service-items', 'public');
        }

        // 4️⃣ نفّذ التحديث
        $item->update($validated);

        // 5️⃣ إعادة توجيه مع رسالة نجاح
        return redirect()
            ->route('admin.service-section.index')
            ->with('success', 'تم تحديث الخدمة بنجاح');
    }

    /**
     * Remove a service item
     */
    public function destroyItem(ServiceItem $item)
    {
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return redirect()->route('admin.service-section.index')
            ->with('success', 'تم حذف الخدمة بنجاح');
    }

    /**
     * Update items ordering
     */
    public function updateItemsOrder(Request $request)
    {
        $items = $request->input('items', []);
        foreach ($items as $order => $itemId) {
            ServiceItem::where('id', $itemId)->update(['ordering' => $order + 1]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified service item.
     */
    public function showItem(ServiceItem $item)
    {
        return view('admin.service_section.show_item', compact('item'));
    }

    /**
     * Show the form for editing a service item.
     */
    public function editItem(ServiceItem $item)
    {
        return view('admin.service_section.edit_item', compact('item'));
    }
}
