<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href="{{ route('home') }}"><img
                src="{{ URL::asset('assets-admin/img/brand/logo.png') }}" class="main-logo" alt="logo"></a>
        <a class="desktop-logo logo-dark active" href="{{ route('home') }}"><img
                src="{{ URL::asset('assets-admin/img/brand/logo-white.png') }}" class="main-logo dark-theme"
                alt="logo"></a>
        <a class="logo-icon mobile-logo icon-light active" href="{{ route('home') }}"><img
                src="{{ URL::asset('assets-admin/img/brand/favicon.png') }}" class="logo-icon" alt="logo"></a>
        <a class="logo-icon mobile-logo icon-dark active" href="{{ route('home') }}"><img
                src="{{ URL::asset('assets-admin/img/brand/favicon-white.png') }}" class="logo-icon dark-theme"
                alt="logo"></a>
    </div>
    <div class="main-sidemenu">
        <div class="app-sidebar__user clearfix">
            <div class="dropdown user-pro-body">
                <div class="">
                    @if (Auth::user()->profile_image)
                        <img alt="user-img" class="avatar avatar-xl brround"
                            src="{{ asset('storage/' . Auth::user()->profile_image) }}">
                    @else
                        <img alt="user-img" class="avatar avatar-xl brround"
                            src="{{ URL::asset('assets-admin/img/faces/6.jpg') }}">
                    @endif
                    <span class="avatar-status profile-status bg-green"></span>
                </div>
                <div class="user-info">
                    <h4 class="font-weight-semibold mt-3 mb-0">{{ Auth::user()->name }}</h4>
                    <span class="mb-0 text-muted">{{ Auth::user()->role }}</span>
                </div>
            </div>
        </div>
        <ul class="side-menu">
            <li class="side-item side-item-category">القائمة الرئيسية</li>

            <!-- لوحة التحكم -->
            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.dashboard') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
                        <path
                            d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
                    </svg>
                    <span class="side-menu__label">لوحة التحكم</span>
                </a>
            </li>

            <!-- إدارة المحتوى -->
            <li class="side-item side-item-category">إدارة المحتوى</li>

            <!-- إدارة المدونة -->
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" opacity=".3" />
                        <path
                            d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z" />
                    </svg>
                    <span class="side-menu__label">المدونة</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li><a class="slide-item" href="{{ route('admin.blog.posts.index') }}">المقالات</a></li>
                    <li><a class="slide-item" href="{{ route('admin.blog.categories.index') }}">التصنيفات</a></li>
                    <li><a class="slide-item" href="{{ route('admin.blog.tags.index') }}">الوسوم</a></li>
                </ul>
            </li>

            <!-- إدارة معرض الأعمال -->
            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.portfolio.index') }}">
                    <i class="fas fa-images side-menu__icon"></i>
                    <span class="side-menu__label">معرض الأعمال</span>
                </a>
            </li>

            <!-- إدارة الصفحات -->
            {{-- <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.pages.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path d="M13 4H6v16h12V9h-5V4zm3 14H8v-2h8v2zm0-6v2H8v-2h8z" opacity=".3" />
                        <path
                            d="M8 16h8v2H8zm0-4h8v2H8zm6-10H6c-1.1 0-2 .9-2 2v16c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z" />
                    </svg>
                    <span class="side-menu__label">الصفحات</span>
                </a>
            </li> --}}

            <!-- إدارة سياسة الخصوصية -->
            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.privacy-policy.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zM6 20V4h7v5h5v11H6z"
                            opacity=".3" />
                        <path
                            d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z" />
                        <path
                            d="M10.3 14.29a1 1 0 00-1.41 1.42l3 3a1 1 0 001.41 0l6-6a1 1 0 10-1.41-1.42L13 16.17l-2.7-1.88z" />
                    </svg>
                    <span class="side-menu__label">سياسة الخصوصية</span>
                </a>
            </li>

            <!-- إدارة شروط الخدمة -->
            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.terms-of-service.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" opacity=".3" />
                        <path
                            d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z" />
                    </svg>
                    <span class="side-menu__label">شروط الخدمة</span>
                </a>
            </li>

            <!-- إدارة الصفحة الرئيسية -->
            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.home-section.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                        <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
                    </svg>
                    <span class="side-menu__label">الصفحة الرئيسية</span>
                </a>
            </li>

            <!-- إدارة قسم من نحن -->
            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.about-section.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M12 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 10c-2.7 0-5.8 1.29-6 2h12c-.2-.71-3.3-2-6-2z"
                            opacity=".3" />
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" />
                    </svg>
                    <span class="side-menu__label">قسم من نحن</span>
                </a>
            </li>

            <!-- إدارة قسم المميزات -->
            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.feature-section.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M9.5 5.5c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zM5.75 8.9L3 23h2.1l1.75-8L9 17v6h2v-7.55L8.95 13.4l.6-3C10.85 12 12.8 13 15 13v-2c-1.85 0-3.45-1-4.35-2.45l-.95-1.6C9.35 6.35 8.7 6 8 6c-.25 0-.5.05-.75.15L2 8.3V13h2V9.65l1.75-.75"
                            opacity=".3" />
                        <path
                            d="M9 17v6h2v-7.55L8.95 13.4l.6-3C10.85 12 12.8 13 15 13v-2c-1.85 0-3.45-1-4.35-2.45l-.95-1.6C9.35 6.35 8.7 6 8 6c-.25 0-.5.05-.75.15L2 8.3V13h2V9.65l1.75-.75L3 23h2.1l1.75-8L9 17zM17.5 10c.83 0 1.5-.67 1.5-1.5S18.33 7 17.5 7 16 7.67 16 8.5s.67 1.5 1.5 1.5zm2.5 6h-5v-1.5c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5V18h-1v-7h1v3.5h5.5V11H22v7h-2v-2z" />
                    </svg>
                    <span class="side-menu__label">قسم المميزات</span>
                </a>
            </li>

            <!-- إدارة قسم الخدمات -->
            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.service-section.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M5 9h14V5H5v4zm2-3.5c.83 0 1.5.67 1.5 1.5S7.83 8.5 7 8.5 5.5 7.83 5.5 7 6.17 5.5 7 5.5zM5 19h14v-4H5v4zm2-3.5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5.67-1.5 1.5-1.5z"
                            opacity=".3" />
                        <path
                            d="M20 13H4c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1h16c.55 0 1-.45 1-1v-6c0-.55-.45-1-1-1zm-1 6H5v-4h14v4zm-12-.5c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5-1.5.67-1.5 1.5.67 1.5 1.5 1.5zM20 3H4c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1h16c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1zm-1 6H5V5h14v4zM7 8.5c.83 0 1.5-.67 1.5-1.5S7.83 5.5 7 5.5 5.5 6.17 5.5 7 6.17 8.5 7 8.5z" />
                    </svg>
                    <span class="side-menu__label">قسم الخدمات</span>
                </a>
            </li>

            <!-- إدارة قسم التسعير -->
            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.pricing-section.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M12 4c-4.41 0-8 3.59-8 8s3.59 8 8 8 8-3.59 8-8-3.59-8-8-8zm1 14h-2v-2h2v2zm0-3h-2c0-3.25 3-3 3-5 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 2.5-3 2.75-3 5z"
                            opacity=".3" />
                        <path
                            d="M11 16h2v2h-2zm1-14C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8-3.59 8-8-3.59-8-8-8zm0-14c-2.21 0-4 1.79-4 4h2c0-1.1.9-2 2-2s2 .9 2 2c0 2-3 1.75-3 5h2c0-2.25 3-2.5 3-5 0-2.21-1.79-4-4-4z" />
                    </svg>
                    <span class="side-menu__label">قسم التسعير</span>
                </a>
            </li>

            <!-- إدارة قسم الاتصال -->
            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.contact-section.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path d="M20 8l-8 5-8-5v10h16zm0-2H4l8 4.99z" opacity=".3" />
                        <path
                            d="M4 20h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2zM20 6l-8 4.99L4 6h16zM4 8l8 5 8-5v10H4V8z" />
                    </svg>
                    <span class="side-menu__label">قسم الاتصال</span>
                </a>
            </li>

            <!-- إدارة الرسائل -->
            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.messages.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path d="M4 17.17L5.17 16H20V4H4v13.17zM11 6h2v4h-2V6zm0 6h2v2h-2v-2z" opacity=".3" />
                        <path
                            d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H5.17L4 17.17V4h16v12zm-9-4h2v2h-2zm0-6h2v4h-2z" />
                    </svg>
                    <span class="side-menu__label">الرسائل</span>
                </a>
            </li>

            <!-- إدارة طلبات الخطط -->
            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.plan-requests.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path d="M19 5H5v14h14V5zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" opacity=".3" />
                        <path
                            d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm2 0h14v14H5V5zm2 5h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z" />
                    </svg>
                    <span class="side-menu__label">طلبات الخطط</span>
                    @php
                        $newRequestsCount = App\Models\PlanRequest::where('status', 'new')->count();
                    @endphp
                    @if ($newRequestsCount > 0)
                        <span class="badge badge-danger">{{ $newRequestsCount }}</span>
                    @endif
                </a>
            </li>

            <!-- إدارة آراء العملاء -->
            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.testimonials.index') }}">
                    <i class="fa fa-quote-left side-menu__icon"></i>
                    <span class="side-menu__label">آراء العملاء</span>
                </a>
            </li>

            <!-- الأدوات المساعدة -->
            <li class="side-item side-item-category">الأدوات المساعدة</li>

            <!-- تحليلات الزيارات -->
            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.analytics') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path d="M5 5v14h14V5H5zm4 12H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" opacity=".3" />
                        <path
                            d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z" />
                    </svg>
                    <span class="side-menu__label">تحليلات الزيارات</span>
                </a>
            </li>

            <!-- مكتبة الأيقونات -->
            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.icons.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M12 4c-4.41 0-8 3.59-8 8s3.59 8 8 8 8-3.59 8-8-3.59-8-8-8zm2.01 10.01L6.5 17.5l3.49-7.51L17.5 6.5l-3.49 7.51z"
                            opacity=".3" />
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8-3.59 8-8-3.59-8-8-8zm-1.06-6.41L9.45 11.5l-2.95 6.49L12 14.5l2.95 6.49-2.95-6.49L9.67 16.4l1.27-2.39z" />
                    </svg>
                    <span class="side-menu__label">مكتبة الأيقونات</span>
                </a>
            </li>

            <!-- Chatbot Settings -->
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-robot side-menu__icon"></i>
                    <span class="side-menu__label">إدارة الشات بوت</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li><a class="slide-item" href="{{ route('admin.chatbot-settings.index') }}">الأسئلة
                            والإجابات</a></li>
                    <li><a class="slide-item" href="{{ route('admin.chatbot-synonyms.index') }}">المرادفات</a></li>
                    <li><a class="slide-item" href="{{ route('admin.chatbot-questions.index') }}">الأسئلة الجديدة
                            @php
                                $pendingCount = \App\Models\ChatbotUnansweredQuestion::where(
                                    'status',
                                    'pending',
                                )->count();
                            @endphp
                            @if ($pendingCount > 0)
                                <span class="badge badge-danger">{{ $pendingCount }}</span>
                            @endif
                        </a></li>
                </ul>
            </li>

            <!-- الإعدادات -->
            <li class="side-item side-item-category">الإعدادات</li>

            <!-- الملف الشخصي -->
            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.profile') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M12 4c-4.42 0-8 3.58-8 8s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm3.5 4c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5.67-1.5 1.5-1.5zm-7 0c.83 0 1.5.67 1.5 1.5S9.33 11 8.5 11 7 10.33 7 9.5 7.67 8 8.5 8zm3.5 9.5c-2.33 0-4.32-1.45-5.12-3.5h1.67c.7 1.19 1.97 2 3.45 2s2.76-.81 3.45-2h1.67c-.8 2.05-2.79 3.5-5.12 3.5z"
                            opacity=".3" />
                        <circle cx="15.5" cy="9.5" r="1.5" />
                        <circle cx="8.5" cy="9.5" r="1.5" />
                        <path
                            d="M12 16c-1.48 0-2.75-.81-3.45-2H6.88c.8 2.05 2.79 3.5 5.12 3.5s4.32-1.45 5.12-3.5h-1.67c-.69 1.19-1.97 2-3.45 2zm-.01-14C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8-3.58 8-8-3.58-8-8-8z" />
                    </svg>
                    <span class="side-menu__label">الملف الشخصي</span>
                </a>
            </li>

            <!-- تسجيل الخروج -->
            <li class="slide">
                <a class="side-menu__item" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M10.09 15.59L11.5 17l5-5-5-5-1.41 1.41L12.67 11H3v2h9.67l-2.58 2.59zM19 3H5c-1.11 0-2 .9-2 2v4h2V5h14v14H5v-4H3v4c0 1.1.89 2 1.99 2H19c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z" />
                    </svg>
                    <span class="side-menu__label">تسجيل الخروج</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</aside>
<!-- main-sidebar -->
