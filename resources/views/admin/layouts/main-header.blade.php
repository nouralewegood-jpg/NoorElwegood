<!-- main-header opened -->
<div class="main-header sticky side-header nav nav-item">
    <div class="container-fluid">
        <div class="main-header-left ">
            <div class="responsive-logo">
                <a href="{{ url('/' . ($page = 'index')) }}"><img
                        src="{{ URL::asset('assets-admin/img/brand/logo.png') }}" class="logo-1" alt="logo"></a>
                <a href="{{ url('/' . ($page = 'index')) }}"><img
                        src="{{ URL::asset('assets-admin/img/brand/logo-white.png') }}" class="dark-logo-1"
                        alt="logo"></a>
                <a href="{{ url('/' . ($page = 'index')) }}"><img
                        src="{{ URL::asset('assets-admin/img/brand/favicon.png') }}" class="logo-2" alt="logo"></a>
                <a href="{{ url('/' . ($page = 'index')) }}"><img
                        src="{{ URL::asset('assets-admin/img/brand/favicon.png') }}" class="dark-logo-2"
                        alt="logo"></a>
            </div>
            <div class="app-sidebar__toggle" data-toggle="sidebar">
                <a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
                <a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
            </div>
            <div class="main-header-center mr-3 d-sm-none d-md-none d-lg-block">
                <input class="form-control" placeholder="Search for anything..." type="search"> <button
                    class="btn"><i class="fas fa-search d-none d-md-block"></i></button>
            </div>
        </div>
        <div class="main-header-right">
            <ul class="nav">
                <!-- تم حذف قائمة اختيار اللغة من هنا -->
            </ul>
            <div class="nav nav-item  navbar-nav-right ml-auto">
                <div class="nav-link" id="bs-example-navbar-collapse-1">
                    <form class="navbar-form" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search">
                            <span class="input-group-btn">
                                <button type="reset" class="btn btn-default">
                                    <i class="fas fa-times"></i>
                                </button>
                                <button type="submit" class="btn btn-default nav-link resp-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-search">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="dropdown nav-item main-header-message">
                    @php
                        $newMessages = App\Models\Message::where('is_read', 0)->latest()->take(5)->get();
                        $unreadCount = $newMessages->count();
                    @endphp
                    <a class="new nav-link" href="#" id="messages-dropdown">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-mail">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                            </path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        @if ($unreadCount > 0)
                            <span class="pulse-danger"></span>
                        @endif
                    </a>
                    <div class="dropdown-menu">
                        <div class="menu-header-content bg-primary text-right">
                            <div class="d-flex">
                                <h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">الرسائل</h6>
                                <span class="badge badge-pill badge-warning mr-auto my-auto float-left"
                                    id="mark-messages-read">
                                    تمييز الكل كمقروء
                                </span>
                            </div>
                            <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12">
                                لديك {{ $unreadCount }} رسائل غير مقروءة
                            </p>
                        </div>
                        <div class="main-message-list chat-scroll">
                            @forelse($newMessages as $message)
                                <a href="{{ route('admin.messages.show', $message->id) }}"
                                    class="p-3 d-flex border-bottom">
                                    <div class="drop-img cover-image bg-primary rounded-circle">
                                        <span class="avatar-status bg-teal"></span>
                                        <span class="text-white font-weight-bold"
                                            style="position: relative; top: 7px; right: 10px;">
                                            {{ substr($message->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div class="wd-90p">
                                        <div class="d-flex">
                                            <h5 class="mb-1 name">{{ $message->name }}</h5>
                                        </div>
                                        <p class="mb-0 desc">{{ \Str::limit($message->message, 50) }}</p>
                                        <p class="time mb-0 text-left float-right mr-2 mt-2">
                                            {{ $message->created_at->diffForHumans() }}</p>
                                    </div>
                                </a>
                            @empty
                                <div class="p-3 text-center">
                                    لا توجد رسائل جديدة
                                </div>
                            @endforelse
                        </div>
                        <div class="text-center dropdown-footer">
                            <a href="{{ route('admin.messages.index') }}">عرض الكل</a>
                        </div>
                    </div>
                </div>
                <div class="dropdown nav-item main-header-notification">
                    @php
                        $newPlanRequests = App\Models\PlanRequest::where('status', 'new')->latest()->take(5)->get();
                        $newChatbotQuestions = App\Models\ChatbotUnansweredQuestion::where('status', 'pending')
                            ->latest()
                            ->take(3)
                            ->get();
                        $totalNotifications = $newPlanRequests->count() + $newChatbotQuestions->count();
                    @endphp
                    <a class="new nav-link" href="#" id="notifications-dropdown">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-bell">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        @if ($totalNotifications > 0)
                            <span class="pulse"></span>
                        @endif
                    </a>
                    <div class="dropdown-menu">
                        <div class="menu-header-content bg-primary text-right">
                            <div class="d-flex">
                                <h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">الإشعارات</h6>
                                <span class="badge badge-pill badge-warning mr-auto my-auto float-left"
                                    id="mark-all-read">
                                    تمييز الكل كمقروء
                                </span>
                            </div>
                            <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12">
                                لديك {{ $totalNotifications }} إشعارات غير مقروءة
                            </p>
                        </div>
                        <div class="main-notification-list Notification-scroll">
                            @forelse($newPlanRequests as $planRequest)
                                <a class="d-flex p-3 border-bottom"
                                    href="{{ route('admin.plan-requests.show', $planRequest->id) }}">
                                    <div class="notifyimg bg-success"
                                        style="border-radius: 50% !important; overflow: hidden;">
                                        <i class="la la-shopping-cart text-white"></i>
                                    </div>
                                    <div class="mr-3">
                                        <h5 class="notification-label mb-1">طلب خطة جديد</h5>
                                        <div class="notification-subtext">{{ $planRequest->name }} -
                                            {{ $planRequest->plan ? $planRequest->plan->name : 'خطة غير محددة' }}</div>
                                        <div class="notification-subtext">
                                            {{ $planRequest->created_at->diffForHumans() }}</div>
                                    </div>
                                    <div class="mr-auto">
                                        <i class="las la-angle-left text-left text-muted"></i>
                                    </div>
                                </a>
                            @empty
                                @if ($totalNotifications == 0)
                                    <div class="p-3 text-center">
                                        لا توجد إشعارات جديدة
                                    </div>
                                @endif
                            @endforelse

                            @foreach ($newChatbotQuestions as $question)
                                <a class="d-flex p-3 border-bottom"
                                    href="{{ route('admin.chatbot-questions.index') }}">
                                    <div class="notifyimg bg-warning">
                                        <i class="la la-question-circle text-white"></i>
                                    </div>
                                    <div class="mr-3">
                                        <h5 class="notification-label mb-1">سؤال جديد للشات بوت</h5>
                                        <div class="notification-subtext">{{ \Str::limit($question->question, 30) }}
                                        </div>
                                        <div class="notification-subtext">{{ $question->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    <div class="mr-auto">
                                        <i class="las la-angle-left text-left text-muted"></i>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="dropdown-footer">
                            <a href="{{ route('admin.notifications') }}">عرض الكل</a>
                        </div>
                    </div>
                </div>
                <div class="nav-item full-screen fullscreen-button">
                    <a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg"
                            class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-maximize">
                            <path
                                d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3">
                            </path>
                        </svg></a>
                </div>
                <div class="dropdown main-profile-menu nav nav-item nav-link">
                    <a class="profile-user d-flex" href="">
                        @if (Auth::user()->profile_image)
                            <img alt="" src="{{ asset('storage/' . Auth::user()->profile_image) }}">
                        @else
                            <img alt="" src="{{ URL::asset('assets-admin/img/faces/6.jpg') }}">
                        @endif
                    </a>
                    <div class="dropdown-menu">
                        <div class="main-header-profile bg-primary p-3">
                            <div class="d-flex wd-100p">
                                <div class="main-img-user">
                                    @if (Auth::user()->profile_image)
                                        <img alt=""
                                            src="{{ asset('storage/' . Auth::user()->profile_image) }}"
                                            class="">
                                    @else
                                        <img alt="" src="{{ URL::asset('assets-admin/img/faces/6.jpg') }}"
                                            class="">
                                    @endif
                                </div>
                                <div class="mr-3 my-auto">
                                    <h6>{{ Auth::user()->name ?? 'Guest User' }}</h6>
                                    <span>{{ Auth::user()->role ?? 'User' }}</span>
                                </div>
                            </div>
                        </div>
                        <a class="dropdown-item" href="{{ route('admin.profile') }}"><i
                                class="bx bx-user-circle"></i>الملف الشخصي</a>
                        <a class="dropdown-item" href=""><i class="bx bx-cog"></i> تعديل الملف الشخصي</a>
                        <a class="dropdown-item" href=""><i class="bx bxs-inbox"></i>البريد الوارد</a>
                        <a class="dropdown-item" href=""><i class="bx bx-envelope"></i>الرسائل</a>
                        <a class="dropdown-item" href=""><i class="bx bx-slider-alt"></i> إعدادات الحساب</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bx bx-log-out"></i> تسجيل الخروج
                            </button>
                        </form>
                    </div>
                </div>
                <div class="dropdown main-header-message right-toggle">
                    <a class="nav-link pr-0" data-toggle="sidebar-left" data-target=".sidebar-left">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-menu">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /main-header -->
