@extends('admin.layouts.master')

@section('title', 'إضافة تصنيف جديد')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">إضافة تصنيف جديد</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.blog.categories.index') }}">إدارة التصنيفات</a></li>
            <li class="breadcrumb-item active">إضافة تصنيف جديد</li>
        </ol>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-folder-plus me-1"></i>
                        إضافة تصنيف جديد
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

                        <form action="{{ route('admin.blog.categories.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label required">اسم التصنيف</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}" required>
                                <div class="form-text">سيتم إنشاء رابط مختصر (slug) تلقائياً استناداً إلى هذا الاسم</div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">وصف التصنيف</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                <div class="form-text">وصف موجز للتصنيف (اختياري)</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="order" class="form-label">الترتيب</label>
                                    <input type="number" class="form-control" id="order" name="order"
                                        value="{{ old('order', 0) }}">
                                    <div class="form-text">التصنيفات ذات الأرقام الأقل تظهر أولاً</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="is_active" class="form-label d-block">الحالة</label>
                                    <div class="form-check form-switch mt-2">
                                        <input type="hidden" name="is_active" value="0">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                            value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">نشط</label>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-4 mb-3">إعدادات تحسين محركات البحث (SEO)</h5>

                            <div class="mb-3">
                                <label for="meta_title" class="form-label">عنوان ميتا</label>
                                <input type="text" class="form-control" id="meta_title" name="meta_title"
                                    value="{{ old('meta_title') }}">
                                <div class="form-text">سيتم استخدام اسم التصنيف إذا تركت فارغاً</div>
                            </div>

                            <div class="mb-3">
                                <label for="meta_description" class="form-label">وصف ميتا</label>
                                <textarea class="form-control" id="meta_description" name="meta_description" rows="2">{{ old('meta_description') }}</textarea>
                                <div class="form-text">سيتم استخدام وصف التصنيف إذا تركت فارغاً</div>
                            </div>

                            <div class="mb-3">
                                <label for="meta_keywords" class="form-label">كلمات مفتاحية</label>
                                <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                                    value="{{ old('meta_keywords') }}">
                                <div class="form-text">افصل بين الكلمات المفتاحية بفواصل</div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">إضافة التصنيف</button>
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
                        معلومات مساعدة
                    </div>
                    <div class="card-body">
                        <p>التصنيفات تساعد في تنظيم محتوى المدونة وتوجيه القراء نحو المواضيع التي تهمهم.</p>
                        <p>نصائح لتصنيفات فعالة:</p>
                        <ul>
                            <li>استخدم أسماء واضحة ومختصرة</li>
                            <li>تجنب استخدام عدد كبير من التصنيفات</li>
                            <li>اختر تصنيفات تناسب مجال موقعك</li>
                            <li>تأكد من إضافة وصف مفيد يشرح محتوى التصنيف</li>
                        </ul>
                        <div class="alert alert-info">
                            <i class="fas fa-lightbulb me-1"></i> تأكد من تفعيل خيار "نشط" إذا أردت أن يظهر التصنيف للزوار.
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
