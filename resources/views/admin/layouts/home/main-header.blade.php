<!-- Header START -->
<header class="navbar-light navbar-sticky">
    <!-- Logo Nav START -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <!-- Logo START -->
            <a class="navbar-brand me-0" href="{{ route('selection') }}">
                <img class="light-mode-item navbar-brand-item" src="{{ URL::asset('assetsHome/images/logo.svg') }}"
                    alt="logo">
            </a>
            <!-- Logo END -->

            <!-- Responsive navbar toggler -->
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-animation">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>

            <!-- Main navbar START -->
            <div class="navbar-collapse collapse" id="navbarCollapse">

                <!-- Nav Search END -->
                <ul class="navbar-nav navbar-nav-scroll mx-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('selection') }}" id="demoMenu" aria-haspopup="true"
                            aria-expanded="false">الصفحة الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('geo_courses_payment') }}" id="demoMenu"
                            aria-haspopup="true" aria-expanded="false">الكورسات المدفوعة</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('geo_courses_free') }}" id="demoMenu" aria-haspopup="true"
                            aria-expanded="false">الكورسات المجانية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('blog') }}" id="demoMenu" aria-haspopup="true"
                            aria-expanded="false">المدونة</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('smartStudent') }}" id="demoMenu" aria-haspopup="true"
                            aria-expanded="false">اوائل الطلاب</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('login') }}" id="demoMenu" aria-haspopup="true"
                            aria-expanded="false">ابدا الان</a>
                    </li>
                </ul>
            </div>
            <!-- Main navbar END -->

            <div class="navbar-nav  d-lg-inline-block">
                <a href="{{ route('register') }}" class="btn btn-danger-soft mb-0"><i
                        class="fas fa-sign-in-alt me-2"></i>التسجيل في المنصة</a>
            </div>


        </div>
    </nav>
    <!-- Logo Nav END -->
</header>
<!-- Header END -->
