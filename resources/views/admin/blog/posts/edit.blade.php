@extends('admin.layouts.master')

@section('title', 'تعديل مقال: ' . $post->title)

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">تعديل مقال</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.blog.posts.index') }}">إدارة المقالات</a></li>
            <li class="breadcrumb-item active">تعديل مقال</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-edit me-1"></i>
                تعديل مقال: {{ $post->title }}
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

                <form action="{{ route('admin.blog.posts.update', $post->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label required">عنوان المقال</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title', $post->title) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="excerpt" class="form-label">مقتطف المقال</label>
                                <textarea class="form-control" id="excerpt" name="excerpt" rows="3">{{ old('excerpt', $post->excerpt) }}</textarea>
                                <div class="form-text">مقتطف قصير يظهر في نتائج البحث ويلخص المقال (اختياري)</div>
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label required">محتوى المقال</label>
                                <textarea class="form-control" id="editor" name="content" rows="10">{{ old('content', $post->content) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-header">النشر</div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input type="hidden" name="is_published" value="0">
                                            <input class="form-check-input" type="checkbox" id="is_published"
                                                name="is_published" value="1"
                                                {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_published">نشر الآن</label>
                                        </div>
                                        @if ($post->published_at)
                                            <div class="form-text">تاريخ النشر:
                                                {{ $post->published_at->format('Y-m-d H:i') }}</div>
                                        @endif
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                                        <a href="{{ route('admin.blog.posts.index') }}"
                                            class="btn btn-outline-secondary">إلغاء</a>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-header">التصنيف</div>
                                <div class="card-body">
                                    <select class="form-select" id="blog_category_id" name="blog_category_id" required>
                                        <option value="" disabled>اختر التصنيف</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('blog_category_id', $post->blog_category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-header">الوسوم</div>
                                <div class="card-body">
                                    <select class="form-select" id="tags" name="tags[]" multiple>
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->id }}"
                                                {{ in_array($tag->id, old('tags', $selectedTags)) ? 'selected' : '' }}>
                                                {{ $tag->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text">يمكنك اختيار أكثر من وسم</div>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-header">الصورة المميزة</div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <input class="form-control" type="file" id="featured_image" name="featured_image"
                                            accept="image/*">
                                        <div class="form-text">اترك هذا الحقل فارغاً إذا كنت لا تريد تغيير الصورة</div>
                                    </div>
                                    <div id="imagePreview" class="{{ $post->featured_image ? '' : 'd-none' }} mt-2">
                                        <img src="{{ $post->featured_image }}" alt="{{ $post->title }}"
                                            class="img-fluid">
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">تحسين محركات البحث (SEO)</div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="meta_title" class="form-label">عنوان ميتا</label>
                                        <input type="text" class="form-control" id="meta_title" name="meta_title"
                                            value="{{ old('meta_title', $post->meta_title) }}">
                                        <div class="form-text">سيتم استخدام عنوان المقال إذا تركت فارغاً</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="meta_description" class="form-label">وصف ميتا</label>
                                        <textarea class="form-control" id="meta_description" name="meta_description" rows="2">{{ old('meta_description', $post->meta_description) }}</textarea>
                                        <div class="form-text">سيتم استخدام مقتطف المقال إذا تركت فارغاً</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="meta_keywords" class="form-label">كلمات مفتاحية</label>
                                        <input type="text" class="form-control" id="meta_keywords"
                                            name="meta_keywords"
                                            value="{{ old('meta_keywords', $post->meta_keywords) }}">
                                        <div class="form-text">افصل بين الكلمات المفتاحية بفواصل</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .required:after {
            content: " *";
            color: red;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // إعداد محرر TinyMCE
            tinymce.init({
                selector: '#editor',
                height: 500,
                directionality: 'rtl',
                plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table directionality template paste codesample',
                toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | forecolor backcolor',
                image_title: true,
                automatic_uploads: true,
                file_picker_types: 'image',
                file_picker_callback: function(cb, value, meta) {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');
                    input.onchange = function() {
                        var file = this.files[0];

                        var reader = new FileReader();
                        reader.onload = function() {
                            var id = 'blobid' + (new Date()).getTime();
                            var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                            var base64 = reader.result.split(',')[1];
                            var blobInfo = blobCache.create(id, file, base64);
                            blobCache.add(blobInfo);

                            cb(blobInfo.blobUri(), {
                                title: file.name
                            });
                        };
                        reader.readAsDataURL(file);
                    };
                    input.click();
                }
            });

            // إعداد Select2 للوسوم
            $('#tags').select2({
                placeholder: 'اختر الوسوم',
                allowClear: true,
                dir: 'rtl'
            });

            // معاينة الصورة قبل الرفع
            $('#featured_image').change(function() {
                const file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        $('#imagePreview').removeClass('d-none');
                        $('#imagePreview img').attr('src', event.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endpush
