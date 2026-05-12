@extends('admin.layouts.master')

@section('title', 'إعدادات الشات بوت')

@section('css')
    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets-admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--- Internal Sweet-Alert css-->
    <link href="{{ URL::asset('assets-admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    <!-- Spectrum Colorpicker css -->
    <link href="{{ URL::asset('assets-admin/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
    <!--- Internal Fileupload css-->
    <link href="{{ URL::asset('assets-admin/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!--- Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets-admin/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الشات بوت</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الإعدادات</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.chatbot.settings.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="main-content-label mg-b-5">
                            إعدادات الشات بوت
                        </div>
                        <p class="mg-b-20">قم بضبط إعدادات الشات بوت الذي سيظهر في الموقع</p>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <span>{{ session('success') }}</span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="pd-30 pd-sm-40 bg-gray-200 rounded-lg">
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-4">
                                    <label class="form-label mg-b-0">تفعيل الشات بوت</label>
                                </div>
                                <div class="col-md-8 mg-t-5 mg-md-t-0">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
                                            value="1" {{ $settings->is_active ?? false ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">مفعّل</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-4">
                                    <label class="form-label mg-b-0">عنوان الشات بوت</label>
                                </div>
                                <div class="col-md-8 mg-t-5 mg-md-t-0">
                                    <input class="form-control" placeholder="عنوان الشات بوت" type="text" name="title"
                                        value="{{ $settings->title ?? 'شات المساعدة' }}">
                                </div>
                            </div>

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-4">
                                    <label class="form-label mg-b-0">رسالة الترحيب</label>
                                </div>
                                <div class="col-md-8 mg-t-5 mg-md-t-0">
                                    <input class="form-control" placeholder="رسالة الترحيب" type="text"
                                        name="welcome_message"
                                        value="{{ $settings->welcome_message ?? 'مرحباً! كيف يمكنني مساعدتك؟' }}">
                                </div>
                            </div>

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-4">
                                    <label class="form-label mg-b-0">اللون الأساسي</label>
                                </div>
                                <div class="col-md-8 mg-t-5 mg-md-t-0">
                                    <div class="input-group colorpicker-element">
                                        <input type="text" class="form-control" id="primary_color" name="primary_color"
                                            value="{{ $settings->primary_color ?? '#28a745' }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <input type="color" id="primary_color_picker"
                                                    value="{{ $settings->primary_color ?? '#28a745' }}">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-4">
                                    <label class="form-label mg-b-0">أيقونة الشات بوت</label>
                                </div>
                                <div class="col-md-8 mg-t-5 mg-md-t-0">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            @if (isset($settings->icon) && $settings->icon)
                                                <img src="{{ asset('storage/' . $settings->icon) }}" class="img-thumbnail"
                                                    style="max-width: 100px" alt="أيقونة الشات بوت">
                                            @else
                                                <div class="text-center p-3 bg-light">
                                                    <i class="fas fa-robot fa-3x text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-sm-12 col-md-8">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="icon"
                                                    name="icon">
                                                <label class="custom-file-label" for="icon">اختر صورة</label>
                                            </div>
                                            <small class="form-text text-muted">
                                                الحجم المناسب: 64×64 بكسل، صيغة PNG أو SVG
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-4">
                                    <label class="form-label mg-b-0">وقت الاستجابة</label>
                                </div>
                                <div class="col-md-8 mg-t-5 mg-md-t-0">
                                    <div class="input-group">
                                        <input class="form-control" placeholder="وقت الاستجابة" type="number"
                                            min="0" max="60" name="response_time"
                                            value="{{ $settings->response_time ?? 5 }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">دقائق</span>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">
                                        وقت الاستجابة المتوقع للرد على رسائل العملاء
                                    </small>
                                </div>
                            </div>

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-4">
                                    <label class="form-label mg-b-0">البريد الإلكتروني لاستقبال الإشعارات</label>
                                </div>
                                <div class="col-md-8 mg-t-5 mg-md-t-0">
                                    <input class="form-control" placeholder="البريد الإلكتروني" type="email"
                                        name="notification_email" value="{{ $settings->notification_email ?? '' }}">
                                </div>
                            </div>

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-4">
                                    <label class="form-label mg-b-0">إعدادات إضافية</label>
                                </div>
                                <div class="col-md-8 mg-t-5 mg-md-t-0">
                                    <div class="custom-controls-stacked">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="show_offline"
                                                value="1" {{ $settings->show_offline ?? false ? 'checked' : '' }}>
                                            <span class="custom-control-label">إظهار الشات بوت عندما يكون غير متصل</span>
                                        </label>
                                        <label class="custom-control custom-checkbox mt-2">
                                            <input type="checkbox" class="custom-control-input" name="require_email"
                                                value="1" {{ $settings->require_email ?? true ? 'checked' : '' }}>
                                            <span class="custom-control-label">جعل البريد الإلكتروني إلزامياً</span>
                                        </label>
                                        <label class="custom-control custom-checkbox mt-2">
                                            <input type="checkbox" class="custom-control-input" name="auto_reply"
                                                value="1" {{ $settings->auto_reply ?? false ? 'checked' : '' }}>
                                            <span class="custom-control-label">تفعيل الرد التلقائي</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-4">
                                    <label class="form-label mg-b-0">نص الرد التلقائي</label>
                                </div>
                                <div class="col-md-8 mg-t-5 mg-md-t-0">
                                    <textarea class="form-control" rows="4" name="auto_reply_message" placeholder="نص الرد التلقائي">{{ $settings->auto_reply_message ?? 'شكراً لتواصلك معنا. سنقوم بالرد عليك في أقرب وقت ممكن.' }}</textarea>
                                </div>
                            </div>

                            <div class="row mg-t-30">
                                <div class="col-md-12 text-left">
                                    <button type="submit" class="btn btn-primary">حفظ الإعدادات</button>
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary">إلغاء</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection

@section('js')
    <!--Internal  Select2 js -->
    <script src="{{ URL::asset('assets-admin/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets-admin/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!--Internal  Sweet-Alert js-->
    <script src="{{ URL::asset('assets-admin/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets-admin/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets-admin/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/fancyuploder/fancy-uploader.js') }}"></script>

    <script>
        $(function() {
            // Color picker event
            $('#primary_color_picker').on('input', function() {
                $('#primary_color').val($(this).val());
            });

            // File input
            $('.custom-file-input').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(fileName || 'اختر صورة');
            });
        });
    </script>
@endsection
