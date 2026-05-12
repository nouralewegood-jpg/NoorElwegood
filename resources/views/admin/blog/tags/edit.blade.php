@extends('admin.layouts.master')

@section('title', 'تعديل وسم: ' . $tag->name)

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">تعديل وسم</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.blog.tags.index') }}">إدارة الوسوم</a></li>
            <li class="breadcrumb-item active">تعديل وسم</li>
        </ol>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-edit me-1"></i>
                        تعديل وسم: {{ $tag->name }}
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.blog.tags.update', $tag->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label required">اسم الوسم</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $tag->name) }}" required>
                                <div class="form-text">سيتم إنشاء رابط مختصر (slug) تلقائياً استناداً إلى هذا الاسم</div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                                <a href="{{ route('admin.blog.tags.index') }}" class="btn btn-outline-secondary">إلغاء</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-info-circle me-1"></i>
                        معلومات الوسم
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>معرف الوسم:</th>
                                <td>{{ $tag->id }}</td>
                            </tr>
                            <tr>
                                <th>الرابط المختصر:</th>
                                <td><code>{{ $tag->slug }}</code></td>
                            </tr>
                            <tr>
                                <th>عدد المقالات:</th>
                                <td>{{ $tag->posts_count }}</td>
                            </tr>
                            <tr>
                                <th>تاريخ الإنشاء:</th>
                                <td>{{ $tag->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            <tr>
                                <th>آخر تحديث:</th>
                                <td>{{ $tag->updated_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        </table>

                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('blog.tag', $tag->slug) }}" class="btn btn-sm btn-info" target="_blank">
                                <i class="fas fa-eye"></i> معاينة
                            </a>
                            <form action="{{ route('admin.blog.tags.destroy', $tag->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('هل أنت متأكد من حذف هذا الوسم؟ سيتم فصله من جميع المقالات المرتبطة به.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-newspaper me-1"></i>
                        المقالات المرتبطة
                    </div>
                    <div class="card-body">
                        @if ($tag->posts_count > 0)
                            <p>يُستخدم هذا الوسم في {{ $tag->posts_count }} مقال:</p>
                            <ul class="list-group list-group-flush">
                                @foreach ($tag->posts()->take(5)->get() as $post)
                                    <li class="list-group-item px-0">
                                        <a
                                            href="{{ route('admin.blog.posts.edit', $post->id) }}">{{ Str::limit($post->title, 50) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            @if ($tag->posts_count > 5)
                                <div class="mt-2 text-center">
                                    <small class="text-muted">ويستخدم أيضاً في {{ $tag->posts_count - 5 }} مقال
                                        آخر...</small>
                                </div>
                            @endif
                        @else
                            <p class="text-muted">لم يتم استخدام هذا الوسم مع أي مقالات حتى الآن.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .required:after {
            content: " *";
            color: red;
        }
    </style>
@endpush
