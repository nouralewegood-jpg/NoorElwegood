@extends('admin.layouts.master')

@section('title', 'تفاصيل طلب الخطة')

@section('css')
    <!--- Internal Sweet-Alert css-->
    <link href="{{ URL::asset('assets-admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">إدارة المحتوى</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ طلبات الخطط / تفاصيل الطلب</span>
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
                        <h4 class="card-title mg-b-0">تفاصيل طلب الخطة #{{ $planRequest->id }}</h4>
                        <div class="btn-group">
                            <a href="{{ route('admin.plan-requests.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-right ml-2"></i> العودة للقائمة
                            </a>
                            <a href="https://wa.me/{{ $planRequest->getFullPhoneNumber() }}" target="_blank"
                                class="btn btn-success mr-2">
                                <i class="fab fa-whatsapp ml-2"></i> تواصل عبر واتساب
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">معلومات العميل</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped mb-0">
                                        <tr>
                                            <th style="width: 40%">الاسم</th>
                                            <td>{{ $planRequest->client_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>رقم الهاتف</th>
                                            <td>
                                                {{ $planRequest->country_code }} {{ $planRequest->phone_number }}
                                                <a href="tel:{{ $planRequest->getFullPhoneNumber() }}"
                                                    class="btn btn-sm btn-outline-primary mr-2">
                                                    <i class="fas fa-phone-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>الدولة</th>
                                            <td>{{ $planRequest->country }}</td>
                                        </tr>
                                        <tr>
                                            <th>تاريخ الطلب</th>
                                            <td>{{ $planRequest->created_at->format('Y-m-d H:i:s') }}</td>
                                        </tr>
                                        <tr>
                                            <th>آخر تحديث</th>
                                            <td>{{ $planRequest->updated_at->format('Y-m-d H:i:s') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">معلومات الخطة المطلوبة</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped mb-0">
                                        <tr>
                                            <th style="width: 40%">اسم الخطة</th>
                                            <td>{{ $planRequest->plan_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>السعر</th>
                                            <td>{{ $planRequest->plan_price }}</td>
                                        </tr>
                                        <tr>
                                            <th>المدة</th>
                                            <td>{{ $planRequest->plan_period }}</td>
                                        </tr>
                                        <tr>
                                            <th>حالة الطلب</th>
                                            <td>
                                                <span class="badge badge-{{ $planRequest->getStatusColor() }}">
                                                    {{ $planRequest->getStatusText() }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-header bg-dark text-white">
                                    <h5 class="mb-0">تفاصيل المشروع</h5>
                                </div>
                                <div class="card-body">
                                    @if ($planRequest->project_details)
                                        <div class="bg-light p-3 rounded">
                                            {!! nl2br(e($planRequest->project_details)) !!}
                                        </div>
                                    @else
                                        <div class="alert alert-info mb-0">
                                            <i class="fas fa-info-circle ml-2"></i> لم يتم إدخال تفاصيل للمشروع.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="mb-0">تحديث حالة الطلب</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.plan-requests.update', $planRequest->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="status">تحديث حالة الطلب</label>
                                                <select class="form-control" name="status" id="status" required>
                                                    <option value="new"
                                                        {{ $planRequest->status == 'new' ? 'selected' : '' }}>جديد</option>
                                                    <option value="in_progress"
                                                        {{ $planRequest->status == 'in_progress' ? 'selected' : '' }}>قيد
                                                        المعالجة</option>
                                                    <option value="completed"
                                                        {{ $planRequest->status == 'completed' ? 'selected' : '' }}>مكتمل
                                                    </option>
                                                    <option value="cancelled"
                                                        {{ $planRequest->status == 'cancelled' ? 'selected' : '' }}>ملغي
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="admin_notes">ملاحظات (للإدارة فقط)</label>
                                                <textarea class="form-control" name="admin_notes" id="admin_notes" rows="4">{{ $planRequest->admin_notes }}</textarea>
                                            </div>
                                        </div>

                                        <div class="text-left">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save ml-2"></i> حفظ التغييرات
                                            </button>
                                            <a href="#" class="btn btn-danger mr-2 delete-btn">
                                                <i class="fas fa-trash-alt ml-2"></i> حذف الطلب
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Form -->
                    <form id="delete-form" action="{{ route('admin.plan-requests.destroy', $planRequest->id) }}"
                        method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection

@section('js')
    <!--Internal  Sweet-Alert js-->
    <script src="{{ URL::asset('assets-admin/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // حذف طلب
            $('.delete-btn').on('click', function(e) {
                e.preventDefault();

                swal({
                    title: "هل أنت متأكد؟",
                    text: "سيتم حذف هذا الطلب نهائياً!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'نعم، احذف!',
                    cancelButtonText: 'إلغاء'
                }, function(isConfirm) {
                    if (isConfirm) {
                        $('#delete-form').submit();
                    }
                });
            });
        });
    </script>
@endsection
