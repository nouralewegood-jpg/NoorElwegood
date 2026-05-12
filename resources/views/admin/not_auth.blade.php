@extends('admin.layouts.master2')
@section('css')
    <!--- Style css -->
    <link href="{{ URL::asset('assets-admin/css/style.css') }}" rel="stylesheet">
    <!--- Dark-mode css -->
    <link href="{{ URL::asset('assets-admin/css/style-dark.css') }}" rel="stylesheet">
    <!---Skinmodes css-->
    <link href="{{ URL::asset('assets-admin/css/skin-modes.css') }}" rel="stylesheet">
@endsection
@section('content')
    <!-- Main-error-wrapper -->
    <div class="main-error-wrapper page page-h">
        <img src="{{ URL::asset('assets-admin/img/media/403.png') }}" class="error-page" alt="error">
        <h2>عفواً. ليس لديك صلاحيات كافية للوصول لهذه الصفحة.</h2>
        <h6>ربما لا تملك الصلاحيات المطلوبة.</h6><a class="btn btn-outline-danger" href="{{ url('/') }}">العودة للصفحة
            الرئيسية</a>
    </div>
    <!-- /Main-error-wrapper -->
@endsection
@section('js')
@endsection
