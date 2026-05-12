@extends('admin.layouts.master')

@section('title', 'إدارة محتوى قسم من نحن')

@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets-admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets-admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets-admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets-admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets-admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets-admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--- Internal Sweet-Alert css-->
    <link href="{{ URL::asset('assets-admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets-admin/plugins/sortable/sortable.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">إدارة المحتوى</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قسم من نحن</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">إعدادات قسم "من نحن"</h4>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.about-section.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="meta_text">النص الفوقي</label>
                                    <input type="text" class="form-control" id="meta_text" name="meta_text"
                                        value="{{ $section->meta_text ?? old('meta_text') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="title">العنوان الرئيسي</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        value="{{ $section->title ?? old('title') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="description">الوصف</label>
                                    <textarea class="form-control" id="description" name="description" rows="4">{{ $section->description ?? old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="main_image">الصورة الرئيسية</label>
                                    <input type="file" class="form-control" id="main_image" name="main_image"
                                        accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,image/webp">
                                    <small class="form-text text-muted">المقاسات المفضلة: 600×400 بيكسل | الحد الأقصى للحجم:
                                        2 ميجابايت</small>
                                    @if (isset($section) && $section->main_image && Storage::disk('public')->exists($section->main_image))
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $section->main_image) }}" alt="Main Image"
                                                style="max-height: 100px; max-width: 200px; border-radius: 5px;">
                                            <input type="hidden" name="old_main_image" value="{{ $section->main_image }}">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="secondary_image">الصورة الثانوية</label>
                                    <input type="file" class="form-control" id="secondary_image" name="secondary_image"
                                        accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,image/webp">
                                    <small class="form-text text-muted">المقاسات المفضلة: 400×300 بيكسل | الحد الأقصى للحجم:
                                        2 ميجابايت</small>
                                    @if (isset($section) && $section->secondary_image && Storage::disk('public')->exists($section->secondary_image))
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $section->secondary_image) }}"
                                                alt="Secondary Image"
                                                style="max-height: 100px; max-width: 200px; border-radius: 5px;">
                                            <input type="hidden" name="old_secondary_image"
                                                value="{{ $section->secondary_image }}">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-12">
                                <hr>
                                <h5>بيانات المدير التنفيذي</h5>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="ceo_name">اسم المدير التنفيذي</label>
                                    <input type="text" class="form-control" id="ceo_name" name="ceo_name"
                                        value="{{ $section->ceo_name ?? old('ceo_name') }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="ceo_position">المنصب</label>
                                    <input type="text" class="form-control" id="ceo_position" name="ceo_position"
                                        value="{{ $section->ceo_position ?? old('ceo_position') }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="ceo_image">صورة المدير التنفيذي</label>
                                    <input type="file" class="form-control" id="ceo_image" name="ceo_image"
                                        accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,image/webp">
                                    <small class="form-text text-muted">المقاسات المفضلة: 300×300 بيكسل | الحد الأقصى
                                        للحجم: 2 ميجابايت</small>
                                    @if (isset($section) && $section->ceo_image && Storage::disk('public')->exists($section->ceo_image))
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $section->ceo_image) }}" alt="CEO Image"
                                                style="max-height: 100px; max-width: 100px; border-radius: 50%;">
                                            <input type="hidden" name="old_ceo_image"
                                                value="{{ $section->ceo_image }}">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-12">
                                <hr>
                                <h5>معلومات الاتصال</h5>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone_label">عنوان الهاتف</label>
                                    <input type="text" class="form-control" id="phone_label" name="phone_label"
                                        value="{{ $section->phone_label ?? old('phone_label') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone_number">رقم الهاتف</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number"
                                        value="{{ $section->phone_number ?? old('phone_number') }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <hr>
                                <h5>معلومات الخبرة</h5>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="years_experience">سنوات الخبرة</label>
                                    <input type="text" class="form-control" id="years_experience"
                                        name="years_experience"
                                        value="{{ $section->years_experience ?? old('years_experience') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="experience_text">نص الخبرة</label>
                                    <input type="text" class="form-control" id="experience_text"
                                        name="experience_text"
                                        value="{{ $section->experience_text ?? old('experience_text') }}">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_active"
                                            name="is_active"
                                            {{ (isset($section) && $section->is_active) || old('is_active') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">تفعيل القسم</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">ميزات قسم "من نحن"</h4>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-feature-modal">
                            <i class="fa fa-plus"></i> إضافة ميزة جديدة
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="features-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>نص الميزة</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="sortable" data-url="{{ route('admin.about-section.features.order') }}">
                                @forelse($features as $index => $feature)
                                    <tr data-id="{{ $feature->id }}">
                                        <td><i class="fa fa-bars handle"></i> {{ $index + 1 }}</td>
                                        <td>{{ $feature->feature_text }}</td>
                                        <td>
                                            @if ($feature->is_active)
                                                <span class="badge badge-success">مفعل</span>
                                            @else
                                                <span class="badge badge-danger">غير مفعل</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-info edit-feature"
                                                data-id="{{ $feature->id }}" data-text="{{ $feature->feature_text }}"
                                                data-is-active="{{ $feature->is_active }}" data-toggle="modal"
                                                data-target="#edit-feature-modal">
                                                <i class="fa fa-edit"></i> تعديل
                                            </button>

                                            <form class="d-inline"
                                                action="{{ route('admin.about-section.features.destroy', $feature->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger delete-btn">
                                                    <i class="fa fa-trash"></i> حذف
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">لا توجد ميزات مضافة بعد</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Feature Modal -->
    <div class="modal" id="add-feature-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">إضافة ميزة جديدة</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('admin.about-section.features.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="feature_text">نص الميزة</label>
                            <input type="text" class="form-control" id="feature_text" name="feature_text" required>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="feature_is_active"
                                    name="is_active" value="1" checked>
                                <label class="custom-control-label" for="feature_is_active">تفعيل</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">حفظ</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Feature Modal -->
    <div class="modal" id="edit-feature-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">تعديل الميزة</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form id="edit-feature-form" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_feature_text">نص الميزة</label>
                            <input type="text" class="form-control" id="edit_feature_text" name="feature_text"
                                required>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit_feature_is_active"
                                    name="is_active" value="1">
                                <label class="custom-control-label" for="edit_feature_is_active">تفعيل</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">حفظ التعديلات</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets-admin/js/table-data.js') }}"></script>
    <!--Internal  Sweet-Alert js-->
    <script src="{{ URL::asset('assets-admin/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/sortable/Sortable.min.js') }}"></script>
    <script>
        $(function() {
            // Initialize datatable
            $('#features-table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/ar.json'
                }
            });

            // Handle edit feature modal
            $('.edit-feature').click(function() {
                var id = $(this).data('id');
                var text = $(this).data('text');
                var isActive = $(this).data('is-active');

                $('#edit-feature-form').attr('action',
                    '{{ route('admin.about-section.features.update', '') }}/' + id);
                $('#edit_feature_text').val(text);
                $('#edit_feature_is_active').prop('checked', isActive == 1);
            });

            // Delete confirmation
            $('.delete-btn').click(function(e) {
                e.preventDefault();
                var form = $(this).closest('form');

                swal({
                    title: "هل أنت متأكد؟",
                    text: "لن تتمكن من استعادة هذه الميزة بعد حذفها!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "نعم، احذفها!",
                    cancelButtonText: "لا، إلغاء!",
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    closeOnConfirm: false
                }, function() {
                    form.submit();
                });
            });

            // Handle sortable
            var sortable = new Sortable(document.querySelector('.sortable tbody'), {
                handle: '.handle',
                animation: 150,
                onEnd: function(evt) {
                    var itemsOrder = [];
                    $('.sortable tbody tr').each(function() {
                        itemsOrder.push($(this).data('id'));
                    });

                    // Send order to server
                    $.ajax({
                        url: $('.sortable').data('url'),
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            features: itemsOrder
                        },
                        success: function(response) {
                            console.log('Order updated!');
                        },
                        error: function(xhr) {
                            console.error('Error updating order');
                        }
                    });
                }
            });

            // إضافة معاينة مسبقة للصور قبل الرفع
            function readURL(input, preview) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        preview.attr('src', e.target.result);
                        preview.parent().show();
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $(document).ready(function() {
                // معاينة الصورة الرئيسية
                $("#main_image").change(function() {
                    var preview = $(this).next().next().find('img');
                    if (preview.length === 0) {
                        $(this).next().after(
                            '<div class="mt-2"><img src="" alt="Main Image Preview" style="max-height: 100px; max-width: 200px; border-radius: 5px;"></div>'
                        );
                        preview = $(this).next().next().find('img');
                    }
                    readURL(this, preview);
                });

                // معاينة الصورة الثانوية
                $("#secondary_image").change(function() {
                    var preview = $(this).next().next().find('img');
                    if (preview.length === 0) {
                        $(this).next().after(
                            '<div class="mt-2"><img src="" alt="Secondary Image Preview" style="max-height: 100px; max-width: 200px; border-radius: 5px;"></div>'
                        );
                        preview = $(this).next().next().find('img');
                    }
                    readURL(this, preview);
                });

                // معاينة صورة المدير التنفيذي
                $("#ceo_image").change(function() {
                    var preview = $(this).next().next().find('img');
                    if (preview.length === 0) {
                        $(this).next().after(
                            '<div class="mt-2"><img src="" alt="CEO Image Preview" style="max-height: 100px; max-width: 100px; border-radius: 50%;"></div>'
                        );
                        preview = $(this).next().next().find('img');
                    }
                    readURL(this, preview);
                });
            });
        });
    </script>
@endsection
