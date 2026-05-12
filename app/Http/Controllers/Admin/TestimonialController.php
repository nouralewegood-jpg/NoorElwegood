<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::orderBy('ordering')->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_position' => 'nullable|string|max:255',
            'quote' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'sometimes|boolean',
            'ordering' => 'required|integer',
        ]);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('testimonials', 'public');
        }
        $data['is_active'] = $request->has('is_active');
        Testimonial::create($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'تم إضافة الشهادة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_position' => 'nullable|string|max:255',
            'quote' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'sometimes|boolean',
            'ordering' => 'required|integer',
        ]);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('testimonials', 'public');
        }
        $data['is_active'] = $request->has('is_active');
        $testimonial->update($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'تم تحديث الشهادة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->image) {
            \Storage::disk('public')->delete($testimonial->image);
        }
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', 'تم حذف الشهادة');
    }
}
