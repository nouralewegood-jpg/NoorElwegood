@extends('layouts.master')

@section('title')
    {{ $portfolio->title }} - معرض الأعمال - نور الوجود
@endsection
@section('description')
    {{ Str::limit(strip_tags($portfolio->description), 160) }}
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <style>
        :root {
            --primary-color: #404770;
            --primary-color-rgb: 13, 110, 253;
            --secondary-color: #6c757d;
            --white: #ffffff;
            --black: #000000;
            --text-color: #555555;
            --bg-light: #f8f9fa;
            --bg-gradient: linear-gradient(135deg, #404770 0%, #0043a8 100%);
        }

        /* ====== نمط عام للصفحة ====== */
        main {
            padding-bottom: 60px;
            overflow-x: hidden;
        }

        /* ====== رأس الصفحة والـ Breadcrumbs ====== */
        .page-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 3rem 1rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .page-header:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiB2aWV3Qm94PSIwIDAgMTI4MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTEyODAgMGwtMjYyLjEgOTUuNTJjLTU4LjU1IDI2Ljk1LTEyMCAwLTE3Ny4xLTEzLjI1TDU5OC41NSA0Mi4wMmMtNTUtMjAuOTgtMTQwLTQyLjk3LTE5My4yLTE0LjY3TDQwIDE0LjAzVjE0MEgxMjgweiIgZmlsbD0iI2ZmZmZmZiIgZmlsbC1vcGFjaXR5PSIwLjA1Ii8+PC9zdmc+');
            background-size: 100% 100%;
            opacity: 0.5;
            z-index: 0;
        }

        .page-header h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }

        .page-header .portfolio-category-badge {
            display: inline-block;
            padding: 8px 20px;
            background-color: rgba(255, 255, 255, 0.2);
            color: var(--white);
            border-radius: 50px;
            font-size: 14px;
            margin-top: 5px;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(5px);
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .page-header .portfolio-category-badge:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
        }

        .breadcrumb {
            display: flex;
            justify-content: center;
            padding: 0;
            margin: 0;
            list-style: none;
            background: transparent;
            position: relative;
            z-index: 1;
        }

        .breadcrumb-item {
            display: flex;
            align-items: center;
        }

        .breadcrumb-item a {
            color: var(--accent-color) text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .breadcrumb-item a:hover {
            color: var(--white);
            transform: translateY(-2px);
        }

        .breadcrumb-item a i {
            margin-left: 5px;
        }

        .breadcrumb-item+.breadcrumb-item {
            padding-right: 0.5rem;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            display: inline-block;
            padding-left: 0.5rem;
            color: rgba(0, 0, 0, 0.5);
            content: "/";
        }

        .breadcrumb-item.active {
            color: var(--primary-color);
            font-weight: 500;
        }

        /* ====== معرض الصور المتطور - تحسينات كبيرة ====== */
        .portfolio-gallery {
            margin-top: 60px;
            position: relative;
        }

        .gallery-title-container {
            display: flex;
            align-items: center;
            margin-bottom: 35px;
            position: relative;
        }

        .gallery-title {
            font-size: 25px;
            font-weight: 700;
            color: var(--primary-color);
            position: relative;
            padding-right: 20px;
            display: inline-block;
            margin: 0;
        }

        .gallery-title:before {
            content: '';
            position: absolute;
            top: 50%;
            right: 0;
            transform: translateY(-50%);
            width: 5px;
            height: 30px;
            background: var(--bg-gradient);
            border-radius: 5px;
        }

        .gallery-title:after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(0, 0, 0, 0.1);
            margin-right: 20px;
        }

        .gallery-counter {
            display: inline-block;
            padding: 5px 15px;
            background-color: var(--bg-light);
            color: var(--primary-color);
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            margin-right: 15px;
        }

        /* مكتبة الصور المتطورة - عرض متساوي للصور */
        .gallery-masonry {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            grid-gap: 15px;
            margin-bottom: 30px;
        }

        /* التحكم في ارتفاع الصور والمساحات بينها */
        .gallery-item-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
            cursor: pointer;
            height: 250px;
        }

        /* إضافة صور بحجم كبير للتنوع */
        .gallery-item-wrapper.large {
            grid-column: span 2;
            grid-row: span 2;
            height: 515px;
        }

        .gallery-item-wrapper.medium {
            grid-column: span 2;
            height: 250px;
        }

        .gallery-item-wrapper:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .gallery-item {
            display: block;
            width: 100%;
            height: 100%;
            position: relative;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s ease;
        }

        .gallery-item-wrapper:hover img {
            transform: scale(1.05);
        }

        .gallery-item:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: 1;
        }

        .gallery-item:hover:before {
            opacity: 1;
        }

        .gallery-item-info {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 20px;
            z-index: 2;
            color: var(--white);
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.4s ease;
        }

        .gallery-item:hover .gallery-item-info {
            transform: translateY(0);
            opacity: 1;
        }

        .gallery-item-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .gallery-item-caption {
            font-size: 13px;
            opacity: 0.8;
        }

        .gallery-zoom-icon {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            background: rgba(var(--primary-color-rgb), 0.8);
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            opacity: 0;
            transform: scale(0.5);
            transition: all 0.4s ease;
        }

        .gallery-item:hover .gallery-zoom-icon {
            opacity: 1;
            transform: scale(1);
        }

        .gallery-zoom-icon i {
            font-size: 18px;
        }

        .gallery-zoom-icon:hover {
            background: var(--primary-color);
            transform: scale(1.1);
        }

        /* التحكم في عرض المصغرات في أحجام الشاشات المختلفة */
        @media (max-width: 1200px) {
            .gallery-masonry {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            }
        }

        @media (max-width: 992px) {
            .gallery-masonry {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }

            .gallery-item-wrapper.large {
                grid-column: span 2;
                grid-row: span 1;
                height: 250px;
            }
        }

        @media (max-width: 768px) {
            .gallery-masonry {
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            }

            .gallery-item-wrapper.large,
            .gallery-item-wrapper.medium {
                grid-column: span 1;
                height: 200px;
            }
        }

        @media (max-width: 576px) {
            .gallery-masonry {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
                grid-gap: 10px;
            }

            .gallery-item-wrapper {
                height: 180px;
            }
        }

        /* ===== أزرار فلتر معرض الصور ===== */
        .gallery-filters {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 30px;
        }

        .gallery-filter-btn {
            padding: 8px 20px;
            margin: 0 5px 10px;
            background: var(--bg-light);
            color: var(--text-color);
            border: none;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .gallery-filter-btn:hover {
            background: rgba(var(--primary-color-rgb), 0.1);
            color: var(--primary-color);
        }

        .gallery-filter-btn.active {
            background: var(--primary-color);
            color: var(--white);
        }

        /* ===== زر تحميل المزيد من الصور ===== */
        .load-more-container {
            text-align: center;
            margin-top: 40px;
        }

        .load-more-btn {
            padding: 12px 30px;
            background: var(--bg-gradient);
            color: var(--white);
            border: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(var(--primary-color-rgb), 0.3);
        }

        .load-more-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(var(--primary-color-rgb), 0.4);
        }

        /* ===== تأثيرات متنوعة للصور ===== */
        .gallery-item-wrapper:nth-child(3n) .gallery-item:before {
            background: linear-gradient(45deg, rgba(var(--primary-color-rgb), 0.7), transparent);
        }

        .gallery-item-wrapper:nth-child(3n+1) .gallery-item:before {
            background: linear-gradient(to right, rgba(0, 0, 0, 0.7), transparent);
        }

        /* ===== CTA Section Styles - Professional Design ===== */
        .cta-section-enhanced {
            position: relative;
            padding: 100px 0;
            background-image: linear-gradient(135deg, #404770 0%, #575B75FF 100%);
            color: #ffffff;
            text-align: center;
            margin-top: 80px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .cta-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiB2aWV3Qm94PSIwIDAgMTI4MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTEyODAgMGwtMjYyLjEgOTUuNTJjLTU4LjU1IDI2Ljk1LTEyMCAwLTE3Ny4xLTEzLjI1TDU5OC41NSA0Mi4wMmMtNTUtMjAuOTgtMTQwLTQyLjk3LTE5My4yLTE0LjY3TDQwIDE0LjAzVjE0MEgxMjgweiIgZmlsbD0iI2ZmZmZmZiIgZmlsbC1vcGFjaXR5PSIwLjA1Ii8+PC9zdmc+');
            background-size: 100% 100%;
            opacity: 0.3;
            z-index: 1;
        }

        .cta-content {
            position: relative;
            z-index: 2;
            padding: 20px;
        }

        .cta-badge {
            display: inline-block;
            background-color: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 50px;
            margin-bottom: 25px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .cta-section-enhanced h2 {
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 20px;
            color: #ffffff;
            /* تغيير لون الخط إلى أبيض */
            /* تم إزالة text-shadow */
        }

        .cta-section-enhanced p {
            font-size: 18px;
            line-height: 1.8;
            margin-bottom: 30px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            opacity: 0.9;
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .cta-button-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 15px 35px;
            background: #ffffff;
            color: #0a2463;
            font-size: 16px;
            font-weight: 700;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .cta-button-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            color: #0a2463;
        }

        .cta-button-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 15px 35px;
            background: transparent;
            color: #ffffff;
            font-size: 16px;
            font-weight: 700;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .cta-button-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-5px);
            color: #ffffff;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .cta-section-enhanced {
                padding: 60px 0;
            }

            .cta-section-enhanced h2 {
                font-size: 28px;
            }

            .cta-section-enhanced p {
                font-size: 16px;
            }

            .cta-buttons {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
@endsection

@section('content')
    <main id="main">
        <div class="container py-5 mt-5">

            <!-- رأس الصفحة مع خلفية جذابة -->
            <div class="page-header m-5">
                <div class="row align-items-center">
                    <div class="col-lg-12 text-center">
                        <h1 class="display-4 fw-bold">{{ $portfolio->title }}</h1>
                        <p class="lead text-muted">اكتشف أحدث المشاريع في المجالات المختلفه</p>
                        <nav aria-label="breadcrumb" class="mt-3 justify-content-center d-flex">
                            <ol class="breadcrumb bg-transparent">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none"><i
                                            class="fas fa-home me-1"></i>الرئيسية</a></li>
                                <li class="breadcrumb-item active"><a href="/portfolio" class="text-decoration-none">معرض
                                        الأعمال</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $portfolio->title }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- وصف المشروع -->
            <div class="row mb-5">
                <div class="col-lg-12">
                    <div class="portfolio-box" data-aos="fade-up">
                        <h2 class="portfolio-box-title">وصف المشروع</h2>
                        <div class="portfolio-description-content">
                            {!! nl2br(e($portfolio->description)) !!}
                        </div>

                        <!-- تفاصيل المشروع في صف واحد -->
                        <div class="row mt-4">
                            @if ($portfolio->category)
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-folder me-2 text-primary"></i>
                                        <div>
                                            <small class="d-block text-muted">التصنيف</small>
                                            <strong>{{ $portfolio->category }}</strong>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($portfolio->client_name)
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-person me-2 text-primary"></i>
                                        <div>
                                            <small class="d-block text-muted">العميل</small>
                                            <strong>{{ $portfolio->client_name }}</strong>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($portfolio->project_date)
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-calendar me-2 text-primary"></i>
                                        <div>
                                            <small class="d-block text-muted">تاريخ المشروع</small>
                                            <strong>{{ $portfolio->project_date->format('Y-m-d') }}</strong>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($portfolio->duration)
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-clock me-2 text-primary"></i>
                                        <div>
                                            <small class="d-block text-muted">مدة التنفيذ</small>
                                            <strong>{{ $portfolio->duration }}</strong>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- ====== معرض الصور المحسن ====== -->
            <div class="portfolio-gallery mb-5" id="portfolio-gallery" data-aos="fade-up">
                <div class="gallery-title-container">
                    <h2 class="gallery-title">معرض الصور</h2>
                    <span class="gallery-counter">{{ $portfolio->gallery_images ? count($portfolio->gallery_images) : 0 }}
                        صورة</span>
                </div>

                @if ($portfolio->gallery_images && count($portfolio->gallery_images) > 0)
                    <!-- شريط تنقل اختياري - يمكن إضافته إذا كان لديك تصنيفات للصور -->
                    @if (false)
                        <div class="gallery-nav">
                            <button class="gallery-nav-btn active" data-filter="*">جميع الصور</button>
                            <button class="gallery-nav-btn" data-filter="interior">تصميم داخلي</button>
                            <button class="gallery-nav-btn" data-filter="exterior">واجهات</button>
                        </div>
                    @endif

                    <!-- معرض الصور كشبكة -->
                    <div class="gallery-masonry">
                        @foreach ($portfolio->gallery_images as $index => $image)
                            <div class="gallery-item-wrapper {{ $index % 3 == 0 ? 'large' : '' }}" data-aos="fade-up"
                                data-aos-delay="{{ $index * 50 }}"
                                data-category="{{ rand(0, 1) ? 'interior' : 'exterior' }}">
                                <a href="{{ $image->image_url }}" class="gallery-item glightbox"
                                    data-gallery="portfolio-gallery"
                                    data-description="{{ $portfolio->title }} - صورة {{ $index + 1 }}">
                                    <img src="{{ $image->image_url }}"
                                        alt="{{ $portfolio->title }} - صورة {{ $index + 1 }}" loading="lazy">
                                    <div class="gallery-zoom-icon">
                                        <i class="bi bi-zoom-in"></i>
                                    </div>
                                    <div class="gallery-item-info">
                                        <h4 class="gallery-item-title">{{ $portfolio->title }}</h4>
                                        <p class="gallery-item-caption">صورة {{ $index + 1 }} من
                                            {{ $portfolio->gallery_images ? count($portfolio->gallery_images) : 0 }}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- زر تحميل المزيد - يمكن إضافة وظيفة جافاسكريبت لتحميل المزيد من الصور -->
                    @if ($portfolio->gallery_images && count($portfolio->gallery_images) > 6 && false)
                        <div class="load-more-container">
                            <button class="load-more-btn" id="load-more-gallery">
                                <span>عرض المزيد من الصور</span>
                                <i class="bi bi-arrow-down-circle"></i>
                            </button>
                        </div>
                    @endif
                @else
                    <!-- حالة عدم وجود صور -->
                    <div class="no-gallery-items">
                        <i class="bi bi-images"></i>
                        <h3>لا توجد صور في المعرض حالياً</h3>
                        <p>لم يتم إضافة صور لهذا العمل بعد، يرجى التحقق لاحقاً.</p>
                    </div>
                @endif
            </div>

            <!-- ===== أزرار المشاركة وزر العودة ===== -->
            <div class="row mt-5">
                <div class="col-md-4">
                    <a href="{{ route('portfolio.index') }}" class="btn-back">
                        <i class="bi bi-arrow-right"></i> العودة إلى المعرض
                    </a>
                </div>
            </div>

        </div>

        <!-- ======= CTA Section ======= -->
        <section class="cta-section-enhanced">
            <div class="cta-overlay"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <div class="cta-content">
                            <span class="cta-badge">مشاريع مماثلة</span>
                            <h2 class="mb-4">هل أعجبك ما رأيت وتريد تنفيذ مشروع مماثل؟</h2>
                            <p class="mb-5">تواصل معنا الآن للحصول على استشارة مجانية والبدء في تحويل أفكارك إلى واقع
                                ملموس مع فريقنا المتخصص من الخبراء.</p>
                            <div class="cta-buttons">
                                <a href="{{ route('home') }}#contact" class="cta-button-primary">
                                    <i class="bi bi-chat-dots-fill me-2"></i>تواصل معنا
                                </a>
                                <a href="{{ route('portfolio.index') }}" class="cta-button-secondary">
                                    <i class="bi bi-collection-fill me-2"></i>معرض الأعمال
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- End CTA Section -->
    </main><!-- End #main -->
