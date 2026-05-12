@extends('admin.layouts.master')

@section('title', 'إدارة المقالات')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">إدارة المقالات</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
            <li class="breadcrumb-item active">إدارة المقالات</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div><i class="fas fa-newspaper me-1"></i> قائمة المقالات</div>
                <a href="{{ route('admin.blog.posts.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> إضافة مقال جديد
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
                    <table class="table table-bordered table-striped table-hover" id="postsTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>العنوان</th>
                                <th>التصنيف</th>
                                <th>الكاتب</th>
                                <th>الحالة</th>
                                <th>تاريخ النشر</th>
                                <th>المشاهدات</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($posts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($post->featured_image)
                                                <img src="{{ $post->featured_image }}" alt="{{ $post->title }}"
                                                    class="me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                            @endif
                                            <div>{{ Str::limit($post->title, 40) }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $post->category->name }}</td>
                                    <td>{{ $post->user->name }}</td>
                                    <td>
                                        @if ($post->is_published)
                                            <span class="badge bg-success">منشور</span>
                                        @else
                                            <span class="badge bg-warning text-dark">مسودة</span>
                                        @endif
                                    </td>
                                    <td>{{ $post->published_at ? $post->published_at->format('Y-m-d H:i') : 'غير منشور' }}
                                    </td>
                                    <td>{{ $post->views }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-sm btn-info"
                                                target="_blank" title="معاينة">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.blog.posts.edit', $post->id) }}"
                                                class="btn btn-sm btn-primary" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.blog.posts.destroy', $post->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('هل أنت متأكد من حذف هذا المقال؟ هذا الإجراء لا يمكن التراجع عنه.');">
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
                                    <td colspan="8" class="text-center">لا توجد مقالات بعد!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $posts->links() }}
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
            $('#postsTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Arabic.json"
                },
                "paging": false,
                "info": false,
                "searching": true
            });
        });
    </script>
@endpush
