@extends('admin.layouts.master')

@section('title', 'إدارة مرادفات شات بوت')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الشات بوت</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المترادفات</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">قائمة مرادفات الشات بوت</h3>
                    <a href="{{ route('admin.chatbot-synonyms.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> إضافة مرادف جديد
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الكلمة الرئيسية</th>
                                <th>المرادفات</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($synonyms as $synonym)
                                <tr>
                                    <td>{{ $synonym->id }}</td>
                                    <td>{{ $synonym->main_word }}</td>
                                    <td>
                                        <span
                                            class="badge badge-info">{{ implode('</span> <span class="badge badge-info">', $synonym->synonyms ?? []) }}</span>
                                    </td>
                                    <td>
                                        @if ($synonym->active)
                                            <span class="badge badge-success">مفعل</span>
                                        @else
                                            <span class="badge badge-danger">معطل</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.chatbot-synonyms.edit', $synonym->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fa fa-edit"></i> تعديل
                                            </a>
                                            <form action="{{ route('admin.chatbot-synonyms.destroy', $synonym->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i> حذف
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">لا توجد مرادفات متاحة</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $synonyms->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
