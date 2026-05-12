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

        .main-signin-footer a {
            color: #4c6ef8;
            transition: all 0.2s ease;
        }

        .main-signin-footer a:hover {
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
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row no-gutter">
            <!-- The image half -->
            <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
                <div class="row wd-100p mx-auto text-center">
                    <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                        <img src="{{ URL::asset('assets-admin/img/media/login.png') }}"
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
                                            <h2 class="auth-title">تأكيد كلمة المرور</h2>
                                            <h5 class="text-muted font-weight-normal mb-4">الرجاء تأكيد كلمة المرور قبل
                                                المتابعة</h5>

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

                                            <form method="POST" action="{{ route('password.confirm') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label>كلمة المرور</label>
                                                    <input id="password" type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password" required autocomplete="current-password"
                                                        placeholder="الرجاء إدخال كلمة المرور">
                                                </div>
                                                <button type="submit" class="btn btn-main-primary btn-block">تأكيد كلمة
                                                    المرور</button>
                                            </form>
                                        </div>
                                        <div class="main-signin-footer mg-t-20 text-center">
                                            @if (Route::has('password.request'))
                                                <p><a href="{{ route('password.request') }}">هل نسيت كلمة المرور؟</a></p>
                                            @endif
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
