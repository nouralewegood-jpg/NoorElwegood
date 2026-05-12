@extends('layouts.master')

@section('title', $post->meta_title ? $post->meta_title : $post->title . ' - ' . config('app.name'))
@section('meta_description', $post->meta_description ?? Str::limit(strip_tags($post->content), 160))
@section('meta_keywords', $post->meta_keywords ?? 'مدونة, مقالات, ' . $post->title)

@section('content')
    <div class="container py-5 mt-5">
        <div class="row">
            <!-- المقالة الرئيسية -->
            <div class="col-lg-8">
                <div class="section-title pb-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none"><i
                                        class="fas fa-home me-1"></i>الرئيسية</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('blog.index') }}"
                                    class="text-decoration-none">المدونة</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($post->title, 30) }}</li>
                        </ol>
                    </nav>
                </div>

                <article class="card shadow-sm mb-4 blog-article">
                    @if ($post->featured_image)
                        <div class="featured-image-wrapper">
                            <img src="{{ asset($post->featured_image) }}" class="card-img-top img-fluid"
                                alt="{{ $post->title }}"
                                onerror="this.onerror=null;this.src='{{ asset('assets-home/img/blog-placeholder.jpg') }}';"
                                style="max-height: 450px; object-fit: cover;">
                            <div class="category-badge">
                                <a href="{{ route('blog.category', $post->category->slug) }}"
                                    class="text-white text-decoration-none">
                                    {{ $post->category->name }}
                                </a>
                            </div>
                        </div>
                    @endif
                    <div class="card-body">
                        <!-- معلومات المقال -->
                        <div class="post-meta d-flex align-items-center mb-4 text-muted">
                            <span class="me-4">
                                <i class="fas fa-user-circle me-1"></i> {{ $post->user->name }}
                            </span>
                            <span class="me-4">
                                <i class="far fa-calendar-alt me-1"></i> {{ $post->published_at->format('d M, Y') }}
                            </span>
                            <span class="me-4">
                                <i class="far fa-eye me-1"></i> {{ $post->views }} مشاهدة
                            </span>
                        </div>

                        <!-- عنوان المقال -->
                        <h1 class="card-title mb-4 fw-bold">{{ $post->title }}</h1>

                        @if ($post->excerpt)
                            <div class="lead mb-4 fw-bold post-excerpt">
                                {{ $post->excerpt }}
                            </div>
                        @endif

                        <!-- محتوى المقال -->
                        <div class="blog-content">
                            {!! $post->content !!}
                        </div>

                        <!-- وسوم المقال -->
                        @if (count($post->tags) > 0)
                            <div class="mt-4 pt-3 border-top post-tags">
                                <h5><i class="fas fa-tags me-2"></i>الوسوم</h5>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($post->tags as $tag)
                                        <a href="{{ route('blog.tag', $tag->slug) }}"
                                            class="btn btn-sm btn-outline-secondary tag-btn">
                                            {{ $tag->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- أزرار المشاركة -->
                        <div class="mt-4 pt-4 border-top share-buttons-container">
                            <h5 class="mb-3"><i class="fas fa-share-alt me-2"></i>شارك المقال</h5>
                            <div class="share-buttons-wrapper">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $post->slug)) }}"
                                    target="_blank" class="social-share-btn facebook-share" data-toggle="tooltip"
                                    title="مشاركة على فيسبوك">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $post->slug)) }}&text={{ urlencode($post->title) }}"
                                    target="_blank" class="social-share-btn twitter-share" data-toggle="tooltip"
                                    title="مشاركة على تويتر">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . route('blog.show', $post->slug)) }}"
                                    target="_blank" class="social-share-btn whatsapp-share" data-toggle="tooltip"
                                    title="مشاركة عبر واتساب">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                @php
                                    $contactSection = App\Models\ContactSection::where('is_active', true)->first();
                                    if (!$contactSection) {
                                        $contactSection = App\Models\ContactSection::first();
                                    }
                                    $whatsappNumber = $contactSection
                                        ? preg_replace(
                                            '/\s+/',
                                            '',
                                            str_replace(
                                                '+',
                                                '',
                                                $contactSection->whatsapp_number ?? $contactSection->phone,
                                            ),
                                        )
                                        : '';
                                @endphp
                                @if ($whatsappNumber)
                                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode('مرحباً، أريد الاستفسار عن: ' . $post->title . ' - ' . route('blog.show', $post->slug)) }}"
                                        target="_blank" class="social-share-btn contact-whatsapp-share"
                                        data-toggle="tooltip" title="تواصل معنا عبر واتساب">
                                        <i class="fas fa-comments"></i>
                                    </a>
                                @endif
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('blog.show', $post->slug)) }}&title={{ urlencode($post->title) }}"
                                    target="_blank" class="social-share-btn linkedin-share" data-toggle="tooltip"
                                    title="مشاركة على لينكد إن">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="mailto:?subject={{ urlencode($post->title) }}&body={{ urlencode($post->title . ' - ' . route('blog.show', $post->slug)) }}"
                                    class="social-share-btn email-share" data-toggle="tooltip"
                                    title="مشاركة عبر البريد الإلكتروني">
                                    <i class="fas fa-envelope"></i>
                                </a>
                                <button onclick="copyPostLink()" class="social-share-btn copy-link-share"
                                    data-toggle="tooltip" title="نسخ الرابط">
                                    <i class="fas fa-link"></i>
                                </button>
                                <a href="javascript:window.print()" class="social-share-btn print-share"
                                    data-toggle="tooltip" title="طباعة المقال">
                                    <i class="fas fa-print"></i>
                                </a>
                            </div>
                            <div id="copyLinkToast" class="copy-link-toast">
                                <div class="toast-content">
                                    <i class="fas fa-check-circle me-2"></i>
                                    تم نسخ رابط المقال بنجاح!
                                </div>
                            </div>
                        </div>

                        <!-- التنقل بين المقالات -->
                        <div class="row mt-4 mb-4 post-navigation">
                            <div class="col-md-6 mb-3 mb-md-0">
                                @if ($post->getPreviousPost())
                                    <a href="{{ route('blog.show', $post->getPreviousPost()->slug) }}"
                                        class="d-flex align-items-center h-100 justify-content-start nav-btn prev-btn">
                                        <div class="nav-icon"><i class="fas fa-arrow-right"></i></div>
                                        <div class="nav-content">
                                            <small class="d-block nav-label">المقال السابق</small>
                                            <span
                                                class="nav-title">{{ Str::limit($post->getPreviousPost()->title, 25) }}</span>
                                        </div>
                                    </a>
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if ($post->getNextPost())
                                    <a href="{{ route('blog.show', $post->getNextPost()->slug) }}"
                                        class="d-flex align-items-center h-100 justify-content-end nav-btn next-btn">
                                        <div class="nav-content text-end">
                                            <small class="d-block nav-label">المقال التالي</small>
                                            <span
                                                class="nav-title">{{ Str::limit($post->getNextPost()->title, 25) }}</span>
                                        </div>
                                        <div class="nav-icon"><i class="fas fa-arrow-left"></i></div>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- المقالات ذات الصلة -->
                        @if (count($relatedPosts) > 0)
                            <div class="card shadow-sm mb-4 related-posts-card">
                                <div class="card-body">
                                    <h3 class="card-title mb-4"><i class="fas fa-newspaper me-2"></i>مقالات ذات صلة</h3>
                                    <div class="row">
                                        @foreach ($relatedPosts as $relatedPost)
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100 shadow-sm related-post-card">
                                                    @if ($relatedPost->featured_image)
                                                        <img src="{{ asset($relatedPost->featured_image) }}"
                                                            class="card-img-top"
                                                            onerror="this.onerror=null;this.src='{{ asset('assets-home/img/blog-placeholder.jpg') }}';"
                                                            alt="{{ $relatedPost->title }}"
                                                            style="height: 150px; object-fit: cover;">
                                                    @endif
                                                    <div class="card-body">
                                                        <h6 class="card-title">
                                                            <a href="{{ route('blog.show', $relatedPost->slug) }}"
                                                                class="text-decoration-none text-dark stretched-link">
                                                                {{ Str::limit($relatedPost->title, 50) }}
                                                            </a>
                                                        </h6>
                                                        <div class="small text-muted">
                                                            <i class="fas fa-calendar-alt me-1"></i>
                                                            {{ $relatedPost->published_at->format('d M, Y') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info d-flex align-items-center" role="alert">
                                <i class="fas fa-info-circle me-2"></i> لا توجد مقالات ذات صلة في الوقت الحالي.
                            </div>
                        @endif
                    </div>
                </article>
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
        .blog-content {
            line-height: 1.8;
            font-size: 1.1rem;
        }

        .blog-content h2,
        .blog-content h3,
        .blog-content h4 {
            margin-top: 2rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .blog-content img {
            max-width: 100%;
            height: auto;
            margin: 1.5rem auto;
            border-radius: 8px;
            display: block;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .blog-content blockquote {
            background-color: #f8f9fa;
            border-right: 4px solid #404770;
            padding: 1.25rem;
            margin: 1.5rem 0;
            font-style: italic;
            border-radius: 4px;
        }

        .blog-content ul,
        .blog-content ol {
            margin-bottom: 1.5rem;
            padding-right: 1.5rem;
        }

        .blog-content li {
            margin-bottom: 0.5rem;
        }

        .featured-image-wrapper {
            position: relative;
        }

        .category-badge {
            position: absolute;
            bottom: 15px;
            right: 15px;
            background-color: rgba(64, 71, 112, 0.85);
            padding: 5px 15px;
            border-radius: 20px;
            color: white;
            font-weight: 500;
        }

        .post-excerpt {
            font-size: 1.2rem;
            color: #555;
            background-color: #f9f9f9;
            padding: 1rem;
            border-radius: 8px;
            border-right: 3px solid #404770;
        }

        .nav-btn {
            border-radius: 8px;
            transition: all 0.3s ease;
            height: 100%;
        }

        .nav-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .tag-btn:hover {
            background-color: #6c757d;
            color: white;
        }

        .social-share-btn {
            border-radius: 6px;
            padding: 8px 15px;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            width: 40px;
            height: 40px;
            color: white;
        }

        .facebook-share {
            background-color: #404770;
        }

        .twitter-share {
            background-color: #1da1f2;
        }

        .whatsapp-share {
            background-color: #25d366;
        }

        .contact-whatsapp-share {
            background-color: #128C7E;
        }

        .linkedin-share {
            background-color: #0077b5;
        }

        .email-share {
            background-color: #6c757d;
        }

        .copy-link-share {
            background-color: #6c757d;
        }

        .print-share {
            background-color: #6c757d;
        }

        .social-share-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .related-post-card {
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .related-post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .related-post-card img {
            transition: all 0.5s ease;
        }

        .related-post-card:hover img {
            transform: scale(1.05);
        }

        .blog-article {
            border-radius: 10px;
            overflow: hidden;
        }

        .copy-link-toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #F59C27;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: none;
            z-index: 1050;
        }

        .copy-link-toast .toast-content {
            display: flex;
            align-items: center;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // تحسين تجربة المستخدم وتعزيز محركات البحث
        document.addEventListener('DOMContentLoaded', function() {
            // إضافة وسوم schema.org للمقال
            const schema = {
                "@context": "https://schema.org",
                "@type": "BlogPosting",
                "headline": "{{ $post->title }}",
                "description": "{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 160) }}",
                "image": "{{ $post->featured_image ?? '' }}",
                "author": {
                    "@type": "Person",
                    "name": "{{ $post->user->name }}"
                },
                "publisher": {
                    "@type": "Organization",
                    "name": "{{ config('app.name') }}",
                    "logo": {
                        "@type": "ImageObject",
                        "url": "{{ asset('logo.png') }}"
                    }
                },
                "datePublished": "{{ $post->published_at->toIso8601String() }}",
                "dateModified": "{{ $post->updated_at->toIso8601String() }}"
            };

            const script = document.createElement('script');
            script.type = "application/ld+json";
            script.text = JSON.stringify(schema);
            document.head.appendChild(script);

            // تحسين تجربة القراءة
            const headings = document.querySelectorAll('.blog-content h2, .blog-content h3, .blog-content h4');
            headings.forEach(heading => {
                heading.classList.add('mt-4', 'mb-3', 'fw-bold');
            });

            // تحسين الصور
            const images = document.querySelectorAll('.blog-content img');
            images.forEach(image => {
                image.classList.add('img-fluid', 'my-4');

                // إضافة لايتبوكس للصور
                const imageLink = document.createElement('a');
                imageLink.href = image.src;
                imageLink.setAttribute('data-lightbox', 'blog-images');
                imageLink.setAttribute('data-title', image.alt || '');

                // استبدال الصورة بالرابط الذي يحتوي عليها
                image.parentNode.insertBefore(imageLink, image);
                imageLink.appendChild(image);
            });

            // تفعيل التولتيب
            const tooltipElements = document.querySelectorAll('[data-toggle="tooltip"]');
            tooltipElements.forEach(element => {
                element.addEventListener('mouseenter', function() {
                    const tooltip = document.createElement('div');
                    tooltip.className = 'tooltip';
                    tooltip.innerText = element.getAttribute('title');
                    document.body.appendChild(tooltip);

                    const rect = element.getBoundingClientRect();
                    tooltip.style.left = `${rect.left + window.scrollX}px`;
                    tooltip.style.top = `${rect.top + window.scrollY - tooltip.offsetHeight}px`;

                    element.addEventListener('mouseleave', function() {
                        document.body.removeChild(tooltip);
                    });
                });
            });
        });

        // دالة نسخ رابط المقال
        function copyPostLink() {
            const tempInput = document.createElement('input');
            tempInput.value = window.location.href;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);

            // إظهار رسالة نجاح
            const toast = document.getElementById('copyLinkToast');
            toast.style.display = 'block';
            setTimeout(() => {
                toast.style.display = 'none';
            }, 3000);
        }
    </script>
@endpush
