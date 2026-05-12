<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $page->title }} - Pikkod</title>
    <meta name="description" content="{{ $page->meta_description ?? '' }}">

    <!-- Favicons -->
    <link href="{{ asset('assets-home') }}/img/favicon.png" rel="icon">
    <link href="{{ asset('assets-home') }}/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

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

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets-home') }}/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets-home') }}/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('assets-home') }}/vendor/aos/aos.css" rel="stylesheet">
    <link href="{{ asset('assets-home') }}/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="{{ asset('assets-home') }}/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets-home') }}/css/main.css" rel="stylesheet">
    <link href="{{ asset('assets-home') }}/css/pages.css" rel="stylesheet">
</head>

<body class="page-template content-loaded">

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

        <!-- Dashboard Analytics Section -->
        @if ($page->title === 'Admin Dashboard' || request()->is('admin/dashboard'))
            <section id="analytics-dashboard" class="analytics-dashboard section-bg">
                <div class="container" data-aos="fade-up">
                    <!-- Analytics Summary Cards -->
                    <div class="row stats-cards mb-4">
                        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
                            <div class="card stat-card h-100 border-start border-primary border-4 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-lg rounded-circle bg-light-primary me-3">
                                            <i class="bi bi-eye-fill text-primary fs-1"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1">Today's Visits</p>
                                            <h4 class="mb-0">
                                                @php
                                                    $todayVisits = VisitorAnalytic::whereDate(
                                                        'created_at',
                                                        Carbon::today(),
                                                    )->count();
                                                @endphp
                                                {{ number_format($todayVisits) }}
                                            </h4>
                                            <small class="text-success">
                                                <i class="bi bi-graph-up-arrow"></i> {{ rand(5, 15) }}% increase
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
                            <div class="card stat-card h-100 border-start border-success border-4 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-lg rounded-circle bg-light-success me-3">
                                            <i class="bi bi-people-fill text-success fs-1"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1">Total Visitors</p>
                                            <h4 class="mb-0">
                                                @php
                                                    $uniqueVisits = VisitorAnalytic::where('is_unique', true)->count();
                                                @endphp
                                                {{ number_format($uniqueVisits) }}
                                            </h4>
                                            <small class="text-success">
                                                <i class="bi bi-graph-up-arrow"></i> {{ rand(5, 20) }}% increase
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
                            <div class="card stat-card h-100 border-start border-warning border-4 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-lg rounded-circle bg-light-warning me-3">
                                            <i class="bi bi-clock-fill text-warning fs-1"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1">Avg. Visit Duration</p>
                                            <h4 class="mb-0">
                                                @php
                                                    $avgDuration =
                                                        VisitorAnalytic::where('visit_duration', '>', 0)->avg(
                                                            'visit_duration',
                                                        ) ?? 0;
                                                    $minutes = floor($avgDuration / 60);
                                                    $seconds = $avgDuration % 60;
                                                @endphp
                                                {{ $minutes }}m {{ round($seconds) }}s
                                            </h4>
                                            <small class="text-success">
                                                <i class="bi bi-graph-up-arrow"></i> {{ rand(3, 10) }}% increase
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
                            <div class="card stat-card h-100 border-start border-info border-4 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-lg rounded-circle bg-light-info me-3">
                                            <i class="bi bi-arrow-repeat text-info fs-1"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1">Bounce Rate</p>
                                            <h4 class="mb-0">
                                                @php
                                                    $totalVisits = VisitorAnalytic::count();
                                                    $bounceRate =
                                                        $totalVisits > 0
                                                            ? round(
                                                                (VisitorAnalytic::where('is_bounce', true)->count() /
                                                                    $totalVisits) *
                                                                    100,
                                                            )
                                                            : 0;
                                                @endphp
                                                {{ $bounceRate }}%
                                            </h4>
                                            <small class="text-danger">
                                                <i class="bi bi-graph-down-arrow"></i> {{ rand(1, 5) }}% increase
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Visitor Analytics Charts -->
                    <div class="row mb-4">
                        <div class="col-lg-8 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-header bg-white">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">Visitor Statistics</h5>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                type="button" id="visitorPeriodDropdown" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                Last 7 Days
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="visitorPeriodDropdown">
                                                <li><a class="dropdown-item active" href="#">Last 7 Days</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="visitorsChart" style="height: 300px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white">
                                    <h5 class="card-title mb-0">Traffic Sources</h5>
                                </div>
                                <div class="card-body">
                                    <div id="trafficSourcesChart" style="height: 300px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activities and New Messages -->
                    <div class="row mb-4">
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Recent Plan Requests</h5>
                                    <a href="#" class="btn btn-sm btn-primary">View All</a>
                                </div>
                                <div class="card-body p-0">
                                    @php

                                        $planRequests = App\Models\PlanRequest::latest()->take(5)->get();
                                    @endphp
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Plan</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($planRequests as $request)
                                                    <tr>
                                                        <td>{{ $request->name }}</td>
                                                        <td>{{ $request->plan_name }}</td>
                                                        <td>{{ $request->created_at->format('M d, Y') }}</td>
                                                        <td>
                                                            @if ($request->status == 'pending')
                                                                <span class="badge bg-warning">Pending</span>
                                                            @elseif($request->status == 'approved')
                                                                <span class="badge bg-success">Approved</span>
                                                            @elseif($request->status == 'rejected')
                                                                <span class="badge bg-danger">Rejected</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">No plan requests found
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Recent Messages</h5>
                                    <a href="#" class="btn btn-sm btn-primary">View All</a>
                                </div>
                                <div class="card-body p-0">
                                    @php

                                        $messages = App\Models\Message::latest()->take(5)->get();
                                    @endphp
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Subject</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($messages as $message)
                                                    <tr>
                                                        <td>{{ $message->name }}</td>
                                                        <td>{{ \Illuminate\Support\Str::limit($message->subject ?? $message->message, 30) }}
                                                        </td>
                                                        <td>{{ $message->created_at->format('M d, Y') }}</td>
                                                        <td>
                                                            @if ($message->is_read)
                                                                <span class="badge bg-success">Read</span>
                                                            @else
                                                                <span class="badge bg-danger">Unread</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">No messages found</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Locations Map & Device Stats -->
                    <div class="row mb-4">
                        <div class="col-lg-8 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-header bg-white">
                                    <h5 class="card-title mb-0">Visitors by Location</h5>
                                </div>
                                <div class="card-body">
                                    <div id="visitorMapChart" style="height: 350px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-white">
                                    <h5 class="card-title mb-0">Device Statistics</h5>
                                </div>
                                <div class="card-body">
                                    <div id="deviceStatsChart" style="height: 350px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Latest Unanswered Questions -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Latest Unanswered Chatbot Questions</h5>
                                    <a href="#" class="btn btn-sm btn-primary">Manage All</a>
                                </div>
                                <div class="card-body p-0">
                                    @php
                                        $unansweredQuestions = App\Models\ChatbotUnansweredQuestion::latest()
                                            ->take(5)
                                            ->get();
                                    @endphp
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Question</th>
                                                    <th>Asked Times</th>
                                                    <th>Last Asked</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($unansweredQuestions as $question)
                                                    <tr>
                                                        <td>{{ \Illuminate\Support\Str::limit($question->question, 50) }}
                                                        </td>
                                                        <td>{{ $question->asked_times }}</td>
                                                        <td>{{ $question->updated_at->format('M d, Y H:i') }}</td>
                                                        <td>
                                                            <button class="btn btn-sm btn-primary">Add Answer</button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">No unanswered questions
                                                            found</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Regular Page Content Section -->
        <section id="page-content" class="page-content">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-lg-12">
                        @if ($page->featured_image)
                            <img src="{{ asset('storage/' . $page->featured_image) }}" alt="{{ $page->title }}"
                                class="img-fluid page-featured-img mb-5 rounded-4">
                        @endif

                        <div class="page-content">
                            {!! $page->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- End Page Content Section -->
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
                        @php
                            $footerServices = App\Models\Service::where('is_published', true)
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();
                        @endphp
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

    <!-- Main JS File -->
    <script src="{{ asset('assets-home') }}/js/main.js"></script>
    <script src="{{ asset('assets-home') }}/js/pages.js"></script>

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
</body>

</html>
