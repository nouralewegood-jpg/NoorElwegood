@extends('layouts.master')

@section('title', 'المدونة - ' . config('app.name'))

@section('meta_description', 'مقالات ومدونات احترافية في مختلف المواضيع')
@section('meta_keywords', 'مدونة, مقالات, محتوى, إرشادات، دروس')

@section('content')
    <div class="container py-5 mt-5">
        <!-- رأس الصفحة مع خلفية جذابة -->
        <div class="blog-hero m-5">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center">
                    <h1 class="display-4 fw-bold">مدونتنا</h1>
                    <p class="lead text-muted">اكتشف أحدث المقالات والمحتوى الحصري في مختلف المجالات</p>
                    <nav aria-label="breadcrumb" class="mt-3 justify-content-center d-flex">
                        <ol class="breadcrumb bg-transparent">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none"><i
                                        class="fas fa-home me-1"></i>الرئيسية</a></li>
                            <li class="breadcrumb-item active" aria-current="page">المدونة</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- شريط التصنيفات للتنقل السريع -->
        <div class="category-navbar mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="m-0"><i class="fas fa-th-large me-2"></i>تصفح حسب التصنيف</h5>
                <a href="{{ route('blog.index') }}" class="btn btn-sm btn-outline-primary">جميع المقالات</a>
            </div>
            <div class="categories-scroll">
                <div class="d-flex gap-2 flex-nowrap">
                    @foreach ($categories as $category)
                        <a href="{{ route('blog.category', $category->slug) }}"
                            class="btn btn-outline-secondary category-btn {{ request()->is('blog/category/' . $category->slug) ? 'active' : '' }}">
                            {{ $category->name }}
                            <span class="badge bg-primary rounded-pill ms-1">{{ $category->posts_count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row">
            <!-- قسم المقالات الرئيسي -->
            <div class="col-lg-8">
                <!-- قسم البحث السريع -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <form action="{{ route('blog.search') }}" method="GET" class="blog-search-form">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control"
                                    placeholder="ابحث في المدونة عن موضوع يهمك..." value="{{ request('q') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i> بحث
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @if (count($posts) > 0)
                    <!-- المقال المميز إذا وجد -->
                    @if (isset($featuredPost))
                        <div class="card shadow featured-post mb-4">
                            <div class="row g-0">
                                <div class="col-md-5">
                                    @if ($featuredPost->featured_image)
                                        <img src="{{ $featuredPost->featured_image }}" class="featured-img"
                                            alt="{{ $featuredPost->title }}">
                                    @else
                                        <div
                                            class="featured-img-placeholder d-flex align-items-center justify-content-center bg-light">
                                            <i class="fas fa-newspaper fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-7">
                                    <div class="card-body h-100 d-flex flex-column">
                                        <div class="featured-badge mb-2">
                                            <i class="fas fa-star me-1"></i> مقال مميز
                                        </div>
                                        <h3 class="card-title">
                                            <a href="{{ route('blog.show', $featuredPost->slug) }}"
                                                class="text-decoration-none text-dark">
                                                {{ $featuredPost->title }}
                                            </a>
                                        </h3>
                                        <div class="post-meta text-muted mb-2 small">
                                            <span class="me-3">
                                                <i class="far fa-calendar-alt me-1"></i>
                                                {{ $featuredPost->published_at->format('d M, Y') }}
                                            </span>
                                            <span>
                                                <i class="far fa-folder me-1"></i> <a
                                                    href="{{ route('blog.category', $featuredPost->category->slug) }}"
                                                    class="text-decoration-none">{{ $featuredPost->category->name }}</a>
                                            </span>
                                        </div>
                                        <p class="card-text mb-3">
                                            {{ Str::limit($featuredPost->excerpt ?? strip_tags($featuredPost->content), 150) }}
                                        </p>
                                        <a href="{{ route('blog.show', $featuredPost->slug) }}"
                                            class="btn btn-primary mt-auto">
                                            قراءة المزيد <i class="fas fa-arrow-left ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- عرض المقالات -->
                    <div class="row">
                        @foreach ($posts as $post)
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 shadow-sm blog-card">
                                    <div class="blog-image-wrapper">
                                        @if ($post->featured_image)
                                            <img src="{{ $post->featured_image }}" class="card-img-top"
                                                alt="{{ $post->title }}">
                                        @else
                                            <div
                                                class="blog-img-placeholder d-flex align-items-center justify-content-center">
                                                <i class="fas fa-newspaper fa-3x text-muted"></i>
                                            </div>
                                        @endif
                                        <a href="{{ route('blog.category', $post->category->slug) }}"
                                            class="blog-category">
                                            {{ $post->category->name }}
                                        </a>
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <div class="d-flex justify-content-between mb-2 small text-muted">
                                            <span><i class="far fa-calendar-alt me-1"></i>
                                                {{ $post->published_at->format('d M, Y') }}</span>
                                            <span><i class="far fa-eye me-1"></i> {{ $post->views }}</span>
                                        </div>
                                        <h5 class="card-title">
                                            <a href="{{ route('blog.show', $post->slug) }}"
                                                class="text-decoration-none text-dark blog-title">{{ $post->title }}</a>
                                        </h5>
                                        <p class="card-text text-muted mb-3">
                                            {{ Str::limit($post->excerpt ?? strip_tags($post->content), 120) }}
                                        </p>
                                        <div class="mt-auto">
                                            <a href="{{ route('blog.show', $post->slug) }}" class="read-more">
                                                قراءة المزيد <i class="fas fa-arrow-left ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- التنقل بين الصفحات -->
                    <div class="mt-4 d-flex justify-content-center">
                        <nav aria-label="Page navigation">
                            {{ $posts->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                @else
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="fas fa-info-circle me-2 fa-lg"></i>
                        <div>
                            لم يتم العثور على مقالات حالياً. تابعنا لقراءة المحتوى المميز قريباً.
                        </div>
                    </div>
                @endif
            </div>

            <!-- الشريط الجانبي -->
            <div class="col-lg-4">
                @include('blog.partials.sidebar')
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* تنسيق عام للمدونة */
        .blog-hero {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 3rem 1rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        /* شريط التصنيفات */
        .categories-scroll {
            overflow-x: auto;
            padding: 0.5rem 0;
            scrollbar-width: thin;
        }

        .categories-scroll::-webkit-scrollbar {
            height: 4px;
        }

        .categories-scroll::-webkit-scrollbar-thumb {
            background-color: #6c757d;
            border-radius: 4px;
        }

        .category-btn {
            white-space: nowrap;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            border-radius: 20px;
        }

        .category-btn.active {
            background-color: #404770;
            color: #fff;
        }

        /* بطاقات المقالات */
        .blog-card {
            transition: all 0.3s ease;
            border-radius: 10px;
            overflow: hidden;
        }

        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .blog-image-wrapper {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .blog-image-wrapper img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            transition: all 0.5s ease;
        }

        .blog-card:hover .blog-image-wrapper img {
            transform: scale(1.05);
        }

        .blog-category {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: rgba(64, 71, 112, 0.85);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .blog-category:hover {
            background-color: #353963;
            color: white;
        }

        .blog-title {
            display: block;
            transition: color 0.3s ease;
        }

        .blog-title:hover {
            color: #F59C27 !important;
        }

        .read-more {
            color: #F59C27;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .read-more:hover {
            transform: translateX(-5px);
            color: #e08918;
        }

        /* المقال المميز */
        .featured-post {
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 2rem;
            border: none;
        }

        .featured-img,
        .featured-img-placeholder {
            height: 100%;
            width: 100%;
            min-height: 250px;
            object-fit: cover;
        }

        .featured-badge {
            background-color: #ffc107;
            color: #212529;
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-weight: 500;
        }

        /* التأثيرات البصرية */
        .blog-search-form .form-control {
            border-radius: 20px 0 0 20px;
            padding-right: 15px;
        }

        .blog-search-form .btn {
            border-radius: 0 20px 20px 0;
        }

        .blog-img-placeholder {
            height: 200px;
            background-color: #f8f9fa;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // لإضافة تأثيرات إضافية
        document.addEventListener('DOMContentLoaded', function() {
            // تأثير عند التمرير للأقسام
            const sections = document.querySelectorAll('.card');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                    }
                });
            }, {
                threshold: 0.1
            });

            sections.forEach(section => {
                observer.observe(section);
            });

            // تنسيق أزرار التصنيفات
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.addEventListener('mouseover', function() {
                    this.classList.add('shadow-sm');
                });

                btn.addEventListener('mouseout', function() {
                    this.classList.remove('shadow-sm');
                });
            });
        });
    </script>
@endpush
