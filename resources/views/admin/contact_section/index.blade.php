@extends('admin.layouts.master')

@section('title', 'إدارة محتوى قسم الاتصال')

@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets-admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets-admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets-admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets-admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets-admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets-admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--- Internal Sweet-Alert css-->
    <link href="{{ URL::asset('assets-admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">إدارة المحتوى</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قسم الاتصال</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">إعدادات قسم الاتصال</h4>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.contact-section.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="title">العنوان الرئيسي</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        value="{{ $section->title ?? old('title') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="address">العنوان</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        value="{{ $section->address ?? old('address') }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="description">الوصف</label>
                                    <textarea class="form-control" id="description" name="description" rows="4">{{ $section->description ?? old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone">رقم الهاتف</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ $section->phone ?? old('phone') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="whatsapp_number">رقم الواتساب</label>
                                    <input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number"
                                        value="{{ $section->whatsapp_number ?? old('whatsapp_number') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">البريد الإلكتروني</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $section->email ?? old('email') }}">
                                </div>
                            </div>

                            <!-- بيانات الخريطة -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="map_lat">خط العرض للخريطة</label>
                                    <input type="text" class="form-control" id="map_lat" name="map_lat"
                                        value="{{ $section->map_lat ?? old('map_lat') }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="map_lng">خط الطول للخريطة</label>
                                    <input type="text" class="form-control" id="map_lng" name="map_lng"
                                        value="{{ $section->map_lng ?? old('map_lng') }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="map_zoom">مستوى التكبير للخريطة</label>
                                    <input type="number" class="form-control" id="map_zoom" name="map_zoom"
                                        value="{{ $section->map_zoom ?? (old('map_zoom') ?? 15) }}">
                                </div>
                            </div>

                            <!-- روابط التواصل الاجتماعي -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="social_facebook">رابط فيسبوك</label>
                                    <input type="url" class="form-control" id="social_facebook"
                                        name="social_facebook"
                                        value="{{ $section->social_facebook ?? old('social_facebook') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="social_twitter">رابط تويتر</label>
                                    <input type="url" class="form-control" id="social_twitter" name="social_twitter"
                                        value="{{ $section->social_twitter ?? old('social_twitter') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="social_instagram">رابط انستغرام</label>
                                    <input type="url" class="form-control" id="social_instagram"
                                        name="social_instagram"
                                        value="{{ $section->social_instagram ?? old('social_instagram') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="social_linkedin">رابط لينكد إن</label>
                                    <input type="url" class="form-control" id="social_linkedin"
                                        name="social_linkedin"
                                        value="{{ $section->social_linkedin ?? old('social_linkedin') }}">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_active"
                                            name="is_active"
                                            {{ (isset($section) && $section->is_active) || old('is_active') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">تفعيل القسم</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets-admin/js/table-data.js') }}"></script>
    <!--Internal  Sweet-Alert js-->
    <script src="{{ URL::asset('assets-admin/plugins/sweet-alert/sweetalert.min.js') }}"></script>
@endsection
