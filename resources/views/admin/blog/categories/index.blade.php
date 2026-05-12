@extends('admin.layouts.master')

@section('title', 'إدارة تصنيفات المدونة')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">إدارة تصنيفات المدونة</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
            <li class="breadcrumb-item active">إدارة تصنيفات المدونة</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div><i class="fas fa-folder me-1"></i> قائمة التصنيفات</div>
                <a href="{{ route('admin.blog.categories.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> إضافة تصنيف جديد
                </a>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="categoriesTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>الرابط المختصر</th>
                                <th>عدد المقالات</th>
                                <th>الترتيب</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td><code>{{ $category->slug }}</code></td>
                                    <td>{{ $category->post_count }}</td>
                                    <td>{{ $category->order }}</td>
                                    <td>
                                        @if ($category->is_active)
                                            <span class="badge bg-success">نشط</span>
                                        @else
                                            <span class="badge bg-danger">غير نشط</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('blog.category', $category->slug) }}"
                                                class="btn btn-sm btn-info" target="_blank" title="معاينة">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.blog.categories.edit', $category->id) }}"
                                                class="btn btn-sm btn-primary" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.blog.categories.destroy', $category->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('هل أنت متأكد من حذف هذا التصنيف؟ هذا الإجراء لا يمكن التراجع عنه.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="حذف"
                                                    {{ $category->posts->count() > 0 ? 'disabled' : '' }}>
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">لا توجد تصنيفات بعد!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#categoriesTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Arabic.json"
                },
                "paging": false,
                "info": false,
                "searching": true,
                "columnDefs": [{
                    "orderable": false,
                    "targets": [6]
                }]
            });
        });
    </script>
@endpush
