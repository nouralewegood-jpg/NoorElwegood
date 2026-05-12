@extends('admin.layouts.master')

@section('title', 'Edit Service')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Service: {{ $service->title }}</h1>
            <a href="{{ route('admin.services.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Services
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Service Details</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.services.update', $service->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="title">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title', $service->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                    id="slug" name="slug" value="{{ old('slug', $service->slug) }}">
                                <small class="form-text text-muted">Leave empty to auto-generate from title</small>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="short_description">Short Description <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description"
                                    name="short_description" rows="3">{{ old('short_description', $service->short_description) }}</textarea>
                                @error('short_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="content">Content <span class="text-danger">*</span></label>
                                <textarea class="form-control summernote @error('content') is-invalid @enderror" id="content" name="content"
                                    rows="10">{{ old('content', $service->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="m-0 font-weight-bold text-primary">Service Settings</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="icon">Icon Class</label>
                                        <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                            id="icon" name="icon" value="{{ old('icon', $service->icon) }}">
                                        <small class="form-text text-muted">Bootstrap Icons class name (e.g.,
                                            bi-check-circle)</small>
                                        @error('icon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="featured_image">Featured Image</label>
                                        @if ($service->featured_image)
                                            <div class="mb-2">
                                                <img src="{{ asset('storage/' . $service->featured_image) }}"
                                                    alt="{{ $service->title }}" class="img-thumbnail"
                                                    style="max-height: 150px;">
                                            </div>
                                        @endif
                                        <input type="file"
                                            class="form-control-file @error('featured_image') is-invalid @enderror"
                                            id="featured_image" name="featured_image">
                                        <small class="form-text text-muted">Leave empty to keep current image</small>
                                        @error('featured_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="sort_order">Sort Order</label>
                                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                            id="sort_order" name="sort_order"
                                            value="{{ old('sort_order', $service->sort_order) }}">
                                        @error('sort_order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured"
                                            value="1"
                                            {{ old('is_featured', $service->is_featured) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">Featured Service</label>
                                    </div>

                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" id="is_published"
                                            name="is_published" value="1"
                                            {{ old('is_published', $service->is_published) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_published">Published</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Service</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            // Auto slug generation
            $('#title').on('blur', function() {
                if ($('#slug').val() === '') {
                    let slug = $(this).val()
                        .toLowerCase()
                        .replace(/[^\w\s-]/g, '')
                        .replace(/[\s_-]+/g, '-')
                        .replace(/^-+|-+$/g, '');
                    $('#slug').val(slug);
                }
            });
        });
    </script>
@endsection
