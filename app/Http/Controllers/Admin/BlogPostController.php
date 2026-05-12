<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = BlogPost::with(['category', 'user'])
            ->latest()
            ->paginate(10);

        return view('admin.blog.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::active()->ordered()->get();
        $tags = Tag::all();

        return view('admin.blog.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'content' => 'required',
            'excerpt' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'is_published' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $post = new BlogPost();
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->user_id = Auth::id();
        $post->blog_category_id = $request->blog_category_id;
        $post->excerpt = $request->excerpt;
        $post->content = $request->content;
        $post->meta_title = $request->meta_title ?? $request->title;
        $post->meta_description = $request->meta_description ?? Str::limit(strip_tags($request->content), 160);
        $post->meta_keywords = $request->meta_keywords;
        $post->is_published = $request->has('is_published');
        $post->published_at = $request->has('is_published') ? now() : null;

        // معالجة الصورة المميزة إذا تم تحميلها
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/blog/images', $filename);
            $post->featured_image = Storage::url($path);
        }

        $post->save();

        // إضافة الوسوم إذا تم تحديدها
        if ($request->has('tags')) {
            $post->tags()->attach($request->tags);
        }

        return redirect()->route('admin.blog.posts.index')
            ->with('success', 'تم إضافة المقالة بنجاح!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = BlogPost::with(['category', 'user', 'tags'])->findOrFail($id);

        return view('admin.blog.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = BlogPost::with('tags')->findOrFail($id);
        $categories = BlogCategory::active()->ordered()->get();
        $tags = Tag::all();
        $selectedTags = $post->tags->pluck('id')->toArray();

        return view('admin.blog.posts.edit', compact('post', 'categories', 'tags', 'selectedTags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'content' => 'required',
            'excerpt' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'is_published' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $post = BlogPost::findOrFail($id);
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->blog_category_id = $request->blog_category_id;
        $post->excerpt = $request->excerpt;
        $post->content = $request->content;
        $post->meta_title = $request->meta_title ?? $request->title;
        $post->meta_description = $request->meta_description ?? Str::limit(strip_tags($request->content), 160);
        $post->meta_keywords = $request->meta_keywords;

        // تحديث حالة النشر إذا تغيرت
        if ($request->has('is_published') && !$post->is_published) {
            $post->is_published = true;
            $post->published_at = now();
        } elseif (!$request->has('is_published') && $post->is_published) {
            $post->is_published = false;
        }

        // معالجة الصورة المميزة إذا تم تحميلها
        if ($request->hasFile('featured_image')) {
            // حذف الصورة القديمة إذا وجدت
            if ($post->featured_image) {
                $oldImagePath = str_replace('/storage/', 'public/', $post->featured_image);
                Storage::delete($oldImagePath);
            }

            $image = $request->file('featured_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/blog/images', $filename);
            $post->featured_image = Storage::url($path);
        }

        $post->save();

        // تحديث الوسوم
        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->detach();
        }

        return redirect()->route('admin.blog.posts.index')
            ->with('success', 'تم تحديث المقالة بنجاح!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = BlogPost::findOrFail($id);

        // حذف الصورة المميزة إذا وجدت
        if ($post->featured_image) {
            $imagePath = str_replace('/storage/', 'public/', $post->featured_image);
            Storage::delete($imagePath);
        }

        $post->delete();

        return redirect()->route('admin.blog.posts.index')
            ->with('success', 'تم حذف المقالة بنجاح!');
    }
}
