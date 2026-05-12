@extends('layouts.master')

@section('title', 'الوسم: ' . $tag->name . ' - ' . config('app.name'))
@section('meta_description', 'استعراض مقالات ومحتوى بوسم ' . $tag->name . ' في مدونتنا')
@section('meta_keywords', 'مدونة, ' . $tag->name . ', وسوم, مقالات, محتوى')

@section('content')
    <div class="container py-5 mt-5">
        <!-- رأس الصفحة للوسم -->
        <div class="tag-header mb-4 mt-5">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tag-banner p-4 rounded-3 shadow-sm">
                        <h1 class="fw-bold tag-title">
                            <i class="fas fa-tag me-2"></i> {{ $tag->name }}
                        </h1>
                        <nav aria-label="breadcrumb" class="mt-2">
                            <ol class="breadcrumb bg-transparent p-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home') }}" class="text-decoration-none">
                                        <i class="fas fa-home me-1"></i>الرئيسية
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('blog.index') }}" class="text-decoration-none">المدونة</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">وسم: {{ $tag->name }}</li>
                            </ol>
                        </nav>

                        <div class="tag-meta mt-3">
                            <div class="alert alert-light d-flex align-items-center" role="alert">
                                <i class="fas fa-info-circle me-2 text-primary"></i>
                                <div>عدد المقالات المرتبطة بهذا الوسم: <strong>{{ $posts->total() }}</strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- الوسوم الشائعة للتنقل السريع -->
        <div class="tags-navbar mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="m-0"><i class="fas fa-tags me-2"></i>الوسوم الشائعة</h5>
                <a href="{{ route('blog.index') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-th-list me-1"></i> جميع المقالات
                </a>
            </div>
            <div class="tags-scroll">
                <div class="d-flex gap-2 flex-wrap">
                    @foreach ($popularTags as $popularTag)
                        <a href="{{ route('blog.tag', $popularTag->slug) }}"
                            class="btn btn-sm tag-btn {{ $popularTag->id === $tag->id ? 'btn-primary' : 'btn-outline-secondary' }}">
                            {{ $popularTag->name }}
                            <span class="badge bg-light text-dark rounded-pill ms-1">{{ $popularTag->posts_count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row">
            <!-- قسم المقالات الرئيسي -->
            <div class="col-lg-8">
                @if (count($posts) > 0)
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
                                            <span>
                                                <i class="far fa-calendar-alt me-1"></i>
                                                {{ $post->published_at->format('d M, Y') }}
                                            </span>
                                            <span>
                                                <i class="far fa-eye me-1"></i> {{ $post->views }}
                                            </span>
                                        </div>
                                        <h5 class="card-title">
                                            <a href="{{ route('blog.show', $post->slug) }}"
                                                class="text-decoration-none text-dark blog-title">{{ $post->title }}</a>
                                        </h5>
                                        <p class="card-text text-muted mb-3">
                                            {{ Str::limit($post->excerpt ?? strip_tags($post->content), 120) }}
                                        </p>
                                        <div class="mt-auto">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <a href="{{ route('blog.show', $post->slug) }}" class="read-more">
                                                    قراءة المزيد <i class="fas fa-arrow-left ms-1"></i>
                                                </a>

                                                @if (count($post->tags) > 0)
                                                    <div class="post-tags">
                                                        @foreach ($post->tags->take(2) as $postTag)
                                                            @if ($postTag->id !== $tag->id)
                                                                <a href="{{ route('blog.tag', $postTag->slug) }}"
                                                                    class="badge bg-light text-dark text-decoration-none me-1">
                                                                    {{ $postTag->name }}
                                                                </a>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
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
                            لم يتم العثور على مقالات مرتبطة بهذا الوسم. تصفح باقي أقسام المدونة للاطلاع على محتوانا المميز.
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
        /* رأس الوسم */
        .tag-header {
            margin-bottom: 2rem;
        }

        .tag-banner {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            position: relative;
            overflow: hidden;
            border-right: 5px solid #404770;
        }

        .tag-title {
            position: relative;
            display: inline-block;
            margin-bottom: 0.5rem;
        }

        .tag-title:after {
            content: "";
            position: absolute;
            bottom: -5px;
            right: 0;
            width: 50px;
            height: 3px;
            background-color: #404770;
        }

        /* وسوم التنقل */
        .tags-scroll {
            padding: 0.5rem 0;
        }

        .tag-btn {
            transition: all 0.3s ease;
            border-radius: 20px;
            margin-bottom: 0.5rem;
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

        .blog-img-placeholder {
            height: 200px;
            background-color: #f8f9fa;
        }
    </style>
@endpush

@push('scripts')
    <script>
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
        });
    </script>
@endpush
