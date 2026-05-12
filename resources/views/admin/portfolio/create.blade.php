@extends('admin.layouts.master')


@section('title', 'إضافة عمل جديد')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>إضافة عمل جديد</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.portfolio.index') }}">معرض الأعمال</a></li>
                    <li class="breadcrumb-item active">إضافة عمل جديد</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">إضافة عمل جديد</h3>
                    </div>
                    <!-- /.card-header -->

                    <!-- form start -->
                    <form action="{{ route('admin.portfolio.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul style="margin-bottom: 0px;">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="title">عنوان العمل <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">وصف العمل</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="5">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="category">التصنيف</label>
                                        <input type="text" class="form-control @error('category') is-invalid @enderror"
                                            id="category" name="category" value="{{ old('category') }}">
                                        @error('category')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="client_name">اسم العميل</label>
                                        <input type="text"
                                            class="form-control @error('client_name') is-invalid @enderror" id="client_name"
                                            name="client_name" value="{{ old('client_name') }}">
                                        @error('client_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="project_date">تاريخ المشروع</label>
                                        <input type="date"
                                            class="form-control @error('project_date') is-invalid @enderror"
                                            id="project_date" name="project_date" value="{{ old('project_date') }}">
                                        @error('project_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tags">الوسوم (افصل بين الوسوم بفاصلة)</label>
                                <input type="text" class="form-control @error('tags') is-invalid @enderror"
                                    id="tags" name="tags" value="{{ old('tags') }}"
                                    placeholder="مثال: تصميم داخلي, ديكور, منازل">
                                @error('tags')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="image">الصورة الرئيسية <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('image') is-invalid @enderror"
                                            id="image" name="image" accept="image/*" required>
                                        <label class="custom-file-label" for="image">اختر الصورة</label>
                                    </div>
                                </div>
                                <small class="form-text text-muted">يفضل صورة بأبعاد متناسقة بحجم لا يزيد عن 2MB</small>
                                @error('image')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="gallery">معرض الصور (يمكن اختيار أكثر من صورة)</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file"
                                            class="custom-file-input @error('gallery.*') is-invalid @enderror"
                                            id="gallery" name="gallery[]" accept="image/*" multiple>
                                        <label class="custom-file-label" for="gallery">اختر الصور</label>
                                    </div>
                                </div>
                                <small class="form-text text-muted">يمكنك اختيار عدة صور في وقت واحد (الحد الأقصى 2MB لكل
                                    صورة)</small>
                                @error('gallery.*')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="display_order">ترتيب العرض</label>
                                        <input type="number"
                                            class="form-control @error('display_order') is-invalid @enderror"
                                            id="display_order" name="display_order"
                                            value="{{ old('display_order', 0) }}" min="0">
                                        @error('display_order')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>الحالة</label>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="active"
                                                name="active" value="1"
                                                {{ old('active', '1') == '1' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="active">نشط</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>عرض في القسم المميز</label>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="is_featured"
                                                name="is_featured" value="1"
                                                {{ old('is_featured') == '1' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_featured">عرض في القسم المميز
                                                بالصفحة الرئيسية</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> حفظ
                            </button>
                            <a href="{{ route('admin.portfolio.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> إلغاء
                            </a>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets-admin/plugins/bootstrap-fileinput/css/fileinput.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets-admin/plugins/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('assets-admin/plugins/bootstrap-fileinput/js/locales/ar.js') }}"></script>
    <script>
        $(function() {
            // تهيئة محرر النص
            $('#description').summernote({
                height: 200,
                placeholder: 'اكتب وصف العمل هنا...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                lang: 'ar-AR'
            });

            // تهيئة مربع اختيار الصورة الرئيسية
            $("#image").fileinput({
                language: 'ar',
                showUpload: false,
                showCancel: false,
                allowedFileExtensions: ["jpg", "png", "gif", "jpeg", "webp"],
                maxFileSize: 2048,
                showPreview: true,
                previewFileType: "image",
                browseOnZoneClick: true
            });

            // تهيئة مربع اختيار معرض الصور
            $("#gallery").fileinput({
                language: 'ar',
                showUpload: false,
                showCancel: false,
                allowedFileExtensions: ["jpg", "png", "gif", "jpeg", "webp"],
                maxFileSize: 2048,
                showPreview: true,
                previewFileType: "image",
                browseOnZoneClick: true,
                fileActionSettings: {
                    showRemove: true,
                    showUpload: false,
                    showZoom: true,
                    showDrag: false
                }
            });

            // تحديث اسم الملف المختار
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
        });
    </script>
@endsection
