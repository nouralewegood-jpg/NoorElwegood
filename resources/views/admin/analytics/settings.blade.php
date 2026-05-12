@extends('admin.layouts.master')
@section('title', 'إعدادات تحليلات الزيارات')

@section('css')
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 30px;
    }
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 30px;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 50%;
    }
    input:checked + .slider {
        background-color: #2196F3;
    }
    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }
    input:checked + .slider:before {
        -webkit-transform: translateX(30px);
        -ms-transform: translateX(30px);
        transform: translateX(30px);
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">إعدادات تحليلات الزيارات</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.analytics') }}">تحليلات الزيارات</a></li>
                <li class="breadcrumb-item active">الإعدادات</li>
            </ol>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- رسائل النجاح والخطأ -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="row row-sm">
        <!-- إعدادات التحليلات -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">الإعدادات الأساسية</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.analytics.settings.update') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">تفعيل نظام التحليلات</label>
                            <div class="col-md-9 d-flex align-items-center">
                                <label class="switch mb-0">
                                    <input type="checkbox" name="is_enabled" value="1" {{ $settings->is_enabled ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                                <span class="mr-3 text-{{ $settings->is_enabled ? 'success' : 'danger' }}">
                                    {{ $settings->is_enabled ? 'مفعل' : 'معطل' }}
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">تتبع محركات البحث</label>
                            <div class="col-md-9 d-flex align-items-center">
                                <label class="switch mb-0">
                                    <input type="checkbox" name="track_bots" value="1" {{ $settings->track_bots ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                                <span class="mr-3">
                                    {{ $settings->track_bots ? 'مفعل' : 'معطل' }}
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="data_retention_days" class="col-md-3 col-form-label">الاحتفاظ بالبيانات</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="number" class="form-control" id="data_retention_days" name="data_retention_days" value="{{ $settings->data_retention_days }}" min="1" max="365">
                                    <div class="input-group-append">
                                        <span class="input-group-text">يوم</span>
                                    </div>
                                </div>
                                <small class="form-text text-muted">سيتم حذف البيانات الأقدم من هذه المدة تلقائياً</small>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-9 offset-md-3">
                                <button type="submit" class="btn btn-primary">حفظ الإعدادات</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- إحصائيات البيانات -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">إحصائيات البيانات</h4>
                </div>
                <div class="card-body">
                    <p>حجم قاعدة البيانات: <strong>{{ number_format(DB::table('visitor_analytics')->count()) }} سجل</strong></p>
                    <hr>
                    <div class="mt-4">
                        <h5 class="text-danger">حذف البيانات</h5>
                        <p class="text-muted">يمكنك حذف جميع بيانات التحليلات المخزنة. هذا الإجراء لا يمكن التراجع عنه.</p>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#clearDataModal">
                            <i class="fas fa-trash-alt ml-1"></i> حذف جميع البيانات
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-sm mt-3">
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body">
                    <h5><i class="fas fa-info-circle ml-1"></i> معلومات حول نظام التحليلات</h5>
                    <ul class="mb-0">
                        <li>نظام التحليلات يتيح لك معرفة عدد الزيارات ومصدرها والأجهزة المستخدمة.</li>
                        <li>يمكنك تعطيل النظام مؤقتاً إذا كنت تواجه ضغطاً على الخادم.</li>
                        <li>يتم جمع البيانات بطريقة مجهولة ولا يتم تتبع بيانات المستخدمين الشخصية.</li>
                        <li>للحفاظ على أداء الموقع، ننصح بتحديد فترة احتفاظ معقولة للبيانات (90 يوم مناسب).</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal تأكيد حذف البيانات -->
<div class="modal fade" id="clearDataModal" tabindex="-1" aria-labelledby="clearDataModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clearDataModalLabel">تأكيد حذف البيانات</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-exclamation-triangle fa-4x text-warning"></i>
                </div>
                <h5 class="text-center mb-3">هل أنت متأكد من حذف جميع بيانات التحليلات؟</h5>
                <p class="text-danger text-center">لا يمكن التراجع عن هذا الإجراء.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                <form action="{{ route('admin.analytics.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">نعم، حذف جميع البيانات</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
