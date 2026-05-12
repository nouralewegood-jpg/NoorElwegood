@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets-home/css/pages/service-details.css') }}">
@endsection

@section('content')
    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <div class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="{{ route('home') }}">الرئيسية</a></li>
                    <li><a href="{{ route('home') }}#services">الخدمات</a></li>
                    <li>{{ $service->title }}</li>
                </ol>
            </div>
        </div><!-- End Breadcrumbs -->

        <!-- ======= Service Details Section ======= -->
        <section class="service-details">
            <div class="container" data-aos="fade-up">

                <div class="service-details-header">
                    <div class="service-icon">
                        <i class="{{ $service->icon }}"></i>
                    </div>
                    <h1>{{ $service->title }}</h1>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        @if ($service->image)
                            <div class="service-details-image" data-aos="zoom-in">
                                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}"
                                    class="img-fluid">
                            </div>
                        @endif

                        <div class="service-details-content" data-aos="fade-up">
                            <h2>نظرة عامة</h2>
                            <p>{{ $service->description }}</p>

                            <p>
                                نحن في شركة نور الوجود نتميز بتقديم أفضل الخدمات في مجال {{ $service->title }} في الإمارات
                                العربية المتحدة.
                                نؤمن بأن الخدمة الجيدة تبدأ من فهم احتياجات العميل وتنتهي بتقديم نتائج تتجاوز توقعاته.
                            </p>

                            <p>
                                مع فريق من الفنيين المهرة المتخصصين في {{ $service->title }}، نستطيع تقديم حلول احترافية
                                ومخصصة لتلبية احتياجات مشروعك، سواء كان لمنزل صغير أو فيلا فاخرة أو مشروع تجاري.
                            </p>
                        </div>

                        <div class="service-features" data-aos="fade-up">
                            <h3>مميزات الخدمة</h3>
                            <ul class="features-list">
                                <li>فريق متخصص من الفنيين المهرة في مجال {{ $service->title }}</li>
                                <li>استخدام مواد عالية الجودة مقاومة للرطوبة والخدوش</li>
                                <li>الالتزام بمواعيد التنفيذ المتفق عليها</li>
                                <li>خدمة ما بعد التنفيذ لضمان الجودة</li>
                                <li>أسعار منافسة مع جودة عالية</li>
                                <li>خبرة واسعة في تنفيذ المشاريع في أبو ظبي والعين</li>
                            </ul>
                        </div>

                        <div class="service-details-content" data-aos="fade-up">
                            <h2>منهجية العمل</h2>
                            <p>
                                تقوم منهجيتنا في العمل على فهم احتياجات العميل أولاً، ثم معاينة الموقع وتقديم عرض سعر
                                تفصيلي،
                                يلي ذلك اختيار المواد المناسبة ومناقشة التصميم، ثم تنفيذ العمل بدقة عالية وفق المواصفات
                                المتفق عليها،
                                وأخيراً مرحلة التسليم ومتابعة الجودة.
                            </p>

                            <p>
                                نحرص على إشراك العميل في جميع مراحل العمل، والاستماع إلى ملاحظاته واحتياجاته،
                                لنضمن تحقيق أقصى درجات الرضا. كما نقدم ضمان على جميع أعمالنا لمدة تتراوح بين 6 أشهر إلى
                                سنتين حسب نوع الخدمة.
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="sidebar">
                            <div class="service-features" data-aos="fade-up">
                                @php
                                    // استدعاء بيانات الاتصال من قاعدة البيانات
                                    $contactSection = \App\Models\ContactSection::where('is_active', true)->first();
                                    if (!$contactSection) {
                                        $contactSection = \App\Models\ContactSection::first();
                                    }
                                @endphp
                                <h3>احصل على الخدمة</h3>
                                <p>للاستفسار أو طلب الخدمة، يمكنك التواصل معنا عبر:</p>
                                <ul class="features-list">
                                    @if ($contactSection && $contactSection->phone)
                                        <li>الاتصال المباشر: {{ $contactSection->phone }}</li>
                                    @endif

                                    @if ($contactSection && $contactSection->email)
                                        <li>البريد الإلكتروني: {{ $contactSection->email }}</li>
                                    @endif

                                    <li>نموذج التواصل في موقعنا</li>

                                    @if ($contactSection && $contactSection->address)
                                        <li>العنوان: {{ $contactSection->address }}</li>
                                    @endif
                                </ul>
                                <a href="{{ route('home') }}#contact" class="btn btn-primary w-100 mt-3">اطلب الخدمة
                                    الآن</a>

                                @if ($contactSection)
                                    <div class="social-links mt-3">
                                        @if ($contactSection->social_facebook)
                                            <a href="{{ $contactSection->social_facebook }}" class="facebook"
                                                target="_blank"><i class="bi bi-facebook"></i></a>
                                        @endif
                                        @if ($contactSection->social_twitter)
                                            <a href="{{ $contactSection->social_twitter }}" class="twitter"
                                                target="_blank"><i class="bi bi-twitter"></i></a>
                                        @endif
                                        @if ($contactSection->social_instagram)
                                            <a href="{{ $contactSection->social_instagram }}" class="instagram"
                                                target="_blank"><i class="bi bi-instagram"></i></a>
                                        @endif
                                        @if ($contactSection->social_linkedin)
                                            <a href="{{ $contactSection->social_linkedin }}" class="linkedin"
                                                target="_blank"><i class="bi bi-linkedin"></i></a>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="service-features mt-4" data-aos="fade-up" data-aos-delay="100">
                                <h3>خدمات أخرى</h3>
                                <ul class="features-list">
                                    @foreach ($otherServices as $otherService)
                                        <li>
                                            <a href="{{ route('service.details', ['slug' => $otherService->id]) }}">
                                                {{ $otherService->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section><!-- End Service Details Section -->

        <!-- ======= CTA Section (Hard-coded version) ======= -->
        <div class="cta-section">
            <div class="container">
                <h2>هل أنت مستعد للبدء؟</h2>
                <p>تواصل معنا الآن للحصول على استشارة مجانية ومعرفة كيف يمكننا مساعدتك في تحقيق أهدافك.</p>
                <a href="{{ route('home') }}#contact" class="cta-button">تواصل معنا</a>
            </div>
        </div><!-- End CTA Section -->

        <!-- ======= Other Services Section ======= -->
        <section class="other-services">
            <div class="container" data-aos="fade-up">
                <h2>خدمات أخرى قد تهمك</h2>

                <div class="row g-4">
                    @foreach ($otherServices as $otherService)
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="other-service-card">
                                <div class="other-service-icon">
                                    <i class="{{ $otherService->icon }}"></i>
                                </div>
                                <div class="other-service-content">
                                    <h3>{{ $otherService->title }}</h3>
                                    <p>{{ Str::limit($otherService->description, 100) }}</p>
                                    <a href="{{ route('service.details', ['slug' => $otherService->id]) }}"
                                        class="read-more">
                                        قراءة المزيد <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section><!-- End Other Services Section -->

    </main><!-- End #main -->
@endsection

@section('script')
    <script src="{{ asset('assets-home/js/pages/service-details.js') }}"></script>
@endsection
