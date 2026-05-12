@extends('admin.layouts.master')

@section('title', 'إدارة الوسوم')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">إدارة الوسوم</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
            <li class="breadcrumb-item active">إدارة الوسوم</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div><i class="fas fa-tags me-1"></i> قائمة الوسوم</div>
                <a href="{{ route('admin.blog.tags.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> إضافة وسم جديد
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
                    <table class="table table-bordered table-striped table-hover" id="tagsTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>الرابط المختصر</th>
                                <th>عدد المقالات</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tags as $tag)
                                <tr>
                                    <td>{{ $tag->id }}</td>
                                    <td>{{ $tag->name }}</td>
                                    <td><code>{{ $tag->slug }}</code></td>
                                    <td>{{ $tag->posts_count }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('blog.tag', $tag->slug) }}" class="btn btn-sm btn-info"
                                                target="_blank" title="معاينة">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.blog.tags.edit', $tag->id) }}"
                                                class="btn btn-sm btn-primary" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.blog.tags.destroy', $tag->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('هل أنت متأكد من حذف هذا الوسم؟ سيتم فصله من جميع المقالات المرتبطة به.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">لا توجد وسوم بعد!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $tags->links() }}
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
            $('#tagsTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Arabic.json"
                },
                "paging": false,
                "info": false,
                "searching": true,
                "columnDefs": [{
                    "orderable": false,
                    "targets": [4]
                }]
            });
        });
    </script>
@endpush
