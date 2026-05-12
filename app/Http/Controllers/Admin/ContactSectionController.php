<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSection;
use Illuminate\Http\Request;

class ContactSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $section = ContactSection::first();
        if (!$section) {
            // إنشاء سجل افتراضي إذا لم يكن هناك سجل موجود
            $section = ContactSection::create([
                'title' => 'قسم الاتصال',
                'description' => 'يمكنك تعديل بيانات قسم الاتصال من هنا',
                'address' => 'عنوان الشركة هنا',
                'phone' => '0123456789',
                'email' => 'info@example.com',
                'is_active' => true
            ]);
        }
        return view('admin.contact_section.index', compact('section'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.contact-section.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'map_lat' => 'nullable|string|max:255',
            'map_lng' => 'nullable|string|max:255',
            'map_zoom' => 'nullable|string|max:255',
            'social_facebook' => 'nullable|string|max:255',
            'social_twitter' => 'nullable|string|max:255',
            'social_instagram' => 'nullable|string|max:255',
            'social_linkedin' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->boolean('is_active');

        $section = ContactSection::first();
        if ($section) {
            $section->update($data);
        } else {
            ContactSection::create($data);
        }

        return redirect()->route('admin.contact-section.index')
            ->with('success', 'تم حفظ بيانات قسم الاتصال بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactSection $contactSection)
    {
        return redirect()->route('admin.contact-section.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactSection $contactSection)
    {
        return view('admin.contact_section.edit', compact('contactSection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactSection $contactSection)
    {
        return redirect()->route('admin.contact-section.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactSection $contactSection)
    {
        return redirect()->route('admin.contact-section.index')
            ->with('error', 'لا يمكن حذف هذا القسم');
    }
}
