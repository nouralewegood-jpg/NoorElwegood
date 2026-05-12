@extends('admin.layouts.master')
@section('css')
    <!-- Summernote css -->
    <link href="{{ URL::asset('assets-admin/plugins/summernote/summernote-bs4.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المحتوى</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل سياسة الخصوصية</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        تعديل سياسة الخصوصية
                    </div>
                    <p class="mg-b-20 text-muted">تعديل محتوى صفحة سياسة الخصوصية.</p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.privacy-policy.update', $privacyPolicy->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">العنوان <span class="tx-danger">*</span></label>
                                    <input type="text" name="title" id="title"
                                        class="form-control @error('title') is-invalid @enderror" placeholder="عنوان الصفحة"
                                        value="{{ old('title', $privacyPolicy->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="meta_title">عنوان ميتا (SEO)</label>
                                    <input type="text" name="meta_title" id="meta_title"
                                        class="form-control @error('meta_title') is-invalid @enderror"
                                        placeholder="عنوان ميتا للصفحة (اختياري)"
                                        value="{{ old('meta_title', $privacyPolicy->meta_title) }}">
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="meta_description">وصف ميتا (SEO)</label>
                                    <textarea name="meta_description" id="meta_description"
                                        class="form-control @error('meta_description') is-invalid @enderror" placeholder="وصف ميتا للصفحة (اختياري)"
                                        rows="3">{{ old('meta_description', $privacyPolicy->meta_description) }}</textarea>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="content">المحتوى <span class="tx-danger">*</span></label>
                                    <textarea name="content" id="content" class="form-control summernote @error('content') is-invalid @enderror"
                                        rows="10">{{ old('content', $privacyPolicy->content) }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> حفظ التغييرات
                                    </button>
                                    <a href="{{ route('admin.privacy-policy.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> إلغاء
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Summernote js -->
    <script src="{{ URL::asset('assets-admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 350,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        for (let i = 0; i < files.length; i++) {
                            uploadImage(files[i]);
                        }
                    }
                }
            });

            // Función para subir imágenes al servidor
            function uploadImage(file) {
                let formData = new FormData();
                formData.append('image', file);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: '{{ route('admin.upload.image') }}',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    type: 'post',
                    success: function(data) {
                        let image = $('<img>').attr('src', data.url);
                        $('.summernote').summernote("insertNode", image[0]);
                    },
                    error: function(data) {
                        console.log(data);
                        alert('حدث خطأ أثناء رفع الصورة');
                    }
                });
            }
        });
    </script>
@endsection
