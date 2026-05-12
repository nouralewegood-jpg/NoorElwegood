<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of the services.
     */
    public function index()
    {
        $services = Service::orderBy('sort_order')->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created service in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services',
            'icon' => 'nullable|string|max:100',
            'short_description' => 'required|string|max:500',
            'content' => 'required',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        // Handle slug
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle featured image
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('services', 'public');
            $validated['featured_image'] = $path;
        }

        // Set checkbox fields
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_published'] = $request->has('is_published');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Service::create($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully!');
    }

    /**
     * Display the specified service.
     */
    public function show(Service $service)
    {
        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified service in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug,' . $service->id,
            'icon' => 'nullable|string|max:100',
            'short_description' => 'required|string|max:500',
            'content' => 'required',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        // Handle slug
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle featured image
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($service->featured_image) {
                Storage::disk('public')->delete($service->featured_image);
            }

            $path = $request->file('featured_image')->store('services', 'public');
            $validated['featured_image'] = $path;
        }

        // Set checkbox fields
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_published'] = $request->has('is_published');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully!');
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy(Service $service)
    {
        // Delete featured image if exists
        if ($service->featured_image) {
            Storage::disk('public')->delete($service->featured_image);
        }

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully!');
    }
}
