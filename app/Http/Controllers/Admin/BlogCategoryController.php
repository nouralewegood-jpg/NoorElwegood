<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = BlogCategory::ordered()->paginate(10);

        return view('admin.blog.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $category = new BlogCategory();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;
        $category->meta_title = $request->meta_title ?? $request->name;
        $category->meta_description = $request->meta_description ?? $request->description;
        $category->meta_keywords = $request->meta_keywords;
        $category->is_active = $request->has('is_active');
        $category->order = $request->order ?? 0;
        $category->save();

        return redirect()->route('admin.blog.categories.index')
            ->with('success', 'تم إضافة الفئة بنجاح!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = BlogCategory::with('posts')->findOrFail($id);

        return view('admin.blog.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = BlogCategory::findOrFail($id);

        return view('admin.blog.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $category = BlogCategory::findOrFail($id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;
        $category->meta_title = $request->meta_title ?? $request->name;
        $category->meta_description = $request->meta_description ?? $request->description;
        $category->meta_keywords = $request->meta_keywords;
        $category->is_active = $request->has('is_active');
        $category->order = $request->order ?? 0;
        $category->save();

        return redirect()->route('admin.blog.categories.index')
            ->with('success', 'تم تحديث الفئة بنجاح!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = BlogCategory::findOrFail($id);

        // التحقق مما إذا كان هناك مقالات مرتبطة بهذه الفئة
        if ($category->posts->count() > 0) {
            return redirect()->route('admin.blog.categories.index')
                ->with('error', 'لا يمكن حذف هذه الفئة لأنها تحتوي على مقالات مرتبطة بها!');
        }

        $category->delete();

        return redirect()->route('admin.blog.categories.index')
            ->with('success', 'تم حذف الفئة بنجاح!');
    }
}
