@extends('admin.layouts.master')

@section('title', 'إضافة رأي عميل جديد')

@section('css')
    <!-- Internal Rating css -->
    <link href="{{ URL::asset('assets-admin/plugins/rating/ratings.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">إدارة المحتوى</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ آراء العملاء / إضافة جديد</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">إضافة رأي عميل جديد</h4>
                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-right"></i> العودة للقائمة
                        </a>
                    </div>
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

                    <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="customer_name">اسم العميل <span class="text-danger">*</span></label>
                                    <input type="text" name="customer_name" id="customer_name" class="form-control"
                                        value="{{ old('customer_name') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="customer_position">المنصب</label>
                                    <input type="text" name="customer_position" id="customer_position"
                                        class="form-control" value="{{ old('customer_position') }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="quote">الاقتباس <span class="text-danger">*</span></label>
                                    <textarea name="quote" id="quote" class="form-control" rows="4" required>{{ old('quote') }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">التقييم بالنجوم <span class="text-danger">*</span></label>
                                    <div class="rating-stars block" id="rating">
                                        <input type="number" readonly class="rating-value" name="stars"
                                            id="rating-stars-value" value="{{ old('stars', 5) }}">
                                        <div class="rating-container">
                                            <div class="rating-stars">
                                                <a class="star" data-value="1"></a>
                                                <a class="star" data-value="2"></a>
                                                <a class="star" data-value="3"></a>
                                                <a class="star" data-value="4"></a>
                                                <a class="star" data-value="5"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="image">الصورة الشخصية</label>
                                    <input type="file" name="image" id="image" class="form-control-file">
                                    <small class="form-text text-muted">المقاس المفضل: 300×300 بيكسل | الحد الأقصى للحجم: 2
                                        ميجابايت</small>
                                    <div id="image-preview" class="mt-2" style="display: none;">
                                        <img src="" alt="معاينة الصورة"
                                            style="max-height: 150px; max-width: 150px; border-radius: 50%;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="ordering">الترتيب <span class="text-danger">*</span></label>
                                    <input type="number" name="ordering" id="ordering" class="form-control"
                                        value="{{ old('ordering', 0) }}" required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group pt-4 mt-2">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="is_active" value="1" class="custom-control-input"
                                            id="is_active" {{ old('is_active') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">تفعيل</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">إلغاء</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection

@section('js')
    <!-- Internal Rating js -->
    <script src="{{ URL::asset('assets-admin/plugins/rating/jquery.rating-stars.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/rating/jquery.barrating.js') }}"></script>

    <script>
        $(document).ready(function() {
            // تمكين معاينة الصورة قبل الرفع
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#image-preview').show();
                        $('#image-preview img').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#image").change(function() {
                readURL(this);
            });

            // تهيئة نظام التقييم بالنجوم
            $(function() {
                $('.rating-stars').barrating({
                    theme: 'fontawesome-stars',
                    initialRating: $('#rating-stars-value').val(),
                    onSelect: function(value, text, event) {
                        $('#rating-stars-value').val(value);
                    }
                });
            });
        });
    </script>
@endsection
