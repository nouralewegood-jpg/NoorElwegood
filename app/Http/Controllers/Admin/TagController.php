<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::withCount('posts')->paginate(20);

        return view('admin.blog.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
        ]);

        $tag = new Tag();
        $tag->name = $request->name;
        $tag->slug = Str::slug($request->name);
        $tag->save();

        return redirect()->route('admin.blog.tags.index')
            ->with('success', 'تم إضافة الوسم بنجاح!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tag = Tag::with('posts')->findOrFail($id);

        return view('admin.blog.tags.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tag = Tag::findOrFail($id);

        return view('admin.blog.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $id,
        ]);

        $tag = Tag::findOrFail($id);
        $tag->name = $request->name;
        $tag->slug = Str::slug($request->name);
        $tag->save();

        return redirect()->route('admin.blog.tags.index')
            ->with('success', 'تم تحديث الوسم بنجاح!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tag = Tag::findOrFail($id);

        // فصل العلاقة مع جميع المقالات قبل الحذف
        $tag->posts()->detach();
        $tag->delete();

        return redirect()->route('admin.blog.tags.index')
            ->with('success', 'تم حذف الوسم بنجاح!');
    }
}
