<header id="header" class="header d-flex align-items-center fixed-top">
    <div
        class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        <a href="{{ route('home') }}" class="logo d-flex align-items-center me-auto me-xl-0">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <!-- <img src="{{ asset('assets-home') }}/img/logo.png" alt=""> -->
            <h1 class="sitename">نور الوجود</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                @php
                    // استدعاء النماذج للتحقق من الأقسام النشطة
                    $homeSection = App\Models\HomeSection::where('is_active', true)->first();
                    $aboutSection = App\Models\AboutSection::where('is_active', true)->first();
                    $featureSection = App\Models\FeatureSection::where('is_active', true)->first();
                    $serviceSection = App\Models\ServiceSection::where('is_active', true)->first();
                    $pricingSection = App\Models\PricingSection::where('is_active', true)->first();
                    $contactSection = App\Models\ContactSection::where('is_active', true)->first();
                    // التحقق من وجود آراء عملاء نشطة
                    $activeTestimonials = App\Models\Testimonial::where('is_active', true)->count() > 0;
                @endphp

                @if ($homeSection)
                    <li><a href="{{ route('home') }}#hero" class="nav-link"><i class="bi bi-house-door"></i>
                            الرئيسية</a></li>
                @endif

                @if ($aboutSection)
                    <li><a href="{{ route('home') }}#about" class="nav-link"><i class="bi bi-info-circle"></i> من
                            نحن</a></li>
                @endif

                @if ($featureSection)
                    <li><a href="{{ route('home') }}#features" class="nav-link"><i class="bi bi-stars"></i> المميزات</a>
                    </li>
                @endif

                @if ($serviceSection)
                    <li><a href="{{ route('home') }}#services" class="nav-link"><i class="bi bi-gear"></i> الخدمات</a>
                    </li>
                @endif

                @if ($pricingSection)
                    <li><a href="{{ route('home') }}#pricing" class="nav-link"><i class="bi bi-currency-dollar"></i>
                            الأسعار</a></li>
                @endif

                <!-- إضافة قسم آراء العملاء إذا كان هناك آراء نشطة -->
                @if ($activeTestimonials)
                    <li><a href="{{ route('home') }}#testimonials" class="nav-link"><i class="bi bi-chat-quote"></i>
                            آراء العملاء</a></li>
                @endif

                <!-- إضافة رابط المدونة -->
                <li><a href="{{ route('blog.index') }}" class="nav-link"><i class="bi bi-journal-richtext"></i>
                        المدونة</a></li>
                <!-- إضافة رابط معرض الأعمال -->
                <li><a href="{{ route('portfolio.index') }}" class="nav-link"><i class="bi bi-grid"></i> معرض
                        الأعمال</a></li>

                @if ($contactSection)
                    <li><a href="{{ route('home') }}#contact" class="nav-link"><i class="bi bi-envelope"></i> اتصل
                            بنا</a></li>
                @endif

                @guest
                    <li><a href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i> تسجيل الدخول</a></li>
                @else
                    <li class="dropdown">
                        <a href="#"><span>{{ Auth::user()->name }}</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            @if (Auth::user()->role === 'admin')
                                <li><a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> لوحة تحكم
                                        المدير</a></li>
                            @elseif(Auth::user()->role === 'moderator')
                                <li><a href="{{ route('moderator.dashboard') }}"><i class="bi bi-layout-text-window"></i>
                                        لوحة تحكم المشرف</a></li>
                            @endif
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                                <a href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right"></i> تسجيل الخروج
                                </a>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <a class="btn-whatsapp"
            href="https://wa.me/{{ preg_replace('/\s+/', '', str_replace('+', '', $contactSection->whatsapp_number ?? $contactSection->phone)) }}"
            target="_blank">
            <i class="bi bi-whatsapp"></i>
            <span class="d-none d-md-inline-block">تواصل واتساب</span>
        </a>
    </div>
</header>

