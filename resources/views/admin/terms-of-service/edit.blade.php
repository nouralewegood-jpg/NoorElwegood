@extends('admin.layouts.master')
@section('css')
    <!-- Internal Summernote css -->
    <link rel="stylesheet" href="{{ URL::asset('assets-admin/plugins/summernote/summernote-bs4.css') }}">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المحتوى</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل شروط الخدمة</span>
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
                        تعديل شروط الخدمة
                    </div>
                    <p class="mg-b-20 text-muted">قم بتعديل محتوى صفحة شروط الخدمة.</p>

                    <!-- أخطاء التحقق -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.terms-of-service.update', $termsOfService->id) }}" method="post"
                        data-parsley-validate="">
                        @csrf
                        @method('PUT')

                        <div class="row row-sm">
                            <div class="col-lg-12">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">العنوان: <span class="tx-danger">*</span></label>
                                    <input class="form-control" name="title" placeholder="عنوان الصفحة" required=""
                                        type="text" value="{{ old('title', $termsOfService->title) }}">
                                </div>
                            </div>

                            <div class="col-lg-12 mt-3">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">المحتوى: <span class="tx-danger">*</span></label>
                                    <textarea class="form-control summernote" name="content" rows="10" placeholder="محتوى شروط الخدمة">{{ old('content', $termsOfService->content) }}</textarea>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <h4>إعدادات SEO</h4>
                                <hr>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">عنوان الميتا (Meta Title):</label>
                                    <input class="form-control" name="meta_title" placeholder="عنوان الصفحة في نتائج البحث"
                                        type="text" value="{{ old('meta_title', $termsOfService->meta_title) }}">
                                    <small class="text-muted">يجب أن يكون مختصرًا (أقل من 60 حرفًا) ويصف محتوى
                                        الصفحة.</small>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-3">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">وصف الميتا (Meta Description):</label>
                                    <textarea class="form-control" name="meta_description" rows="3" placeholder="وصف الصفحة في نتائج البحث">{{ old('meta_description', $termsOfService->meta_description) }}</textarea>
                                    <small class="text-muted">وصف قصير للصفحة (أقل من 160 حرفًا) يظهر في نتائج
                                        البحث.</small>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <button class="btn btn-main-primary pd-x-20 mg-t-10" type="submit">حفظ التغييرات</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Summernote js -->
    <script src="{{ URL::asset('assets-admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // تفعيل محرر Summernote
            $('.summernote').summernote({
                placeholder: 'اكتب محتوى شروط الخدمة هنا...',
                tabsize: 2,
                height: 400,
                lang: 'ar-AR',
                direction: 'rtl',
                callbacks: {
                    onImageUpload: function(files) {
                        uploadImage(files[0], this);
                    }
                },
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'italic', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            // دالة لرفع الصور
            function uploadImage(file, editor) {
                var formData = new FormData();
                formData.append('image', file);

                $.ajax({
                    url: "{{ route('admin.upload.image') }}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $(editor).summernote('insertImage', response.url);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('حدث خطأ أثناء رفع الصورة');
                    }
                });
            }
        });
    </script>
@endsection
