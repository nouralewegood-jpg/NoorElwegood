@extends('admin.layouts.master')

@section('title', 'تعديل تصنيف: ' . $category->name)

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">تعديل تصنيف</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.blog.categories.index') }}">إدارة التصنيفات</a></li>
            <li class="breadcrumb-item active">تعديل تصنيف</li>
        </ol>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-edit me-1"></i>
                        تعديل تصنيف: {{ $category->name }}
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

                        <form action="{{ route('admin.blog.categories.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label required">اسم التصنيف</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $category->name) }}" required>
                                <div class="form-text">سيتم إنشاء رابط مختصر (slug) تلقائياً استناداً إلى هذا الاسم</div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">وصف التصنيف</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                                <div class="form-text">وصف موجز للتصنيف (اختياري)</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="order" class="form-label">الترتيب</label>
                                    <input type="number" class="form-control" id="order" name="order"
                                        value="{{ old('order', $category->order) }}">
                                    <div class="form-text">التصنيفات ذات الأرقام الأقل تظهر أولاً</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="is_active" class="form-label d-block">الحالة</label>
                                    <div class="form-check form-switch mt-2">
                                        <input type="hidden" name="is_active" value="0">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                            value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">نشط</label>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-4 mb-3">إعدادات تحسين محركات البحث (SEO)</h5>

                            <div class="mb-3">
                                <label for="meta_title" class="form-label">عنوان ميتا</label>
                                <input type="text" class="form-control" id="meta_title" name="meta_title"
                                    value="{{ old('meta_title', $category->meta_title) }}">
                                <div class="form-text">سيتم استخدام اسم التصنيف إذا تركت فارغاً</div>
                            </div>

                            <div class="mb-3">
                                <label for="meta_description" class="form-label">وصف ميتا</label>
                                <textarea class="form-control" id="meta_description" name="meta_description" rows="2">{{ old('meta_description', $category->meta_description) }}</textarea>
                                <div class="form-text">سيتم استخدام وصف التصنيف إذا تركت فارغاً</div>
                            </div>

                            <div class="mb-3">
                                <label for="meta_keywords" class="form-label">كلمات مفتاحية</label>
                                <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                                    value="{{ old('meta_keywords', $category->meta_keywords) }}">
                                <div class="form-text">افصل بين الكلمات المفتاحية بفواصل</div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                                <a href="{{ route('admin.blog.categories.index') }}"
                                    class="btn btn-outline-secondary">إلغاء</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-info-circle me-1"></i>
                        معلومات التصنيف
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>معرف التصنيف:</th>
                                <td>{{ $category->id }}</td>
                            </tr>
                            <tr>
                                <th>الرابط المختصر:</th>
                                <td><code>{{ $category->slug }}</code></td>
                            </tr>
                            <tr>
                                <th>عدد المقالات:</th>
                                <td>{{ $category->posts->count() }}</td>
                            </tr>
                            <tr>
                                <th>تاريخ الإنشاء:</th>
                                <td>{{ $category->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            <tr>
                                <th>آخر تحديث:</th>
                                <td>{{ $category->updated_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        </table>

                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('blog.category', $category->slug) }}" class="btn btn-sm btn-info"
                                target="_blank">
                                <i class="fas fa-eye"></i> معاينة
                            </a>
                            @if ($category->posts->count() == 0)
                                <form action="{{ route('admin.blog.categories.destroy', $category->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('هل أنت متأكد من حذف هذا التصنيف؟ هذا الإجراء لا يمكن التراجع عنه.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> حذف
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-sm btn-danger" disabled
                                    title="لا يمكن حذف هذا التصنيف لأنه يحتوي على مقالات">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            @endif
                        </div>
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