<!-- إضافة سكريبت للتعامل مع تحديد الروابط النشطة -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // وظيفة لتحديد القسم النشط عند تحميل الصفحة وأثناء التمرير
        function setActiveNavLink() {
            // الحصول على الرابط الحالي
            let currentUrl = window.location.href;
            let hash = window.location.hash;
            let path = window.location.pathname;

            // حذف الكلاس النشط من جميع الروابط
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.classList.remove('active');
            });

            // تفعيل الرابط المناسب بناءً على مسار الصفحة الحالية
            if (path.includes('/service') || path.includes('/services')) {
                // إذا كنت في صفحة خدمة، قم بتنشيط رابط الخدمات
                const servicesLink = document.querySelector('.nav-link[href$="#services"]');
                if (servicesLink) {
                    servicesLink.classList.add('active');
                }
            } else if (path.includes('/about')) {
                // إذا كنت في صفحة من نحن، قم بتنشيط رابط من نحن
                const aboutLink = document.querySelector('.nav-link[href$="#about"]');
                if (aboutLink) {
                    aboutLink.classList.add('active');
                }
            } else if (path.includes('/pricing') || path.includes('/plans')) {
                // إذا كنت في صفحة تسعير، قم بتنشيط رابط الأسعار
                const pricingLink = document.querySelector('.nav-link[href$="#pricing"]');
                if (pricingLink) {
                    pricingLink.classList.add('active');
                }
            } else if (path.includes('/contact')) {
                // إذا كنت في صفحة تواصل، قم بتنشيط رابط اتصل بنا
                const contactLink = document.querySelector('.nav-link[href$="#contact"]');
                if (contactLink) {
                    contactLink.classList.add('active');
                }
            } else if (path.includes('/features')) {
                // إذا كنت في صفحة مميزات، قم بتنشيط رابط المميزات
                const featuresLink = document.querySelector('.nav-link[href$="#features"]');
                if (featuresLink) {
                    featuresLink.classList.add('active');
                }
            } else if (path.includes('/blog')) {
                // إذا كنت في صفحة المدونة
                const blogLink = document.querySelector('.nav-link[href*="blog"]');
                if (blogLink) {
                    blogLink.classList.add('active');
                }
            } else if (path.includes('/testimonials')) {
                // إذا كنت في صفحة آراء العملاء
                const testimonialsLink = document.querySelector('.nav-link[href$="#testimonials"]');
                if (testimonialsLink) {
                    testimonialsLink.classList.add('active');
                }
            } else if (path === '/' || path === '/home' || path === '/index.php') {
                // إذا كنت في الصفحة الرئيسية
                if (hash) {
                    // إذا كان هناك هاش في الرابط (مثل #about)، أضف الكلاس النشط للرابط المطابق
                    const activeLink = document.querySelector(`.nav-link[href$="${hash}"]`);
                    if (activeLink) {
                        activeLink.classList.add('active');
                    }
                } else {
                    // إذا لم يكن هناك هاش، أضف الكلاس النشط لرابط "الرئيسية"
                    const homeLink = document.querySelector('.nav-link[href$="#hero"]');
                    if (homeLink) {
                        homeLink.classList.add('active');
                    }
                }

                // تحديث الروابط النشطة أثناء التمرير على الصفحة الرئيسية فقط
                const sections = document.querySelectorAll('section[id]');
                window.addEventListener('scroll', function() {
                    let current = '';

                    sections.forEach(section => {
                        const sectionTop = section.offsetTop -
                            100; // إزاحة لمراعاة الهيدر الثابت
                        const sectionHeight = section.offsetHeight;
                        if (window.scrollY >= sectionTop && window.scrollY < sectionTop +
                            sectionHeight) {
                            current = section.getAttribute('id');
                        }
                    });

                    // تحديث الروابط النشطة
                    if (current) {
                        navLinks.forEach(link => {
                            link.classList.remove('active');
                            if (link.getAttribute('href').includes(`#${current}`)) {
                                link.classList.add('active');
                            }
                        });
                    }
                });
            }
        }

        // تنفيذ الوظيفة عند تحميل الصفحة
        setActiveNavLink();

        // تنفيذ الوظيفة عند تغيير الهاش (عند النقر على الروابط)
        window.addEventListener('hashchange', setActiveNavLink);
    });
</script>

<style>
    /* تنسيقات إضافية للناف بار */
    .header {
        transition: all 0.5s;
    }

    .header .logo h1 {
        font-weight: 700;
        background-image: linear-gradient(135deg, #404770 0%, #575B75FF 100%);
        -webkit-background-clip: text;
        color: transparent;
        transition: all 0.3s;
    }

    .header .logo h1:hover {
        transform: translateY(-3px);
        text-shadow: 0 10px 15px rgba(13, 110, 253, 0.2);
    }

    .navmenu ul {
        margin: 0;
        padding: 0;
        display: flex;
        list-style: none;
        align-items: center;
    }

    .navmenu a,
    .navmenu a:focus {
        display: flex;
        align-items: center;
        position: relative;
        font-weight: 500;
        gap: 5px;
        transition: 0.3s;
        padding: 12px 15px;
    }

    .navmenu a i,
    .navmenu a:focus i {
        font-size: 15px;
        transition: 0.5s;
        margin-left: 2px;
    }

    .navmenu a:hover i {
        transform: translateY(-3px) scale(1.2);
    }

    .navmenu li:hover>a,
    .navmenu .nav-link.active {
        color: #f59c27 !important;
    }

    .btn-whatsapp {
        font-weight: 600;
        color: #fff;
        background-color: #25d366;
        padding: 8px 20px;
        border-radius: 30px;
        box-shadow: 0 8px 15px rgba(37, 211, 102, 0.3);
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-whatsapp:hover {
        background-color: #128C7E;
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(37, 211, 102, 0.4);
    }

    .btn-whatsapp i {
        font-size: 20px;
    }

    @media (max-width: 1280px) {

        .navmenu a,
        .navmenu a:focus {
            padding: 10px 12px;
            font-size: 14px;
        }

        .btn-whatsapp {
            padding: 7px 15px;
        }
    }

    /* تأثير الظهور والاختفاء للهيدر عند التمرير */
    .header.header-scrolled {
        padding: 8px 0;
        background-color: rgba(255, 255, 255, 0.98);
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
    }

    /* تنسيقات القائمة في وضع الموبايل */
    @media (max-width: 1279px) {
        .mobile-nav-toggle {
            font-size: 24px;
            color: #404770;
            cursor: pointer;
        }
    }
</style>
