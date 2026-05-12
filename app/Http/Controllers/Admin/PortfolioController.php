<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the portfolio items.
     */
    public function index()
    {
        $portfolios = Portfolio::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.portfolio.index', compact('portfolios'));
    }

    /**
     * Show the form for creating a new portfolio item.
     */
    public function create()
    {
        return view('admin.portfolio.create');
    }

    /**
     * Store a newly created portfolio item in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'client_name' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'project_date' => 'nullable|date',
            'tags' => 'nullable|string|max:255',
            'display_order' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('portfolio', 'public');
            $validated['image'] = $imagePath;
        }

        // معالجة صور المعرض (gallery)
        $galleryImages = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $galleryImage) {
                $path = $galleryImage->store('portfolio/gallery', 'public');
                $galleryImages[] = $path;
            }
            $validated['gallery'] = $galleryImages;
        }

        // Generate a slug from the title
        $validated['slug'] = Str::slug($validated['title']);

        Portfolio::create($validated);

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'تم إضافة المشروع بنجاح');
    }

    /**
     * Display the specified portfolio item.
     */
    public function show(Portfolio $portfolio)
    {
        return view('admin.portfolio.show', compact('portfolio'));
    }

    /**
     * Show the form for editing the specified portfolio item.
     */
    public function edit(Portfolio $portfolio)
    {
        return view('admin.portfolio.edit', compact('portfolio'));
    }

    /**
     * Update the specified portfolio item in storage.
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'client_name' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'project_date' => 'nullable|date',
            'tags' => 'nullable|string|max:255',
            'display_order' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($portfolio->image && Storage::disk('public')->exists($portfolio->image)) {
                Storage::disk('public')->delete($portfolio->image);
            }

            // Store the new image
            $imagePath = $request->file('image')->store('portfolio', 'public');
            $validated['image'] = $imagePath;
        }

        // معالجة صور المعرض (gallery)
        if ($request->hasFile('gallery')) {
            $galleryImages = $portfolio->gallery ?: [];

            foreach ($request->file('gallery') as $galleryImage) {
                $path = $galleryImage->store('portfolio/gallery', 'public');
                $galleryImages[] = $path;
            }

            $validated['gallery'] = $galleryImages;
        }

        // معالجة حذف الصور من المعرض
        if ($request->has('remove_gallery') && is_array($request->remove_gallery)) {
            $galleryImages = $portfolio->gallery ?: [];
            $newGallery = [];

            foreach ($galleryImages as $index => $image) {
                if (!in_array($index, $request->remove_gallery)) {
                    $newGallery[] = $image;
                } else {
                    // حذف الملف الفعلي
                    Storage::disk('public')->delete($image);
                }
            }

            $validated['gallery'] = $newGallery;
        }

        // Update the slug if the title has changed
        if ($portfolio->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $portfolio->update($validated);

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'تم تحديث المشروع بنجاح');
    }

    /**
     * Remove the specified portfolio item from storage.
     */
    public function destroy(Portfolio $portfolio)
    {
        // Delete the image if it exists
        if ($portfolio->image && Storage::disk('public')->exists($portfolio->image)) {
            Storage::disk('public')->delete($portfolio->image);
        }

        $portfolio->delete();

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'تم حذف المشروع بنجاح');
    }
}