@endsection

@section('scripts')
    <!-- GLightbox لمعرض الصور -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // تهيئة تأثيرات الحركة AOS
            AOS.init({
                duration: 800,
                easing: 'ease',
                once: true,
                offset: 100
            });

            // تهيئة GLightbox - معرض الصور المتقدم
            const lightbox = GLightbox({
                selector: '.glightbox',
                touchNavigation: true,
                loop: true,
                autoplayVideos: true,
                openEffect: 'zoom',
                closeEffect: 'fade',
                cssEfects: {
                    zoom: {
                        in: 'zoomIn',
                        out: 'zoomOut'
                    },
                    fade: {
                        in: 'fadeIn',
                        out: 'fadeOut'
                    },
                    none: {
                        in: 'none',
                        out: 'none'
                    },
                    slide: {
                        in: 'slideInRight',
                        out: 'slideOutLeft'
                    }
                },
                dragAutoSnap: true,
                preload: true,
                zoomable: true,
                draggable: true
            });

            // فلترة الصور حسب التصنيف
            const filterButtons = document.querySelectorAll('.gallery-filter-btn');
            const galleryItems = document.querySelectorAll('.gallery-item-wrapper');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // إزالة الكلاس النشط من جميع الأزرار
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    // إضافة الكلاس النشط للزر المضغوط
                    this.classList.add('active');

                    const filterValue = this.getAttribute('data-filter');

                    galleryItems.forEach(item => {
                        if (filterValue === '*') {
                            item.style.display = 'block';
                        } else {
                            if (item.getAttribute('data-category') === filterValue) {
                                item.style.display = 'block';
                            } else {
                                item.style.display = 'none';
                            }
                        }
                    });
                });
            });

            // زر تحميل المزيد من الصور
            const loadMoreBtn = document.getElementById('load-more-btn');
            if (loadMoreBtn) {
                const initialItems = 12;
                let visibleItems = initialItems;

                // إخفاء الصور الزائدة عن العدد المبدئي
                galleryItems.forEach((item, index) => {
                    if (index >= initialItems) {
                        item.style.display = 'none';
                    }
                });

                loadMoreBtn.addEventListener('click', function() {
                    // عرض المزيد من الصور
                    for (let i = visibleItems; i < visibleItems + 6; i++) {
                        if (galleryItems[i]) {
                            galleryItems[i].style.display = 'block';
                            // إضافة تأثير ظهور للصور الجديدة
                            setTimeout(() => {
                                galleryItems[i].classList.add('aos-animate');
                            }, 100 * (i - visibleItems));
                        }
                    }

                    visibleItems += 6;

                    // إخفاء الزر إذا تم عرض جميع الصور
                    if (visibleItems >= galleryItems.length) {
                        this.style.display = 'none';
                    }
                });
            }
        });
    </script>
@endsection
