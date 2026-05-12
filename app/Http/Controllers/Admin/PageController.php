<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the pages.
     */
    public function index()
    {
        $pages = Page::orderBy('sort_order')->paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new page.
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created page in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages',
            'content' => 'required',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        // Handle slug
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle featured image
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('pages', 'public');
            $validated['featured_image'] = $path;
        }

        // Set default values
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_published'] = $request->has('is_published');

        Page::create($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page created successfully!');
    }

    /**
     * Display the specified page.
     */
    public function show(Page $page)
    {
        return view('admin.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified page.
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified page in storage.
     */
    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
            'content' => 'required',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        // Handle slug
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle featured image
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($page->featured_image) {
                Storage::disk('public')->delete($page->featured_image);
            }

            $path = $request->file('featured_image')->store('pages', 'public');
            $validated['featured_image'] = $path;
        }

        // Set default values
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_published'] = $request->has('is_published');

        $page->update($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully!');
    }

    /**
     * Remove the specified page from storage.
     */
    public function destroy(Page $page)
    {
        // Delete featured image if exists
        if ($page->featured_image) {
            Storage::disk('public')->delete($page->featured_image);
        }

        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page deleted successfully!');
    }
}
