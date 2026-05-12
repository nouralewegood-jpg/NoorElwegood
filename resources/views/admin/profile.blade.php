@extends('admin.layouts.master')
@section('css')
    <!--- Internal Fileuploads css-->
    <link href="{{ URL::asset('assets-admin/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!--- Internal Sweet-Alert css-->
    <link href="{{ URL::asset('assets-admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الإعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    الملف الشخصي</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-lg-4">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="pl-0">
                        <div class="main-profile-overview">
                            <form id="profile-image-form" action="{{ route('admin.profile.update-image') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="main-img-user profile-user">
                                    @if ($user->profile_image)
                                        <img alt="{{ $user->name }}" src="{{ asset('storage/' . $user->profile_image) }}">
                                    @else
                                        <img alt="{{ $user->name }}"
                                            src="{{ URL::asset('assets-admin/img/faces/6.jpg') }}">
                                    @endif
                                    <a class="fas fa-camera profile-edit" href="javascript:void(0);"
                                        id="changeProfileImage"></a>
                                    <input type="file" name="profile_image" id="profile_image" class="d-none">
                                </div>
                            </form>
                            <div class="d-flex justify-content-between mg-b-20">
                                <div>
                                    <h5 class="main-profile-name">{{ $user->name }}</h5>
                                    <p class="main-profile-name-text">{{ $user->email }}</p>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h6 class="card-title mb-3">بيانات الحساب</h6>
                                    <div class="table-responsive">
                                        <table class="table table-borderless mg-b-0">
                                            <tbody>
                                                <tr>
                                                    <td><strong>الاسم:</strong></td>
                                                    <td>{{ $user->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>البريد الإلكتروني:</strong></td>
                                                    <td>{{ $user->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>الصلاحية:</strong></td>
                                                    <td>{{ $user->role }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>تاريخ التسجيل:</strong></td>
                                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="card-title mb-3">تغيير شعار لوحة التحكم</h6>
                        <form id="logo-form" action="{{ route('admin.profile.update-logo') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <div class="border p-3 text-center">
                                        <h6 class="mb-3">الشعار الحالي</h6>
                                        <img src="{{ URL::asset('assets-admin/img/brand/logo.png') }}"
                                            class="img-fluid mb-3" style="max-height: 80px;" alt="Current Logo">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="dashboard_logo" class="form-label mb-2">
                                            اختر شعاراً جديداً
                                            <small class="text-muted">(الأبعاد المفضلة: عرض 200 × ارتفاع 60 بكسل)</small>
                                        </label>
                                        <input type="file" name="dashboard_logo" id="dashboard_logo" class="dropify"
                                            data-height="100" accept="image/*">
                                        <small class="text-muted">يفضل استخدام صورة ذات خلفية شفافة بتنسيق PNG</small>
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary btn-block">تحديث الشعار</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="tabs-menu ">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs profile navtab-custom panel-tabs">
                            <li class="active">
                                <a href="#personal-info" data-toggle="tab" aria-expanded="true">
                                    <span><i class="fas fa-user-circle mr-2"></i>البيانات الشخصية</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="#change-password" data-toggle="tab" aria-expanded="false">
                                    <span><i class="fas fa-lock mr-2"></i>تغيير كلمة المرور</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content border-left border-bottom border-right border-top-0 p-4">
                        <div class="tab-pane active" id="personal-info">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>نجاح!</strong> {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>خطأ!</strong>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <h5 class="mb-4">تحديث البيانات الشخصية</h5>
                            <form action="{{ route('admin.profile.update-info') }}" method="POST"
                                id="update-info-form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">الاسم الكامل</label>
                                            <input type="text" name="name" id="name"
                                                value="{{ old('name', $user->name) }}"
                                                class="form-control @error('name') is-invalid @enderror" required>
                                            @error('name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">البريد الإلكتروني</label>
                                            <input type="email" name="email" id="email"
                                                value="{{ old('email', $user->email) }}"
                                                class="form-control @error('email') is-invalid @enderror" required>
                                            @error('email')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="phone">رقم الهاتف</label>
                                            <input type="text" name="phone" id="phone"
                                                value="{{ old('phone', $user->phone) }}"
                                                class="form-control @error('phone') is-invalid @enderror">
                                            @error('phone')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="bio">نبذة مختصرة</label>
                                            <textarea name="bio" id="bio" rows="4" class="form-control @error('bio') is-invalid @enderror">{{ old('bio', $user->bio) }}</textarea>
                                            @error('bio')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="fas fa-check-circle mr-2"></i>حفظ التغييرات
                                </button>
                            </form>
                        </div>

                        <div class="tab-pane" id="change-password">
                            <h5 class="mb-4">تغيير كلمة المرور</h5>
                            <form action="{{ route('admin.profile.update-password') }}" method="POST"
                                id="change-password-form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="current_password">كلمة المرور الحالية</label>
                                            <input type="password" name="current_password" id="current_password"
                                                class="form-control @error('current_password') is-invalid @enderror"
                                                required>
                                            @error('current_password')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">كلمة المرور الجديدة</label>
                                            <input type="password" name="password" id="password"
                                                class="form-control @error('password') is-invalid @enderror" required>
                                            @error('password')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation">تأكيد كلمة المرور الجديدة</label>
                                            <input type="password" name="password_confirmation"
                                                id="password_confirmation" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 mb-3">
                                    <div class="alert alert-info">
                                        <h6 class="mb-2"><i class="fas fa-info-circle mr-2"></i>متطلبات كلمة المرور:
                                        </h6>
                                        <ul class="mb-0 pr-3">
                                            <li>يجب أن تتكون كلمة المرور من 8 أحرف على الأقل</li>
                                            <li>يجب أن تحتوي على حرف كبير واحد على الأقل</li>
                                            <li>يجب أن تحتوي على حرف صغير واحد على الأقل</li>
                                            <li>يجب أن تحتوي على رقم واحد على الأقل</li>
                                            <li>يجب أن تحتوي على رمز خاص واحد على الأقل (@$!%*#?&)</li>
                                        </ul>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-lock mr-2"></i>تغيير كلمة المرور
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets-admin/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Sweet-Alert js-->
    <script src="{{ URL::asset('assets-admin/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/sweet-alert/jquery.sweet-alert.js') }}"></script>

    <script>
        $(document).ready(function() {
            // تحميل الصورة الشخصية عند تغييرها
            $('#changeProfileImage').on('click', function() {
                $('#profile_image').click();
            });

            $('#profile_image').on('change', function() {
                if (this.files && this.files[0]) {
                    // طريقة بديلة لا تستخدم تأكيد SweetAlert
                    $('#profile-image-form').submit();

                    // إظهار رسالة انتظار
                    swal({
                        title: "جاري رفع الصورة",
                        text: "يرجى الانتظار...",
                        type: "info",
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                }
            });

            // إظهار مؤشر التحميل أثناء حفظ البيانات الشخصية
            $('#update-info-form').on('submit', function() {
                swal({
                    title: "جاري حفظ البيانات",
                    text: "يرجى الانتظار...",
                    type: "info",
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
            });

            // تأكيد تغيير كلمة المرور
            $('#change-password-form').on('submit', function(e) {
                e.preventDefault();

                // التحقق من تطابق كلمتي المرور
                if ($('#password').val() !== $('#password_confirmation').val()) {
                    swal("خطأ!", "كلمة المرور الجديدة وتأكيدها غير متطابقين", "error");
                    return false;
                }

                // استخدام نمط قديم من SweetAlert للتوافق
                swal({
                    title: "تأكيد تغيير كلمة المرور",
                    text: "هل أنت متأكد من رغبتك في تغيير كلمة المرور؟",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "نعم، قم بالتغيير!",
                    cancelButtonText: "إلغاء"
                }, function(isConfirm) {
                    if (isConfirm) {
                        $('#change-password-form')[0].submit();
                    }
                });

                return false;
            });

            // تهيئة حقل تحميل الشعار
            $('.dropify').dropify({
                messages: {
                    'default': 'اسحب واسقط الملف هنا أو انقر للاختيار',
                    'replace': 'اسحب واسقط أو انقر للاستبدال',
                    'remove': 'حذف',
                    'error': 'عفواً، حدث خطأ ما'
                },
                error: {
                    'fileSize': 'حجم الملف كبير جداً (@{{ value }} max).',
                    'minWidth': 'عرض الصورة صغير جداً (@{{ value }}px min).',
                    'maxWidth': 'عرض الصورة كبير جداً (@{{ value }}px max).',
                    'minHeight': 'ارتفاع الصورة صغير جداً (@{{ value }}px min).',
                    'maxHeight': 'ارتفاع الصورة كبير جداً (@{{ value }}px max).',
                    'imageFormat': 'تنسيق الصورة غير مدعوم (@{{ value }} فقط).'
                }
            });
        });
    </script>
@endsection
