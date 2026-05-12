<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', $seo['title'] ?? 'نور الوجود - الشركة الرائدة في خدمات الصيانة العامة والديكور')</title>

    <!-- Primary Meta Tags -->
    <meta name="title" content="@yield('title', $seo['title'] ?? 'نور الوجود - الشركة الرائدة في خدمات الصيانة العامة والديكور')">
    <meta name="description" content="@yield('meta_description', $seo['description'] ?? 'شركة نور الوجود هي شركة رائدة متخصصة في الصيانة العامة والديكور بما يشمل أعمال الدهانات، الجبس بورد، تركيب السيراميك، بديل الرخام والخشب، السباكة، الكهرباء، وتجارة الرخام في الإمارات العربية المتحدة')">
    <meta name="keywords" content="@yield('meta_keywords', $seo['keywords'] ?? 'نور الوجود, صيانة عامة, ديكور, دهانات, جبس بورد, سيراميك, بلاط, بديل رخام, بديل خشب, سباكة, كهرباء, فورسيلنج, مغاسل رخام, حدادة, الإمارات العربية المتحدة, أبو ظبي, العين')">
    <meta name="author" content="نور الوجود للصيانة العامة والديكور">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index, follow">
    <meta name="language" content="Arabic">
    <meta name="revisit-after" content="7 days">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', $seo['og_type'] ?? 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', $seo['title'] ?? 'نور الوجود - الشركة الرائدة في خدمات الصيانة العامة والديكور')">
    <meta property="og:description" content="@yield('meta_description', $seo['description'] ?? 'شركة نور الوجود هي شركة رائدة متخصصة في الصيانة العامة والديكور بما يشمل أعمال الدهانات، الجبس بورد، تركيب السيراميك، بديل الرخام والخشب، السباكة، الكهرباء، وتجارة الرخام في الإمارات العربية المتحدة')">
    <meta property="og:image" content="@yield('og_image', $seo['og_image'] ?? asset('assets-home/img/logo.png'))">
    <meta property="og:locale" content="ar_AR">
    <meta property="og:site_name" content="نور الوجود">

    <!-- Twitter -->
    <meta name="twitter:card" content="@yield('twitter_card', $seo['twitter_card'] ?? 'summary_large_image')">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('title', $seo['title'] ?? 'نور الوجود - الشركة الرائدة في خدمات الصيانة العامة والديكور')">
    <meta name="twitter:description" content="@yield('meta_description', $seo['description'] ?? 'شركة نور الوجود هي شركة رائدة متخصصة في الصيانة العامة والديكور بما يشمل أعمال الدهانات، الجبس بورد، تركيب السيراميك، بديل الرخام والخشب، السباكة، الكهرباء، وتجارة الرخام في الإمارات العربية المتحدة')">
    <meta name="twitter:image" content="@yield('og_image', $seo['og_image'] ?? asset('assets-home/img/logo.png'))">

    <!-- Canonical Link -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Geo Meta Tags -->
    <meta name="geo.region" content="AE">
    <meta name="geo.placename" content="United Arab Emirates, Abu Dhabi, Al Ain">
    <meta name="geo.position" content="24.4539;54.3773">
    <meta name="ICBM" content="24.4539, 54.3773">

    <!-- Favicons -->
    <link href="{{ asset('assets-home') }}/img/Noor-Elwgood-logo.ico" rel="icon">
    <link href="{{ asset('assets-home') }}/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets-home') }}/vendor/bootstrap/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="{{ asset('assets-home') }}/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('assets-home') }}/vendor/aos/aos.css" rel="stylesheet">
    <link href="{{ asset('assets-home') }}/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="{{ asset('assets-home') }}/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS Files -->
    <link href="{{ asset('assets-home') }}/css/main.css" rel="stylesheet">
    <link href="{{ asset('assets-home') }}/css/style.css" rel="stylesheet">
    <!-- Blog CSS -->
    <link href="{{ asset('assets-home') }}/css/blog.css" rel="stylesheet">
    <link href="{{ asset('assets-home') }}/chatbot/chatbot.css" rel="stylesheet">
    <link href="{{ asset('assets-home') }}/css/custom-features.css" rel="stylesheet">

    <!-- Custom Page Styles -->
    @yield('styles')

    <!-- أنماط مخصصة للروابط النشطة في شريط التنقل -->
    <style>
        .navmenu .nav-link.active {
            color: #F59C27 !important;
            font-weight: 600;
            position: relative;
        }

        .navmenu .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 10px;
            left: 15px;
            right: 15px;
            height: 2px;
            background-color: #F59C27;
            border-radius: 1px;
        }

        .navmenu .nav-link:hover::after {
            content: '';
            position: absolute;
            bottom: 10px;
            left: 15px;
            right: 15px;
            height: 2px;
            background-color: rgba(245, 156, 39, 0.4);
            border-radius: 1px;
            transition: all 0.3s ease;
        }

        .navmenu .nav-link {
            position: relative;
        }

        /* تحسين مظهر الروابط عند التمرير */
        @media (max-width: 1280px) {

            .navmenu .nav-link.active::after,
            .navmenu .nav-link:hover::after {
                left: 8px;
                right: 8px;
                bottom: 8px;
            }
        }
    </style>

    <base href="{{ url('/') }}/">

    @yield('css')
    @stack('styles')
</head>
