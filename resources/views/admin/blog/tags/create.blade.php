@extends('admin.layouts.master')

@section('title', 'إضافة وسم جديد')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">إضافة وسم جديد</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.blog.tags.index') }}">إدارة الوسوم</a></li>
            <li class="breadcrumb-item active">إضافة وسم جديد</li>
        </ol>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-tag me-1"></i>
                        إضافة وسم جديد
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

                        <form action="{{ route('admin.blog.tags.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label required">اسم الوسم</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}" required>
                                <div class="form-text">سيتم إنشاء رابط مختصر (slug) تلقائياً استناداً إلى هذا الاسم</div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">إضافة الوسم</button>
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
                        معلومات مساعدة
                    </div>
                    <div class="card-body">
                        <p>الوسوم تساعد في تنظيم وتصنيف محتوى المدونة بشكل أكثر مرونة من التصنيفات.</p>
                        <p>نصائح لاستخدام الوسوم بفعالية:</p>
                        <ul>
                            <li>استخدم وسوماً قصيرة وواضحة</li>
                            <li>تجنب الوسوم المتشابهة أو المترادفة</li>
                            <li>الوسم الواحد يمكن استخدامه مع مقالات متعددة</li>
                            <li>المقالة الواحدة يمكن أن تحتوي على عدة وسوم</li>
                        </ul>
                        <div class="alert alert-info">
                            <i class="fas fa-lightbulb me-1"></i> استخدم الوسوم لإنشاء روابط بين المقالات ذات المواضيع
                            المتشابهة.
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
