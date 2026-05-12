@extends('layouts.master')

@section('title', 'نتائج البحث: ' . request('q') . ' - ' . config('app.name'))
@section('meta_description', 'نتائج البحث عن ' . request('q') . ' في مدونتنا')
@section('meta_keywords', 'بحث, مدونة, مقالات, ' . request('q'))

@section('content')
    <div class="container py-5 mt-5">
        <!-- رأس صفحة البحث -->
        <div class="search-header mb-4 mt-5">
            <div class="row">
                <div class="col-lg-12">
                    <div class="search-banner p-4 rounded-3 shadow-sm">
                        <h1 class="fw-bold search-title">نتائج البحث</h1>
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
                                <li class="breadcrumb-item active" aria-current="page">نتائج البحث</li>
                            </ol>
                        </nav>

                        <div class="search-meta mt-3">
                            <div class="alert alert-light d-flex align-items-center" role="alert">
                                <i class="fas fa-search me-2 text-primary"></i>
                                <div>نتائج البحث عن: <strong dir="rtl">"{!! htmlspecialchars($query ?? '', ENT_QUOTES, 'UTF-8') !!}"</strong> - تم العثور
                                    على {{ $posts->total() }} {{ $posts->total() == 1 ? 'مقال' : 'مقالة' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- محرك البحث المطور -->
        <div class="search-form-wrapper card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3"><i class="fas fa-filter me-2"></i>تصفية نتائج البحث</h5>
                <form action="{{ route('blog.search') }}" method="GET" class="advanced-search-form"
                    accept-charset="UTF-8">
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                                <input type="text" name="q" class="form-control" placeholder="كلمات البحث..."
                                    value="{{ htmlspecialchars($query ?? '', ENT_QUOTES, 'UTF-8') }}" required>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <select name="category" class="form-select">
                                <option value="">جميع التصنيفات</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }} ({{ $category->posts_count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <select name="sort" class="form-select">
                                <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>الأحدث</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>الأقدم</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>الأكثر مشاهدة
                                </option>
                            </select>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i> بحث
                                </button>
                                <a href="{{ route('blog.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i> إلغاء البحث
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <!-- قسم نتائج البحث الرئيسي -->
            <div class="col-lg-8">
                @if (count($posts) > 0)
                    <!-- عرض النتائج كقائمة -->
                    <div class="search-results-list">
                        @foreach ($posts as $post)
                            <div class="card mb-3 search-result-card">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <div class="search-result-image h-100">
                                            @if ($post->featured_image)
                                                <img src="{{ $post->featured_image }}" class="img-fluid h-100 w-100"
                                                    style="object-fit: cover;" alt="{{ $post->title }}">
                                            @else
                                                <div
                                                    class="result-img-placeholder d-flex align-items-center justify-content-center h-100">
                                                    <i class="fas fa-newspaper fa-3x text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body h-100 d-flex flex-column">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="badge bg-primary">{{ $post->category->name }}</span>
                                                <small
                                                    class="text-muted">{{ $post->published_at->format('d M, Y') }}</small>
                                            </div>

                                            <h5 class="card-title">
                                                <a href="{{ route('blog.show', $post->slug) }}"
                                                    class="text-decoration-none text-dark search-result-title">
                                                    @php
                                                        $safeQuery = preg_quote($query ?? '', '/');
                                                        $highlightedTitle = $post->title;
                                                        if (!empty($safeQuery)) {
                                                            $highlightedTitle = preg_replace(
                                                                '/(' . $safeQuery . ')/iu',
                                                                '<span class="search-highlight">$1</span>',
                                                                $post->title,
                                                            );
                                                        }
                                                    @endphp
                                                    {!! $highlightedTitle !!}
                                                </a>
                                            </h5>

                                            <p class="card-text text-muted mb-3">
                                                @php
                                                    $content = Str::limit(strip_tags($post->content), 150);
                                                    $highlightedContent = $content;
                                                    if (!empty($safeQuery)) {
                                                        $highlightedContent = preg_replace(
                                                            '/(' . $safeQuery . ')/iu',
                                                            '<span class="search-highlight">$1</span>',
                                                            $content,
                                                        );
                                                    }
                                                @endphp
                                                {!! $highlightedContent !!}
                                            </p>

                                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                                <a href="{{ route('blog.show', $post->slug) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    قراءة المقال <i class="fas fa-arrow-left ms-1"></i>
                                                </a>
                                                <span class="small text-muted">
                                                    <i class="fas fa-eye me-1"></i> {{ $post->views }} مشاهدة
                                                </span>
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
                            {{ $posts->appends(['q' => $query, 'category' => request('category'), 'sort' => request('sort')])->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                @else
                    <div class="alert alert-info d-flex align-items-center search-no-results" role="alert">
                        <i class="fas fa-info-circle me-2 fa-lg"></i>
                        <div>
                            <strong>لا توجد نتائج!</strong> لم يتم العثور على أي نتائج مطابقة لـ
                            "<strong>{{ htmlspecialchars($query ?? '', ENT_QUOTES, 'UTF-8') }}</strong>".
                            <hr>
                            <p class="mb-0">اقتراحات للبحث:</p>
                            <ul class="mt-2">
                                <li>تأكد من كتابة جميع الكلمات بشكل صحيح.</li>
                                <li>جرب كلمات مفتاحية مختلفة.</li>
                                <li>جرب كلمات مفتاحية أكثر عمومية.</li>
                                <li>استخدم عدد أقل من الكلمات المفتاحية.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>استكشف التصنيفات الشائعة:</h5>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            @foreach ($popularCategories as $category)
                                <a href="{{ route('blog.category', $category->slug) }}"
                                    class="btn btn-outline-primary mb-2">
                                    {{ $category->name }} <span
                                        class="badge bg-light text-dark ms-1">{{ $category->posts_count }}</span>
                                </a>
                            @endforeach
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
        /* رأس البحث */
        .search-header {
            margin-bottom: 2rem;
        }

        .search-banner {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            position: relative;
            overflow: hidden;
            border-right: 5px solid #404770;
        }

        .search-title {
            position: relative;
            display: inline-block;
            margin-bottom: 0.5rem;
        }

        .search-title:after {
            content: "";
            position: absolute;
            bottom: -5px;
            right: 0;
            width: 50px;
            height: 3px;
            background-color: #404770;
        }

        /* نموذج البحث */
        .advanced-search-form .form-control,
        .advanced-search-form .form-select {
            border-radius: 8px;
        }

        .search-form-wrapper {
            border-radius: 12px;
            overflow: hidden;
        }

        /* بطاقات نتائج البحث */
        .search-result-card {
            transition: all 0.3s ease;
            border-radius: 10px;
            overflow: hidden;
        }

        .search-result-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1) !important;
        }

        .search-result-image {
            overflow: hidden;
            min-height: 180px;
        }

        .search-result-image img {
            transition: all 0.5s ease;
        }

        .search-result-card:hover .search-result-image img {
            transform: scale(1.05);
        }

        .search-result-title {
            transition: color 0.3s ease;
        }

        .search-result-title:hover {
            color: #F59C27 !important;
        }

        /* تمييز كلمات البحث */
        .search-highlight {
            background-color: rgba(245, 156, 39, 0.3);
            padding: 0 2px;
            border-radius: 3px;
            font-weight: bold;
        }

        /* صورة placeholder */
        .result-img-placeholder {
            background-color: #f8f9fa;
            min-height: 180px;
        }

        /* نتائج بدون محتوى */
        .search-no-results {
            border-right: 5px solid #404770;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // تأثير عند التمرير للنتائج
            const results = document.querySelectorAll('.search-result-card');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                    }
                });
            }, {
                threshold: 0.1
            });

            results.forEach(result => {
                observer.observe(result);
            });
        });
    </script>
@endpush
