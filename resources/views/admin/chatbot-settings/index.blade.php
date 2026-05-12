@extends('admin.layouts.master')

@section('title', 'إعدادات الشات بوت')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الشات بوت</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الإعدادات المتقدمة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-4">
            <h1 class="h3 text-gray-800">إعدادات الشات بوت</h1>
            <div>
                <a href="{{ route('admin.chatbot-settings.export', ['search' => $search ?? '', 'sort' => $sortField ?? 'frequency', 'direction' => $sortDirection ?? 'desc']) }}"
                    class="btn btn-sm btn-success ml-2">
                    <i class="fas fa-file-export"></i> تصدير التقرير
                </a>
                <a href="{{ route('admin.chatbot-settings.showImport') }}" class="btn btn-sm btn-info ml-2">
                    <i class="fas fa-file-import"></i> استيراد من Excel
                </a>
                <a href="{{ route('admin.chatbot-settings.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> إضافة إعداد جديد
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('import_errors') && count(session('import_errors')) > 0)
            <div class="alert alert-warning">
                <h5>تم استيراد البيانات مع بعض الأخطاء:</h5>
                <ul>
                    @foreach (session('import_errors') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <form action="{{ route('admin.chatbot-settings.index') }}" method="GET" class="row align-items-center">
                    <div class="col-md-6 mb-2 mb-md-0">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="ابحث عن سؤال أو جواب..."
                                value="{{ $search ?? '' }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> بحث
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            <div class="input-group ml-2" style="width: 200px;">
                                <select name="sort" class="form-control">
                                    <option value="frequency" {{ ($sortField ?? '') == 'frequency' ? 'selected' : '' }}>
                                        ترتيب حسب التكرار</option>
                                    <option value="key" {{ ($sortField ?? '') == 'key' ? 'selected' : '' }}>ترتيب حسب
                                        السؤال</option>
                                    <option value="created_at" {{ ($sortField ?? '') == 'created_at' ? 'selected' : '' }}>
                                        ترتيب حسب تاريخ الإنشاء</option>
                                </select>
                                <div class="input-group-append">
                                    <select name="direction" class="form-control">
                                        <option value="desc" {{ ($sortDirection ?? '') == 'desc' ? 'selected' : '' }}>
                                            تنازلي</option>
                                        <option value="asc" {{ ($sortDirection ?? '') == 'asc' ? 'selected' : '' }}>
                                            تصاعدي</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-secondary">
                                <i class="fas fa-sort"></i> ترتيب
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="settingsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>السؤال</th>
                                <th>الإجابة</th>
                                <th>النوع</th>
                                <th>عدد مرات السؤال</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($settings as $setting)
                                <tr>
                                    <td>{{ $setting->id }}</td>
                                    <td>{{ $setting->key }}</td>
                                    <td>{{ Str::limit($setting->value, 50) }}</td>
                                    <td>{{ $setting->type }}</td>
                                    <td><span class="badge badge-info">{{ $setting->frequency }}</span></td>
                                    <td>{!! $setting->active
                                        ? '<span class="badge badge-success">مفعل</span>'
                                        : '<span class="badge badge-secondary">غير مفعل</span>' !!}</td>
                                    <td>
                                        <a href="{{ route('admin.chatbot-settings.edit', $setting->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.chatbot-settings.destroy', $setting->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('هل تريد حذف هذا الإعداد؟')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">{{ $settings->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
