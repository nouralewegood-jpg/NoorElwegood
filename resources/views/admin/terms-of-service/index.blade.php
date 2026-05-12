@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المحتوى</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ إدارة شروط
                    الخدمة</span>
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
                    <div class="main-content-label mg-b-5">
                        شروط الخدمة
                    </div>
                    <p class="mg-b-20 text-muted">إدارة محتوى صفحة شروط الخدمة.</p>

                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session()->get('success') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="إغلاق">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered mg-b-0 text-md-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>العنوان</th>
                                    <th>آخر تحديث</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">{{ $termsOfService->id }}</th>
                                    <td>{{ $termsOfService->title }}</td>
                                    <td>
                                        @if ($termsOfService->last_updated_at && is_object($termsOfService->last_updated_at))
                                            {{ $termsOfService->last_updated_at->format('Y-m-d H:i:s') }}
                                        @elseif($termsOfService->last_updated_at)
                                            {{ date('Y-m-d H:i:s', strtotime($termsOfService->last_updated_at)) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.terms-of-service.edit', $termsOfService->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="las la-pen"></i> تعديل
                                        </a>
                                        <a href="{{ route('terms.of.service') }}" target="_blank"
                                            class="btn btn-sm btn-primary">
                                            <i class="las la-eye"></i> معاينة
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
@endsection
