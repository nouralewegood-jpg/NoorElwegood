<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * عرض صفحة المدونة الرئيسية مع المقالات
     */
    public function index(Request $request)
    {
        $posts = BlogPost::with(['category', 'user', 'tags'])
            ->published()
            ->recent()
            ->paginate(9);

        $categories = BlogCategory::active()->ordered()->withCount('posts')->get();
        $popularPosts = BlogPost::published()->popular()->limit(5)->get();
        $tags = Tag::withCount('posts')->limit(20)->get();

        return view('blog.index', compact('posts', 'categories', 'popularPosts', 'tags'));
    }

    /**
     * عرض مقالة محددة
     */
    public function show($slug)
    {
        $post = BlogPost::with(['category', 'user', 'tags'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        // زيادة عدد المشاهدات
        $post->recordView();

        $relatedPosts = $post->getRelatedPosts();
        $categories = BlogCategory::active()->ordered()->withCount('posts')->get();
        $tags = Tag::withCount('posts')->limit(20)->get();
        $popularPosts = BlogPost::published()->popular()->limit(5)->get();

        return view('blog.show', compact('post', 'relatedPosts', 'categories', 'tags', 'popularPosts'));
    }

    /**
     * عرض المقالات حسب الفئة
     */
    public function category($slug)
    {
        $category = BlogCategory::where('slug', $slug)->active()->firstOrFail();

        $posts = BlogPost::with(['category', 'user', 'tags'])
            ->where('blog_category_id', $category->id)
            ->published()
            ->recent()
            ->paginate(9);

        // إضافة كل التصنيفات لاستخدامها في شريط التنقل
        $allCategories = BlogCategory::active()->ordered()->withCount('posts')->get();
        $categories = $allCategories; // للتوافق مع الشريط الجانبي
        $popularPosts = BlogPost::published()->popular()->limit(5)->get();
        $tags = Tag::withCount('posts')->limit(20)->get();

        return view('blog.category', compact('category', 'posts', 'categories', 'popularPosts', 'tags', 'allCategories'));
    }

    /**
     * عرض المقالات حسب الوسم
     */
    public function tag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        $posts = $tag->posts()
            ->with(['category', 'user', 'tags'])
            ->published()
            ->recent()
            ->paginate(9);

        $categories = BlogCategory::active()->ordered()->withCount('posts')->get();
        $popularPosts = BlogPost::published()->popular()->limit(5)->get();
        $tags = Tag::withCount('posts')->limit(20)->get();

        // إضافة الوسوم الشائعة للتنقل السريع
        $popularTags = Tag::withCount('posts')->orderBy('posts_count', 'desc')->limit(10)->get();

        return view('blog.tag', compact('tag', 'posts', 'categories', 'popularPosts', 'tags', 'popularTags'));
    }

    /**
     * البحث في المقالات
     */
    public function search(Request $request)
    {
        $query = trim($request->input('q'));

        // التأكد من أن استعلام البحث مشفر بشكل صحيح
        $query = mb_convert_encoding($query, 'UTF-8', mb_detect_encoding($query));

        if (empty($query)) {
            return redirect()->route('blog.index');
        }

        $postsQuery = BlogPost::with(['category', 'user', 'tags'])
            ->published();

        // استخدام استعلام أكثر تحسينًا للبحث
        $postsQuery->where(function ($q) use ($query) {
            $q->where('title', 'like', "%{$query}%")
                ->orWhere('content', 'like', "%{$query}%")
                ->orWhere('excerpt', 'like', "%{$query}%");
        });

        // إضافة تصفية حسب التصنيف إذا تم تحديده
        if ($request->filled('category')) {
            $postsQuery->where('blog_category_id', $request->input('category'));
        }

        // ترتيب النتائج
        switch ($request->input('sort')) {
            case 'oldest':
                $postsQuery->oldest();
                break;
            case 'popular':
                $postsQuery->orderBy('views', 'desc');
                break;
            default:
                $postsQuery->recent();
                break;
        }

        $posts = $postsQuery->paginate(9);

        $categories = BlogCategory::active()->ordered()->withCount('posts')->get();
        $popularPosts = BlogPost::published()->popular()->limit(5)->get();
        $tags = Tag::withCount('posts')->limit(20)->get();
        $popularCategories = BlogCategory::active()->withCount('posts')->orderBy('posts_count', 'desc')->take(10)->get();

        return view('blog.search', compact('posts', 'categories', 'popularPosts', 'tags', 'query', 'popularCategories'));
    }

    /**
     * معالجة طلبات POST لصفحات المقالات
     * يمكن استخدام هذه الدالة لمعالجة التعليقات أو التفاعلات الأخرى
     */
    public function handlePostRequest(Request $request, $slug)
    {
        $post = BlogPost::with(['category', 'user', 'tags'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        // هنا يمكنك معالجة بيانات الطلب حسب احتياجات التطبيق
        // على سبيل المثال: إضافة تعليق، إضافة تقييم، إلخ...

        // بعد معالجة الطلب، قم بإعادة التوجيه إلى صفحة المقال مع رسالة تأكيد
        return redirect()->route('blog.show', $slug)->with('success', 'تمت العملية بنجاح');
    }

    /**
     * معالجة طلبات POST لصفحات الوسوم
     * يمكن استخدام هذه الدالة لمعالجة التفاعلات أو التصفية
     */
    public function handleTagPostRequest(Request $request, $slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        // هنا يمكنك معالجة بيانات الطلب حسب احتياجات التطبيق
        // على سبيل المثال: تصفية المقالات حسب معايير معينة

        // بعد معالجة الطلب، قم بإعادة التوجيه إلى صفحة الوسم مع رسالة تأكيد أو البيانات المطلوبة
        return redirect()->route('blog.tag', $slug)->with('success', 'تمت العملية بنجاح');
    }
}
