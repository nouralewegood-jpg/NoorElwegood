@extends('admin.layouts.master')
@section('title', 'تحليلات الزيارات معطلة')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">تحليلات الزيارات</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active">تحليلات الزيارات</li>
            </ol>
        </div>
    </div>
    <!-- End Page Header -->

    <div class="row row-sm">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body text-center p-5">
                    <i class="fas fa-chart-bar fa-5x text-muted mb-4"></i>
                    <h3>نظام تحليلات الزيارات معطل حالياً</h3>
                    <p class="text-muted mb-4">قم بتفعيل نظام تحليلات الزيارات للحصول على بيانات وإحصائيات حول زوار موقعك ومصادرهم.</p>
                    <a href="{{ route('admin.analytics.settings') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-cog ml-1"></i> تفعيل النظام
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
