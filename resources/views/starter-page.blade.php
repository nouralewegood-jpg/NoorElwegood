<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $page->title ?? 'Starter Page' }} - Pikkod</title>
    <meta name="description" content="{{ $page->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $page->meta_keywords ?? '' }}">

    <!-- Favicons -->
    <link href="{{ asset('assets-home') }}/img/favicon.png" rel="icon">
    <link href="{{ asset('assets-home') }}/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets-home') }}/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets-home') }}/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('assets-home') }}/vendor/aos/aos.css" rel="stylesheet">
    <link href="{{ asset('assets-home') }}/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="{{ asset('assets-home') }}/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS Files -->
    <link href="{{ asset('assets-home') }}/css/main.css" rel="stylesheet">
    <link href="{{ asset('assets-home') }}/css/pages.css" rel="stylesheet">

</head>

<body class="starter-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div
            class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="{{ route('home') }}" class="logo d-flex align-items-center me-auto me-xl-0">
                <h1 class="sitename">Pikkod</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('home') }}#about">About</a></li>
                    <li><a href="{{ route('home') }}#features">Features</a></li>
                    <li><a href="{{ route('home') }}#services">Services</a></li>
                    <li><a href="{{ route('home') }}#pricing">Pricing</a></li>
                    <li><a href="{{ route('home') }}#contact">Contact</a></li>

                    @guest
                        <li><a href="{{ route('login') }}">Login</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#"><span>{{ Auth::user()->name }}</span> <i
                                    class="bi bi-chevron-down toggle-dropdown"></i></a>
                            <ul>
                                @if (Auth::user()->role === 'admin')
                                    <li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                                @elseif(Auth::user()->role === 'moderator')
                                    <li><a href="{{ route('moderator.dashboard') }}">Moderator Dashboard</a></li>
                                @endif
                                <li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                    <a href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="btn-getstarted" href="{{ route('home') }}#about">Get Started</a>

        </div>
    </header>

    <main id="main">

        <!-- Page Content Section -->
        <section class="page-content section">

            <!-- Page Title -->
            <div class="page-title">
                <div class="container position-relative" data-aos="fade-up">
                    <h1>{{ $page->title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
                        </ol>
                    </nav>
                </div>
            </div><!-- End Page Title -->

            <div class="container">
                <div class="row" data-aos="fade-up">

                    @if ($page->featured_image)
                        <div class="col-md-6 mb-4 mb-md-0">
                            <img src="{{ asset('storage/' . $page->featured_image) }}" class="img-fluid rounded-4"
                                alt="{{ $page->title }}">
                        </div>
                        <div class="col-md-6">
                        @else
                            <div class="col-12">
                    @endif
                    <div class="page-content-body">
                        {!! $page->content !!}
                    </div>
                </div>

            </div>
            </div>

        </section><!-- End Page Content -->

        <!-- Featured Services Section -->
        <section class="featured-services section">
            <div class="container" data-aos="fade-up">

                <div class="section-title text-center mb-5">
                    <h2>Our Services</h2>
                    <p>Explore our range of professional services</p>
                </div>

                <div class="row">
                    @foreach ($services as $service)
                        <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="service-card h-100">
                                <div class="icon-box">
                                    <i class="bi {{ $service->icon ?? 'bi-check-circle' }}"></i>
                                    <h4>{{ $service->title }}</h4>
                                    <p>{{ $service->short_description }}</p>
                                    <a href="{{ route('service.details', $service->slug) }}" class="read-more">Learn
                                        More <i class="bi bi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section><!-- End Featured Services -->

    </main><!-- End #main -->

    <footer id="footer" class="footer">

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="{{ route('home') }}" class="logo d-flex align-items-center">
                        <span class="sitename">Pikkod</span>
                    </a>
                    <div class="footer-contact pt-3">
                        @php
                            $contactSection = App\Models\ContactSection::first();
                        @endphp
                        @if ($contactSection)
                            <p>{{ $contactSection->address_line1 }}</p>
                            <p>{{ $contactSection->address_line2 }}</p>
                            <p class="mt-3"><strong>Phone:</strong>
                                <span>{{ $contactSection->phone_number1 }}</span>
                            </p>
                            <p><strong>Email:</strong> <span>{{ $contactSection->email1 }}</span></p>
                        @else
                            <p>A108 Adam Street</p>
                            <p>New York, NY 535022</p>
                            <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
                            <p><strong>Email:</strong> <span>info@example.com</span></p>
                        @endif
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href=""><i class="bi bi-twitter-x"></i></a>
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                        <a href=""><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('home') }}#about">About us</a></li>
                        <li><a href="{{ route('home') }}#services">Services</a></li>
                        <li><a href="#">Terms of service</a></li>
                        <li><a href="#">Privacy policy</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Our Services</h4>
                    <ul>
                        @foreach ($footerServices as $footerService)
                            <li><a
                                    href="{{ route('service.details', $footerService->slug) }}">{{ $footerService->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6">
                    <h4>Subscribe to Our Newsletter</h4>
                    <p>Stay updated with our latest news and services</p>
                    <form action="#" method="post" class="footer-newsletter">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Enter your email">
                            <button class="btn btn-primary" type="submit">Subscribe</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">Pikkod</strong> <span>All Rights Reserved</span>
            </p>
        </div>

    </footer><!-- End Footer -->

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets-home') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets-home') }}/vendor/aos/aos.js"></script>
    <script src="{{ asset('assets-home') }}/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="{{ asset('assets-home') }}/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('assets-home') }}/vendor/purecounter/purecounter_vanilla.js"></script>

    <!-- Main JS Files -->
    <script src="{{ asset('assets-home') }}/js/main.js"></script>
    <script src="{{ asset('assets-home') }}/js/pages.js"></script>

</body>

</html>
