@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets-home/css/custom-home.css') }}">
    <!-- CSS القوانين المضافة للتأكد من عرض المحتوى مباشرة -->
    <style>
        [data-aos] {
            opacity: 1 !important;
            transform: none !important;
            transition: none !important;
        }

        .page-content,
        .section,
        .page-title,
        .hero,
        .about,
        .features,
        .services,
        .testimonials,
        .pricing,
        .contact,
        .footer {
            opacity: 1 !important;
            visibility: visible !important;
        }
    </style>
@endsection

@section('content')
    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
                            @if ($homeSection)
                                <div class="company-badge mb-4">
                                    <i class="bi bi-gear-fill me-3"></i>
                                    {{ $homeSection->company_badge }}
                                </div>

                                <h1 class="mb-4">
                                    {{ $homeSection->main_title_line1 }} <br>
                                </h1>
                                <h2>
                                    {{ $homeSection->main_title_line2 }} <br>

                                </h2>
                                <span class="accent-text">{{ $homeSection->main_title_line3 }}</span>

                                <p class="mb-4 mb-md-5">
                                    {{ $homeSection->description }}
                                </p>

                                <div class="hero-buttons">
                                    <a href="https://wa.me/{{ preg_replace('/\s+/', '', str_replace('+', '', $homeSection->whatsapp_number ?? ($contactSection->whatsapp_number ?? $contactSection->phone))) }}"
                                        target="_blank" class="btn btn-primary me-0 me-sm-2 mx-1">
                                        <i class="bi bi-whatsapp me-1"></i>
                                        تواصل واتساب
                                    </a>
                                    <a href="tel:{{ preg_replace('/\s+/', '', $homeSection->phone_number1 ?? ($contactSection->phone ?? '')) }}"
                                        class="btn btn-outline-primary mt-2 mt-sm-0">
                                        <i class="bi bi-telephone-fill me-1"></i>
                                        اتصل بنا
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="hero-image" data-aos="zoom-out" data-aos-delay="300">
                            @if ($homeSection)
                                <img src="{{ asset('storage/' . $homeSection->hero_image) }}" alt="Hero Image"
                                    class="img-fluid">

                                <div class="customers-badge">
                                    <div class="customer-avatars">
                                        <img src="{{ asset('assets-home') }}/img/avatar-1.webp" alt="Customer 1"
                                            class="avatar">
                                        <img src="{{ asset('assets-home') }}/img/avatar-2.webp" alt="Customer 2"
                                            class="avatar">
                                        <img src="{{ asset('assets-home') }}/img/avatar-3.webp" alt="Customer 3"
                                            class="avatar">
                                        <img src="{{ asset('assets-home') }}/img/avatar-4.webp" alt="Customer 4"
                                            class="avatar">
                                        <img src="{{ asset('assets-home') }}/img/avatar-5.webp" alt="Customer 5"
                                            class="avatar">
                                        <span class="avatar more">{{ $homeSection->customer_count }}+</span>
                                    </div>
                                    <p class="mb-0 mt-2">{{ $homeSection->customer_text }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>



            </div>

        </section><!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4 align-items-center justify-content-between">

                    <div class="col-xl-5" data-aos="fade-up" data-aos-delay="200">
                        @if ($aboutSection)
                            <span class="about-meta">{{ $aboutSection->meta_text }}</span>
                            <h2 class="about-title">{{ $aboutSection->title }}</h2>
                            <p class="about-description">{{ $aboutSection->description }}</p>

                            <div class="row feature-list-wrapper">
                                <div class="col-md-6">
                                    <ul class="feature-list">
                                        @foreach ($aboutSection->features->take(3) as $feature)
                                            <li><i class="bi bi-check-circle-fill"></i> {{ $feature->feature_text }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="feature-list">
                                        @foreach ($aboutSection->features->skip(3)->take(3) as $feature)
                                            <li><i class="bi bi-check-circle-fill"></i> {{ $feature->feature_text }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="info-wrapper">
                                <div class="row gy-4">
                                    <div class="col-lg-5">
                                        <div class="profile d-flex align-items-center gap-3">
                                            <img src="{{ asset('storage/' . $aboutSection->ceo_image) }}" alt="CEO Profile"
                                                class="profile-image">
                                            <div>
                                                <h4 class="profile-name">{{ $aboutSection->ceo_name }}</h4>
                                                <p class="profile-position">{{ $aboutSection->ceo_position }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="contact-info d-flex align-items-center gap-2">
                                            <i class="bi bi-telephone-fill"></i>
                                            <div>
                                                <p class="contact-label">{{ $aboutSection->phone_label }}</p>
                                                <p class="contact-number">{{ $aboutSection->phone_number }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-xl-6" data-aos="fade-up" data-aos-delay="300">
                        @if ($aboutSection)
                            <div class="image-wrapper">
                                <div class="images position-relative" data-aos="zoom-out" data-aos-delay="400">
                                    <img src="{{ asset('storage/' . $aboutSection->main_image) }}" alt="Business Meeting"
                                        class="img-fluid main-image rounded-4">
                                    <img src="{{ asset('storage/' . $aboutSection->secondary_image) }}"
                                        alt="Team Discussion" class="img-fluid small-image rounded-4">
                                </div>
                                <div class="experience-badge floating">
                                    <h3>{{ $aboutSection->years_experience }}+ <span>Years</span></h3>
                                    <p>{{ $aboutSection->experience_text }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

        </section><!-- /About Section -->

        <!-- Features Section -->
        <section id="features" class="features section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                @if ($featureSection)
                    <h2>{{ $featureSection->title }}</h2>
                    <p>{{ $featureSection->description }}</p>
                @endif
            </div><!-- End Section Title -->

            <div class="container">

                <div class="d-flex justify-content-center">
                    @if ($featureSection)
                        <ul class="nav nav-tabs" data-aos="fade-up" data-aos-delay="100">
                            @foreach ($featureSection->items->where('is_active', true)->sortBy('ordering') as $index => $item)
                                <li class="nav-item">
                                    <a class="nav-link {{ $index === 0 ? 'active show' : '' }}" data-bs-toggle="tab"
                                        data-bs-target="#features-tab-{{ $item->id }}">
                                        <h4>{{ $item->tab_name }}</h4>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="tab-content" data-aos="fade-up" data-aos-delay="200">
                    @if ($featureSection)
                        @foreach ($featureSection->items->where('is_active', true)->sortBy('ordering') as $index => $item)
                            <div class="tab-pane fade {{ $index === 0 ? 'active show' : '' }}"
                                id="features-tab-{{ $item->id }}">
                                <div class="row">
                                    <div
                                        class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0 d-flex flex-column justify-content-center">
                                        <h3>{{ $item->title }}</h3>
                                        <p class="fst-italic">
                                            {{ $item->description }}
                                        </p>
                                        <!-- Aquí puedes agregar más contenido si necesitas -->
                                    </div>
                                    <div class="col-lg-6 order-1 order-lg-2 text-center">
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}"
                                            class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

            </div>

        </section><!-- /Features Section -->

        <!-- Services Section -->
        <section id="services" class="services section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                @if ($serviceSection)
                    <h2>{{ $serviceSection->title }}</h2>
                    <p>{{ $serviceSection->description }}</p>
                @endif
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row g-4">
                    @if ($serviceSection)
                        @foreach ($serviceSection->items->where('is_active', true)->sortBy('ordering') as $service)
                            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="{{ 100 + $loop->index * 100 }}">
                                <div class="service-card d-flex">
                                    <div class="icon flex-shrink-0 me-3">
                                        <i class="{{ $service->icon }}"></i>
                                    </div>
                                    <div class="m-2">
                                        <h3><a href="{{ route('service.details', ['slug' => $service->id]) }}"
                                                style="color: inherit; text-decoration: none;">{{ $service->title }}</a>
                                        </h3>
                                        <p>{{ $service->description }}</p>
                                        <a href="{{ route('service.details', ['slug' => $service->id]) }}"
                                            class="read-more">قراءة المزيد <i class="bi bi-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

            </div>

        </section><!-- /Services Section -->

        <!-- Testimonials Section -->
        @if ($testimonials->isNotEmpty())
            <section id="testimonials" class="testimonials section">
                <div class="container section-title" data-aos="fade-up">
                    <h2>آراء العملاء</h2>
                    <p>ما قاله عملاؤنا عنا</p>
                </div>

                <div class="container" data-aos="fade-up" data-aos-delay="100">
                    <div class="row g-4">
                        @foreach ($testimonials as $t)
                            <div class="col-md-6 col-lg-3" data-aos="fade-up"
                                data-aos-delay="{{ 100 + $loop->index * 100 }}">
                                <div class="testimonial-card p-4 text-center">
                                    @if ($t->image)
                                        <img src="{{ asset('storage/' . $t->image) }}" alt="{{ $t->customer_name }}"
                                            class="rounded-circle mb-3" width="80" height="80">
                                    @endif

                                    <!-- عرض النجوم باستخدام Bootstrap Icons -->
                                    <div class="testimonial-rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= ($t->stars ?? 5))
                                                <i class="bi bi-star-fill"></i>
                                            @else
                                                <i class="bi bi-star"></i>
                                            @endif
                                        @endfor
                                    </div>

                                    <p class="mb-3 fst-italic">"{{ $t->quote }}"</p>
                                    <h5 class="mb-1">{{ $t->customer_name }}</h5>
                                    @if ($t->customer_position)
                                        <small class="text-muted">{{ $t->customer_position }}</small>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section><!-- /Testimonials Section -->
        @endif

        <!-- Pricing Section -->
        <section id="pricing" class="pricing section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                @if ($pricingSection)
                    <h2>{{ $pricingSection->title }}</h2>
                    <p>{{ $pricingSection->description }}</p>
                @endif
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row g-4 justify-content-center">
                    @if ($pricingSection)
                        @foreach ($pricingSection->plans->where('is_active', true)->sortBy('ordering') as $plan)
                            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ 100 + $loop->index * 100 }}">
                                <div class="pricing-card {{ $plan->is_featured ? 'popular' : '' }}">
                                    @if ($plan->is_featured)
                                        <div class="popular-badge">الخطة الأكثر اختيارًا</div>
                                    @endif
                                    <h3>{{ $plan->plan_name }}</h3>
                                    <div class="price">
                                        <span class="currency">{{ $plan->currency ?? '' }}</span>
                                        <span class="amount">{{ $plan->price }}</span>
                                        <span class="period">/ {{ $plan->price_period }}</span>
                                    </div>

                                    <h4>المميزات المتضمنة:</h4>
                                    <ul class="features-list">
                                        @foreach ($plan->features->where('is_included', true)->sortBy('ordering') as $feature)
                                            <li>
                                                <i class="bi bi-check-circle-fill"></i>
                                                {{ $feature->feature_text }}
                                            </li>
                                        @endforeach
                                    </ul>

                                    <button
                                        onclick="openPlanModal('{{ $plan->plan_name }}', '{{ $plan->currency ?? '' }}{{ $plan->price }}', '{{ $plan->price_period }}')"
                                        class="btn {{ $plan->is_featured ? 'btn-light' : 'btn-primary' }}">
                                        {{ $plan->btn_text ?? 'اختر الخطة' }}
                                        <i class="bi bi-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

            </div>

        </section><!-- /Pricing Section -->

        <!-- نافذة تفاصيل الخطة المنبثقة -->
        <div class="modal fade" id="planModal" tabindex="-1" aria-labelledby="planModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white" id="planModalLabel">طلب الخطة</h5>
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                            aria-label="إغلاق"></button>
                    </div>
                    <div class="modal-body">
                        <div class="selected-plan-details mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 id="selectedPlanName" class="mb-0">الباقة القياسية</h4>
                                <span class="badge bg-primary" id="selectedPlanPrice">ريال2499.00</span>
                            </div>
                            <small class="text-muted" id="selectedPlanPeriod">شهرياً</small>
                        </div>

                        <form id="planRequestForm">
                            <div class="mb-3">
                                <label for="clientName" class="form-label">الاسم <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="clientName" required>
                                <div class="invalid-feedback">
                                    يرجى إدخال اسمك
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="countrySelect" class="form-label">الدولة <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="countrySelect" required>
                                    <option value="" selected disabled>اختر الدولة</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->code }}"
                                            data-country-code="{{ $country->country_code }}"
                                            data-country="{{ $country->name_ar }}" data-flag="{{ $country->flag }}"
                                            data-min="{{ $country->min_length }}" data-max="{{ $country->max_length }}">
                                            {{ $country->flag }} {{ $country->name_ar }} ({{ $country->country_code }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    يرجى اختيار الدولة
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="clientPhone" class="form-label">رقم الواتساب <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" id="countryCodePrefix">+xxx</span>
                                    <input type="tel" class="form-control" id="clientPhone"
                                        placeholder="رقم الواتساب" required>
                                </div>
                                <div class="form-text text-muted">أدخل رقم الواتساب بدون مفتاح الدولة</div>
                                <div class="invalid-feedback" id="phone-error-modal">
                                    يرجى إدخال رقم هاتف صحيح
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="projectDetails" class="form-label">تفاصيل المشروع</label>
                                <textarea class="form-control" id="projectDetails" rows="4"
                                    placeholder="يرجى مشاركة تفاصيل مشروعك وأي متطلبات خاصة"></textarea>
                            </div>
                            <div class="alert alert-success d-none" id="planSuccessMessage">
                                <i class="bi bi-check-circle me-2"></i> تم إرسال طلبك بنجاح. سنتواصل معك قريباً.
                            </div>
                            <div class="alert alert-danger d-none" id="planErrorMessage">
                                <i class="bi bi-exclamation-circle me-2"></i> حدث خطأ أثناء إرسال طلبك. الرجاء المحاولة مرة
                                أخرى.
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="button" class="btn btn-primary" id="submitPlanRequest"
                            style="display: inline-block;">
                            <span class="spinner-border spinner-border-sm d-none" id="submitSpinner" role="status"
                                aria-hidden="true"></span>
                            <i class="bi bi-send me-1"></i> إرسال الطلب
                        </button>
                        <a href="https://wa.me/{{ preg_replace('/\s+/', '', str_replace('+', '', $contactSection->whatsapp_number ?? $contactSection->phone)) }}"
                            class="btn btn-success" id="whatsappButton" style="display: none;" target="_blank">
                            <i class="bi bi-whatsapp me-1"></i> تواصل عبر واتساب
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Blog Section -->
        <section id="blog" class="blog section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>أحدث المقالات</h2>
                <p>تابع أحدث المقالات والمستجدات في مدونتنا</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row g-4">
                    @forelse($recentPosts as $post)
                        <div class="col-lg-4 col-md-6" data-aos="fade-up"
                            data-aos-delay="{{ 100 + $loop->index * 100 }}">
                            <div class="post-card">
                                <div class="post-img">
                                    @if ($post->featured_image)
                                        @if (Str::startsWith($post->featured_image, 'http'))
                                            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}"
                                                class="img-fluid">
                                        @else
                                            <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}"
                                                class="img-fluid">
                                        @endif
                                    @else
                                        <img src="{{ asset('assets-home/img/blog-placeholder.jpg') }}"
                                            alt="{{ $post->title }}" class="img-fluid">
                                    @endif
                                </div>

                                <div class="post-meta">
                                    <span><i class="bi bi-calendar-date"></i>
                                        {{ $post->created_at->format('d M, Y') }}</span>
                                    @if ($post->category)
                                        <span><i class="bi bi-folder"></i> {{ $post->category->name }}</span>
                                    @endif
                                </div>

                                <div class="post-content">
                                    <h3 class="post-title">{{ $post->title }}</h3>
                                    <p>{{ Str::limit(strip_tags($post->excerpt ?? $post->content), 100) }}</p>
                                    <a href="{{ route('blog.show', $post->slug) }}" class="btn-link">اقرأ المزيد <i
                                            class="bi bi-arrow-left"></i></a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p>لا توجد مقالات منشورة حالياً.</p>
                        </div>
                    @endforelse
                </div>

                <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="400">
                    <a href="{{ route('blog.index') }}" class="btn btn-primary">
                        <i class="bi bi-journal-richtext"></i> تصفح المدونة كاملة
                    </a>
                </div>
            </div>
        </section><!-- /Blog Section -->

        <!-- Portfolio Section -->
        @if (isset($featuredPortfolios) && $featuredPortfolios->count() > 0)
            <section id="portfolio" class="portfolio section">
                <!-- Section Title -->
                <div class="container section-title" data-aos="fade-up">
                    <h2>أعمالنا المميزة</h2>
                    <p>نفخر بتقديم نماذج من أعمالنا المتميزة في مجال الديكور والتصميم الداخلي</p>
                </div><!-- End Section Title -->

                <div class="container" data-aos="fade-up" data-aos-delay="100">
                    <div class="row g-4 portfolio-grid">
                        @foreach ($featuredPortfolios as $portfolio)
                        <div class="col-lg-4 col-md-6 portfolio-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="portfolio-card">
                                <a href="{{ route('portfolio.show', $portfolio->id) }}" class="portfolio-card-link">
                                    <div class="portfolio-image">
                                        <img src="{{ $portfolio->image_url }}" alt="{{ $portfolio->title }}" loading="lazy">
                                        <div class="portfolio-overlay">
                                            <div class="portfolio-overlay-content">
                                                <h3 class="portfolio-title">{{ $portfolio->title }}</h3>
                                                @if($portfolio->category)
                                                <div class="portfolio-category">{{ $portfolio->category }}</div>
                                                @endif
                                                <span class="portfolio-button">
                                                    <i class="bi bi-arrow-right-circle"></i> عرض التفاصيل
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="portfolio-info">
                                        <h3 class="portfolio-info-title">{{ $portfolio->title }}</h3>
                                        @if($portfolio->category)
                                        <div class="portfolio-info-category">{{ $portfolio->category }}</div>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="400">
                        <a href="{{ route('portfolio.index') }}" class="btn btn-primary">
                            <i class="bi bi-grid me-2"></i> عرض جميع الأعمال
                        </a>
                    </div>
                </div>
            </section><!-- /Portfolio Section -->
        @endif

        <!-- Contact Section -->
        <section id="contact" class="contact section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                @if ($contactSection)
                    <h2>{{ $contactSection->title }}</h2>
                    <p>{{ $contactSection->subtitle ?? $contactSection->description }}</p>
                @endif
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row g-4 g-lg-5">
                    <div class="col-lg-5">
                        @if ($contactSection)
                            <div class="info-box" data-aos="fade-up" data-aos-delay="200">
                                <h3>{{ $contactSection->info_title ?? 'معلومات الاتصال' }}</h3>
                                <p>{{ $contactSection->info_description ?? $contactSection->description }}</p>

                                <div class="info-item" data-aos="fade-up" data-aos-delay="300">
                                    <div class="icon-box">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>
                                    <div class="content">
                                        <h4>{{ $contactSection->location_title ?? 'العنوان' }}</h4>
                                        <p>{{ $contactSection->address_line1 ?? $contactSection->address }}</p>
                                        <p>{{ $contactSection->address_line2 ?? '' }}</p>
                                    </div>
                                </div>

                                <div class="info-item" data-aos="fade-up" data-aos-delay="400">
                                    <div class="icon-box">
                                        <i class="bi bi-telephone"></i>
                                    </div>
                                    <div class="content">
                                        <h4>{{ $contactSection->phone_title ?? 'الهاتف' }}</h4>
                                        <p>{{ $contactSection->phone_number1 ?? $contactSection->phone }}</p>
                                        <p>{{ $contactSection->phone_number2 ?? '' }}</p>
                                    </div>
                                </div>

                                <div class="info-item" data-aos="fade-up" data-aos-delay="500">
                                    <div class="icon-box">
                                        <i class="bi bi-envelope"></i>
                                    </div>
                                    <div class="content">
                                        <h4>{{ $contactSection->email_title ?? 'البريد الإلكتروني' }}</h4>
                                        <p>{{ $contactSection->email1 ?? $contactSection->email }}</p>
                                        <p>{{ $contactSection->email2 ?? '' }}</p>
                                    </div>
                                </div>

                                <!-- إضافة وسائل التواصل الاجتماعي والاتصال -->
                                <div class="info-item social-contact-container" data-aos="fade-up" data-aos-delay="600">

                                    <div class="social-contact-links mt-3">
                                        @if ($contactSection->phone_number1 ?? $contactSection->phone)
                                            <a href="tel:{{ preg_replace('/\s+/', '', $contactSection->phone_number1 ?? $contactSection->phone) }}"
                                                title="اتصل بنا" class="social-contact-btn phone-btn">
                                                <i class="bi bi-telephone-fill"></i>
                                            </a>
                                        @endif

                                        @if ($contactSection->email1 ?? $contactSection->email)
                                            <a href="mailto:{{ $contactSection->email1 ?? $contactSection->email }}"
                                                title="راسلنا عبر البريد الإلكتروني" class="social-contact-btn email-btn">
                                                <i class="bi bi-envelope-fill"></i>
                                            </a>
                                        @endif

                                        @if ($contactSection->whatsapp_number ?? $contactSection->phone)
                                            <a href="https://wa.me/{{ preg_replace('/\s+/', '', str_replace('+', '', $contactSection->whatsapp_number ?? $contactSection->phone)) }}"
                                                target="_blank" title="تواصل عبر واتساب"
                                                class="social-contact-btn whatsapp-btn">
                                                <i class="bi bi-whatsapp"></i>
                                            </a>
                                        @endif

                                        @if ($contactSection->social_facebook ?? '')
                                            <a href="{{ $contactSection->social_facebook }}" target="_blank"
                                                title="فيسبوك" class="social-contact-btn facebook-btn">
                                                <i class="bi bi-facebook"></i>
                                            </a>
                                        @endif

                                        @if ($contactSection->social_twitter ?? '')
                                            <a href="{{ $contactSection->social_twitter }}" target="_blank"
                                                title="تويتر" class="social-contact-btn twitter-btn">
                                                <i class="bi bi-twitter-x"></i>
                                            </a>
                                        @endif

                                        @if ($contactSection->social_instagram ?? '')
                                            <a href="{{ $contactSection->social_instagram }}" target="_blank"
                                                title="إنستغرام" class="social-contact-btn instagram-btn">
                                                <i class="bi bi-instagram"></i>
                                            </a>
                                        @endif

                                        @if ($contactSection->social_linkedin ?? '')
                                            <a href="{{ $contactSection->social_linkedin }}" target="_blank"
                                                title="لينكد إن" class="social-contact-btn linkedin-btn">
                                                <i class="bi bi-linkedin"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-lg-7">
                        @if ($contactSection)
                            <div class="contact-form" data-aos="fade-up" data-aos-delay="300">
                                <h3>{{ $contactSection->form_title ?? 'أرسل رسالة' }}</h3>
                                <p>{{ $contactSection->form_description ?? 'نحن نتطلع للسماع منك. أرسل لنا رسالة وسنعود إليك في أقرب وقت ممكن.' }}
                                </p>



                                <!-- عرض رسائل النجاح والخطأ -->
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="إغلاق"></button>
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="إغلاق"></button>
                                    </div>
                                @endif

                                <form action="{{ route('message.send') }}" method="post" class="php-email-form"
                                    id="contactForm" data-aos="fade-up" data-aos-delay="200">
                                    @csrf
                                    <!-- توكن الأمان للحماية من هجمات CSRF -->
                                    <input type="hidden" name="_contact_token"
                                        value="{{ md5(uniqid(mt_rand(), true)) }}">

                                    <div class="row gy-4">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" name="name"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    placeholder="{{ $contactSection->name_placeholder ?? 'اسمك' }}"
                                                    value="{{ old('name') }}" maxlength="255" minlength="2" required
                                                    pattern="[^<>]*" title="يرجى إدخال اسم صالح بدون علامات خاصة">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message = $message ?? '' }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    name="email" value="{{ old('email') }}" maxlength="255"
                                                    placeholder="{{ $contactSection->email_placeholder ?? 'بريدك الإلكتروني' }}"
                                                    required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message = $message ?? '' }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group phone-input-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <select name="country_id" id="country-code"
                                                            class="form-control form-select @error('country_id') is-invalid @enderror">
                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country->id }}"
                                                                    data-min="{{ $country->min_length }}"
                                                                    data-max="{{ $country->max_length }}"
                                                                    data-code="{{ $country->country_code }}"
                                                                    {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                                                    {{ $country->flag }} {{ $country->country_code }}
                                                                    ({{ $country->name_ar }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <input type="tel"
                                                        class="form-control @error('phone_number') is-invalid @enderror"
                                                        name="phone_number" id="phone-number"
                                                        value="{{ old('phone_number') }}" placeholder="رقم الواتساب"
                                                        pattern="[0-9]*" inputmode="numeric" maxlength="15">
                                                </div>
                                                <div class="invalid-feedback" id="phone-error">
                                                    @error('phone_number')
                                                        {{ $message ?? '' }}
                                                    @enderror
                                                    @error('country_id')
                                                        {{ $message ?? '' }}
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text"
                                                    class="form-control @error('subject') is-invalid @enderror"
                                                    name="subject" value="{{ old('subject') }}" maxlength="255"
                                                    minlength="5"
                                                    placeholder="{{ $contactSection->subject_placeholder ?? 'موضوع الرسالة' }}"
                                                    required pattern="[^<>]*"
                                                    title="يرجى إدخال موضوع صالح بدون علامات خاصة">
                                                @error('subject')
                                                    <div class="invalid-feedback">{{ $message = $message ?? '' }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <textarea class="form-control @error('message') is-invalid @enderror" name="message" rows="6" minlength="10"
                                                    maxlength="5000" placeholder="{{ $contactSection->message_placeholder ?? 'رسالتك' }}" required
                                                    title="يرجى إدخال رسالة لا تقل عن 10 أحرف">{{ old('message') }}</textarea>
                                                @error('message')
                                                    <div class="invalid-feedback">{{ $message = $message ?? '' }}</div>
                                                @enderror
                                            </div>
                                            <small class="text-muted" id="charCount">0 / 5000 حرف</small>
                                        </div>

                                        <!-- إضافة honeypot لحماية من بوتات السبام -->
                                        <div class="form-group d-none">
                                            <label for="contact_me_by_fax_only">اتركه فارغاً</label>
                                            <input type="checkbox" name="contact_me_by_fax_only"
                                                id="contact_me_by_fax_only" value="1">
                                            <input type="text" name="username" value="">
                                        </div>

                                        <!-- إضافة رمز التحقق (reCAPTCHA) -->
                                        @if (config('services.recaptcha.enabled'))
                                            <div class="col-12 mb-3">
                                                <div class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror"
                                                    data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                                                @error('g-recaptcha-response')
                                                    <div class="invalid-feedback d-block">{{ $message = $message ?? '' }}
                                                    </div>
                                                @enderror
                                            </div>
                                        @endif

                                        <div class="col-12 text-center">
                                            <div class="loading">جاري التحميل</div>
                                            <div class="error-message"></div>
                                            <div class="sent-message">تم إرسال رسالتك بنجاح. شكرًا لك!</div>
                                            <button type="submit" id="submitBtn" class="btn"
                                                data-bs-toggle="tooltip"
                                                title="اضغط للإرسال">{{ $contactSection->button_text ?? 'إرسال الرسالة' }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>

                </div>

            </div>

        </section><!-- /Contact Section -->

    </main>
@endsection

@section('script')
    <script src="{{ asset('assets-home/js/custom-home.js') }}"></script>

    <!-- إضافة سكريبت reCAPTCHA إذا كان مفعلاً -->
    @if (config('services.recaptcha.enabled'))
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif

    <script>
        // دالة فتح النافذة المنبثقة لطلب الخطة
        function openPlanModal(planName, planPrice, planPeriod) {
            // تعيين بيانات الخطة المختارة في النافذة المنبثقة
            document.getElementById('selectedPlanName').textContent = planName;
            document.getElementById('selectedPlanPrice').textContent = planPrice;
            document.getElementById('selectedPlanPeriod').textContent = planPeriod;

            // فتح النافذة المنبثقة
            const planModal = new bootstrap.Modal(document.getElementById('planModal'));
            planModal.show();
        }

        document.addEventListener('DOMContentLoaded', function() {
            // التحقق من صحة رقم الهاتف في نموذج الاتصال الرئيسي
            const countryCodeSelect = document.getElementById('country-code');
            const phoneNumberInput = document.getElementById('phone-number');
            const phoneError = document.getElementById('phone-error');
            const contactForm = document.getElementById('contactForm');
            const messageArea = document.querySelector('textarea[name="message"]');
            const charCount = document.getElementById('charCount');

            // عداد الحروف للرسالة
            if (messageArea && charCount) {
                // تحديث عدد الحروف عند تحميل الصفحة
                charCount.textContent = `${messageArea.value.length} / 5000 حرف`;

                // تحديث عدد الحروف عند الكتابة
                messageArea.addEventListener('input', function() {
                    charCount.textContent = `${this.value.length} / 5000 حرف`;
                });
            }

            // ضبط الحد الأقصى للإدخال عند تحميل الصفحة
            if (countryCodeSelect && countryCodeSelect.selectedOptions.length > 0) {
                const maxDigits = parseInt(countryCodeSelect.selectedOptions[0].dataset.max);
                if (phoneNumberInput) {
                    phoneNumberInput.maxLength = maxDigits;
                }
            }

            // التحقق من صحة رقم الهاتف عند تغيير مفتاح الدولة أو إدخال الرقم
            function validatePhoneNumber() {
                if (!phoneNumberInput || !phoneNumberInput.value) {
                    // الرقم اختياري، لذلك لا داعي لعرض خطأ إذا كان فارغًا
                    if (phoneError) phoneError.textContent = '';
                    if (phoneNumberInput) phoneNumberInput.classList.remove('is-invalid');
                    return true;
                }

                // التحقق من أن الإدخال يحتوي على أرقام فقط
                if (!/^\d+$/.test(phoneNumberInput.value)) {
                    if (phoneError) phoneError.textContent = 'يجب أن يحتوي رقم الهاتف على أرقام فقط';
                    phoneNumberInput.classList.add('is-invalid');
                    return false;
                }

                // الحصول على الحد الأدنى والأقصى للدولة المحددة
                const selectedOption = countryCodeSelect.selectedOptions[0];
                const minDigits = parseInt(selectedOption.dataset.min);
                const maxDigits = parseInt(selectedOption.dataset.max);
                const phoneLength = phoneNumberInput.value.length;

                // التحقق من طول الرقم
                if (phoneLength < minDigits || phoneLength > maxDigits) {
                    const countryName = selectedOption.textContent.split('(')[1]?.split(')')[0] || 'المحددة';
                    if (phoneError) {
                        phoneError.textContent =
                            `عدد أرقام الهاتف ${countryName} يجب أن يكون بين ${minDigits} و ${maxDigits} رقمًا`;
                        phoneError.style.display = 'block';
                    }
                    phoneNumberInput.classList.add('is-invalid');
                    return false;
                }

                // الرقم صحيح
                if (phoneError) {
                    phoneError.textContent = '';
                    phoneError.style.display = 'none';
                }
                phoneNumberInput.classList.remove('is-invalid');
                return true;
            }

            // إضافة مستمعي الأحداث
            if (countryCodeSelect) {
                countryCodeSelect.addEventListener('change', function() {
                    // تحديث الحد الأقصى لطول الإدخال عند تغيير الدولة
                    const selectedOption = this.selectedOptions[0];
                    const maxDigits = parseInt(selectedOption.dataset.max);
                    if (phoneNumberInput) {
                        phoneNumberInput.maxLength = maxDigits;
                        validatePhoneNumber(); // إعادة التحقق عند تغيير الدولة
                    }
                });
            }

            if (phoneNumberInput) {
                phoneNumberInput.addEventListener('input', validatePhoneNumber);
            }

            // التحقق من النموذج بأكمله قبل الإرسال
            if (contactForm) {
                contactForm.addEventListener('submit', function(event) {
                    if (phoneNumberInput && phoneNumberInput.value && !validatePhoneNumber()) {
                        event.preventDefault(); // منع إرسال النموذج إذا كان هناك خطأ في رقم الهاتف
                    }
                });
            }

            // التعامل مع نافذة طلب الخطة المنبثقة
            const countrySelect = document.getElementById
            const clientPhone = document.getElementById('clientPhone');
            const phoneErrorModal = document.getElementById('phone-error-modal');
            const countryCodePrefix = document.getElementById('countryCodePrefix');
            const planRequestForm = document.getElementById('planRequestForm');
            const submitPlanRequest = document.getElementById('submitPlanRequest');

            // تحديث مفتاح الدولة عند تغيير اختيار الدولة
            if (countrySelect) {
                countrySelect.addEventListener('change', function() {
                    const selectedOption = this.selectedOptions[0];
                    if (selectedOption && countryCodePrefix) {
                        // تحديث نص مفتاح الدولة
                        countryCodePrefix.textContent = selectedOption.dataset.countryCode || '+xxx';

                        // تحديث الحد الأقصى لطول الإدخال
                        if (clientPhone) {
                            clientPhone.maxLength = parseInt(selectedOption.dataset.max) || 15;
                            validatePlanPhone(); // إعادة التحقق عند تغيير الدولة
                        }
                    }
                });
            }

            // وظيفة التحقق من صحة رقم الهاتف في النافذة المنبثقة
            function validatePlanPhone() {
                if (!clientPhone || !clientPhone.value) {
                    // الرقم مطلوب
                    if (phoneErrorModal) phoneErrorModal.textContent = 'يرجى إدخال رقم الهاتف';
                    if (clientPhone) clientPhone.classList.add('is-invalid');
                    return false;
                }

                // التحقق من أن الإدخال يحتوي على أرقام فقط
                if (!/^\d+$/.test(clientPhone.value)) {
                    if (phoneErrorModal) phoneErrorModal.textContent = 'يجب أن يحتوي رقم الهاتف على أرقام فقط';
                    clientPhone.classList.add('is-invalid');
                    return false;
                }

                // التحقق من الدولة المختارة
                if (!countrySelect || countrySelect.value === '') {
                    if (phoneErrorModal) phoneErrorModal.textContent = 'يرجى اختيار الدولة أولًا';
                    clientPhone.classList.add('is-invalid');
                    return false;
                }

                // الحصول على الحد الأدنى والأقصى للدولة المحددة
                const selectedOption = countrySelect.selectedOptions[0];
                const minDigits = parseInt(selectedOption.dataset.min);
                const maxDigits = parseInt(selectedOption.dataset.max);
                const phoneLength = clientPhone.value.length;

                // التحقق من طول الرقم
                if (phoneLength < minDigits || phoneLength > maxDigits) {
                    const countryName = selectedOption.dataset.country || 'المحددة';
                    if (phoneErrorModal) {
                        phoneErrorModal.textContent =
                            `عدد أرقام الهاتف ${countryName} يجب أن يكون بين ${minDigits} و ${maxDigits} رقمًا`;
                    }
                    clientPhone.classList.add('is-invalid');
                    return false;
                }

                // الرقم صحيح
                if (phoneErrorModal) phoneErrorModal.textContent = '';
                clientPhone.classList.remove('is-invalid');
                return true;
            }

            // التحقق من صحة رقم الهاتف عند الكتابة
            if (clientPhone) {
                clientPhone.addEventListener('input', validatePlanPhone);
            }

            // إرسال نموذج طلب الخطة
            if (submitPlanRequest && planRequestForm) {
                submitPlanRequest.addEventListener('click', function() {
                    // التحقق من حقول النموذج
                    const clientName = document.getElementById('clientName');
                    const projectDetails = document.getElementById('projectDetails');
                    const successMessage = document.getElementById('planSuccessMessage');
                    const errorMessage = document.getElementById('planErrorMessage');
                    const submitSpinner = document.getElementById('submitSpinner');
                    const whatsappButton = document.getElementById('whatsappButton');

                    let isValid = true;

                    // التحقق من الاسم
                    if (!clientName || !clientName.value.trim()) {
                        clientName.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        clientName.classList.remove('is-invalid');
                    }

                    // التحقق من الدولة
                    if (!countrySelect || countrySelect.value === '') {
                        countrySelect.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        countrySelect.classList.remove('is-invalid');
                    }

                    // التحقق من رقم الهاتف
                    if (!validatePlanPhone()) {
                        isValid = false;
                    }

                    // إذا كان النموذج صالحًا، أرسله
                    if (isValid) {
                        // إظهار مؤشر التحميل
                        submitSpinner.classList.remove('d-none');

                        // إخفاء الرسائل السابقة
                        successMessage.classList.add('d-none');
                        errorMessage.classList.add('d-none');

                        // إرسال البيانات باستخدام Fetch API
                        const phoneNumber = clientPhone.value.trim();
                        // حذف الصفر في بداية رقم الهاتف إذا وجد
                        const formattedPhoneNumber = phoneNumber.startsWith('0') ? phoneNumber.substring(
                            1) : phoneNumber;

                        const planData = {
                            plan_name: document.getElementById('selectedPlanName').textContent,
                            plan_price: document.getElementById('selectedPlanPrice').textContent,
                            plan_period: document.getElementById('selectedPlanPeriod').textContent,
                            client_name: clientName.value.trim(),
                            country_code: countrySelect.selectedOptions[0].dataset.countryCode,
                            country: countrySelect.selectedOptions[0].dataset.country,
                            phone_number: formattedPhoneNumber,
                            project_details: projectDetails ? projectDetails.value.trim() : '',
                            _token: "{{ csrf_token() }}"
                        };

                        // تنفيذ الطلب
                        fetch('{{ route('plan.request.submit') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify(planData)
                            })
                            .then(response => {
                                // Hide loading spinner
                                submitSpinner.classList.add('d-none');
                                if (!response.ok) {
                                    throw new Error('Network response was not ok ' + response
                                        .statusText);
                                }
                                return response.json();
                            })
                            .then(data => {
                                // Toggle based on success flag
                                if (data.success) {
                                    successMessage.classList.remove('d-none');
                                    errorMessage.classList.add('d-none');
                                } else {
                                    successMessage.classList.add('d-none');
                                    errorMessage.classList.remove('d-none');
                                    errorMessage.textContent = data.message ||
                                        'حدث خطأ أثناء معالجة طلبك. الرجاء المحاولة مرة أخرى.';
                                }
                            })
                            .catch(error => {
                                console.error('Fetch error:', error);
                                successMessage.classList.add('d-none');
                                errorMessage.classList.remove('d-none');
                                errorMessage.textContent =
                                    'حدث خطأ أثناء إرسال طلبك. يرجى المحاولة مرة أخرى.';
                            });
                    }
                });
            }
        });
    </script>

    <!-- سكريبت إضافي للتأكد من ظهور المحتوى فورًا -->
    <script>
        // إظهار جميع العناصر فورًا
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-aos]').forEach(function(el) {
                el.classList.add('aos-animate');
                el.style.opacity = '1';
                el.style.transform = 'translateZ(0)';
            });
        });

        // تعطيل تأثيرات AOS في حالة بطء التحميل
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.querySelectorAll('[data-aos]').forEach(function(el) {
                    el.classList.add('aos-animate');
                    el.style.opacity = '1';
                    el.style.transform = 'translateZ(0)';
                });
            }, 500);
        });
    </script>
@endsection
