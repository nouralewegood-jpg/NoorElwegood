@extends('admin.layouts.master2')
@section('css')
    <!-- Sidemenu-respoansive-tabs css -->
    <link href="{{ URL::asset('assets-admin/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css') }}"
        rel="stylesheet">
    <style>
        .btn-main-primary {
            background-color: #4c6ef8 !important;
            border-color: #4c6ef8 !important;
            color: #fff;
            transition: all 0.3s ease;
        }

        .btn-main-primary:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 110, 248, 0.2);
        }

        .text-primary {
            color: #4c6ef8 !important;
        }

        .bg-primary-transparent {
            background: rgba(76, 110, 248, 0.1) !important;
        }

        .main-logo1 span {
            color: #4c6ef8;
        }

        .main-signup-footer a {
            color: #4c6ef8;
            transition: all 0.2s ease;
        }

        .main-signup-footer a:hover {
            color: #2f4ac7;
            text-decoration: underline;
        }

        .form-control:focus {
            border-color: #4c6ef8;
            box-shadow: 0 0 0 0.2rem rgba(76, 110, 248, 0.25);
        }

        .auth-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
        }

        .main-card-signin {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        .input-group-text {
            background-color: #f4f6fd;
            border-color: #e1e5ef;
            color: #7987a1;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row no-gutter">
            <!-- The image half -->
            <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
                <div class="row wd-100p mx-auto text-center">
                    <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                        <img src="{{ URL::asset('assets-admin/img/media/reset.jpg') }}"
                            class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
                    </div>
                </div>
            </div>
            <!-- The content half -->
            <div class="col-md-6 col-lg-6 col-xl-5 bg-white">
                <div class="login d-flex align-items-center py-2">
                    <!-- Demo content-->
                    <div class="container p-0">
                        <div class="row">
                            <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                                <div class="mb-5 d-flex">
                                    <a href="{{ url('/') }}">
                                        <img src="{{ URL::asset('assets-admin/img/brand/favicon.png') }}"
                                            class="sign-favicon ht-40" alt="logo">
                                    </a>
                                    <h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">Pik<span>kod</span></h1>
                                </div>
                                <div class="main-card-signin d-md-flex bg-white p-4 rounded shadow-sm">
                                    <div class="wd-100p">
                                        <div class="main-signin-header">
                                            <div class="">
                                                <h2 class="auth-title">إعادة تعيين كلمة المرور</h2>
                                                <h5 class="text-muted font-weight-normal mb-4">الرجاء إدخال كلمة المرور
                                                    الجديدة</h5>

                                                @if ($errors->any())
                                                    <div class="alert alert-danger alert-dismissible fade show">
                                                        <ul class="mb-0 list-unstyled">
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                        <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                @endif

                                                <form method="POST" action="{{ route('password.update') }}">
                                                    @csrf
                                                    <input type="hidden" name="token" value="{{ $token }}">
                                                    <div class="form-group">
                                                        <label>البريد الإلكتروني</label>
                                                        <input class="form-control @error('email') is-invalid @enderror"
                                                            name="email" value="{{ $email ?? old('email') }}"
                                                            type="email" required readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>كلمة المرور الجديدة</label>
                                                        <input class="form-control @error('password') is-invalid @enderror"
                                                            name="password" placeholder="أدخل كلمة المرور الجديدة"
                                                            type="password" required>
                                                        <small id="passwordHelpBlock" class="form-text text-muted">
                                                            كلمة المرور يجب أن تكون على الأقل 8 أحرف.
                                                        </small>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>تأكيد كلمة المرور</label>
                                                        <input
                                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                                            name="password_confirmation"
                                                            placeholder="أدخل تأكيد كلمة المرور" type="password" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-main-primary btn-block">إعادة
                                                        تعيين كلمة المرور</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="main-signup-footer mg-t-20 text-center">
                                            <p><a href="{{ route('login') }}">العودة إلى صفحة تسجيل الدخول</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End -->
                </div>
            </div><!-- End -->
        </div>
    </div>
@endsection
@section('js')
@endsection
