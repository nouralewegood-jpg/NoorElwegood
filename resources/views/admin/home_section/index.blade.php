@extends('admin.layouts.master')

@section('title', 'إدارة محتوى الصفحة الرئيسية')

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
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الصفحة الرئيسية</span>
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
                        <h4 class="card-title mg-b-0">إعدادات الصفحة الرئيسية</h4>
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

                    <form action="{{ route('admin.home-section.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="main_title_line1">العنوان الرئيسي (السطر الأول)</label>
                                    <input type="text" class="form-control" id="main_title_line1" name="main_title_line1"
                                        value="{{ $section->main_title_line1 ?? old('main_title_line1') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="main_title_line2">العنوان الرئيسي (السطر الثاني)</label>
                                    <input type="text" class="form-control" id="main_title_line2" name="main_title_line2"
                                        value="{{ $section->main_title_line2 ?? old('main_title_line2') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="main_title_line3">العنوان الرئيسي (السطر الثالث)</label>
                                    <input type="text" class="form-control" id="main_title_line3" name="main_title_line3"
                                        value="{{ $section->main_title_line3 ?? old('main_title_line3') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="company_badge">شعار الشركة</label>
                                    <input type="text" class="form-control" id="company_badge" name="company_badge"
                                        value="{{ $section->company_badge ?? old('company_badge') }}"
                                        placeholder="Sed dolor incididunt">
                                    <small class="form-text text-muted">أدخل نص شعار الشركة الذي سيظهر في الصفحة
                                        الرئيسية</small>
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
                                    <label for="btn_text">نص زر الدعوة للعمل</label>
                                    <input type="text" class="form-control" id="btn_text" name="btn_text"
                                        value="{{ $section->btn_text ?? old('btn_text') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="btn_link">رابط زر الدعوة للعمل</label>
                                    <input type="text" class="form-control" id="btn_link" name="btn_link"
                                        value="{{ $section->btn_link ?? old('btn_link') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="video_btn_text">نص زر الفيديو</label>
                                    <input type="text" class="form-control" id="video_btn_text" name="video_btn_text"
                                        value="{{ $section->video_btn_text ?? old('video_btn_text') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="video_link">رابط الفيديو</label>
                                    <input type="text" class="form-control" id="video_link" name="video_link"
                                        value="{{ $section->video_link ?? old('video_link') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="hero_image">صورة القسم الرئيسي</label>
                                    <input type="file" class="form-control" id="hero_image" name="hero_image">
                                    @if (isset($section) && $section->hero_image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $section->hero_image) }}" alt="Hero Image"
                                                style="max-height: 100px;">
                                            <input type="hidden" name="old_hero_image"
                                                value="{{ $section->hero_image }}">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="customer_count">عدد العملاء</label>
                                    <input type="text" class="form-control" id="customer_count" name="customer_count"
                                        value="{{ $section->customer_count ?? old('customer_count') }}">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="customer_text">نص العملاء</label>
                                    <input type="text" class="form-control" id="customer_text" name="customer_text"
                                        value="{{ $section->customer_text ?? old('customer_text') }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_active"
                                            name="is_active" value="1"
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

    <!-- Stats Section -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">إحصائيات الصفحة الرئيسية</h4>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-stat-modal">
                            <i class="fa fa-plus"></i> إضافة إحصائية جديدة
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="stats-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الأيقونة</th>
                                    <th>العنوان</th>
                                    <th>العنوان الفرعي</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="sortable" data-url="{{ route('admin.home-section.stats.order') }}">
                                @forelse($stats as $index => $stat)
                                    <tr data-id="{{ $stat->id }}">
                                        <td><i class="fa fa-bars handle"></i> {{ $index + 1 }}</td>
                                        <td><i class="{{ $stat->icon }}"></i> {{ $stat->icon }}</td>
                                        <td>{{ $stat->title }}</td>
                                        <td>{{ $stat->subtitle }}</td>
                                        <td>
                                            @if ($stat->is_active)
                                                <span class="badge badge-success">مفعل</span>
                                            @else
                                                <span class="badge badge-danger">غير مفعل</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-info edit-stat" data-id="{{ $stat->id }}"
                                                data-icon="{{ $stat->icon }}" data-title="{{ $stat->title }}"
                                                data-subtitle="{{ $stat->subtitle }}"
                                                data-is-active="{{ $stat->is_active }}" data-toggle="modal"
                                                data-target="#edit-stat-modal">
                                                <i class="fa fa-edit"></i> تعديل
                                            </button>

                                            <form class="d-inline"
                                                action="{{ route('admin.home-section.stats.destroy', $stat->id) }}"
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
                                        <td colspan="6" class="text-center">لا توجد إحصائيات مضافة بعد</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Stat Modal -->
    <div class="modal" id="add-stat-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">إضافة إحصائية جديدة</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('admin.home-section.stats.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="icon">الأيقونة (Font Awesome)</label>
                            <input type="text" class="form-control" id="icon" name="icon"
                                placeholder="fa fa-award">
                            <small class="form-text text-muted">يمكنك اختيار أيقونة من <a
                                    href="https://fontawesome.com/icons" target="_blank">هنا</a></small>
                        </div>
                        <div class="form-group">
                            <label for="title">العنوان</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="subtitle">العنوان الفرعي</label>
                            <input type="text" class="form-control" id="subtitle" name="subtitle">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="stat_is_active" name="is_active"
                                    value="1" checked>
                                <label class="custom-control-label" for="stat_is_active">تفعيل</label>
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

    <!-- Edit Stat Modal -->
    <div class="modal" id="edit-stat-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">تعديل الإحصائية</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form id="edit-stat-form" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_icon">الأيقونة (Font Awesome)</label>
                            <input type="text" class="form-control" id="edit_icon" name="icon">
                        </div>
                        <div class="form-group">
                            <label for="edit_title">العنوان</label>
                            <input type="text" class="form-control" id="edit_title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_subtitle">العنوان الفرعي</label>
                            <input type="text" class="form-control" id="edit_subtitle" name="subtitle">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit_stat_is_active"
                                    name="is_active" value="1">
                                <label class="custom-control-label" for="edit_stat_is_active">تفعيل</label>
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
            $('#stats-table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/ar.json'
                }
            });

            // Handle edit stat modal
            $('.edit-stat').click(function() {
                var id = $(this).data('id');
                var icon = $(this).data('icon');
                var title = $(this).data('title');
                var subtitle = $(this).data('subtitle');
                var isActive = $(this).data('is-active');

                $('#edit-stat-form').attr('action', '{{ route('admin.home-section.stats.update', '') }}/' +
                    id);
                $('#edit_icon').val(icon);
                $('#edit_title').val(title);
                $('#edit_subtitle').val(subtitle);
                $('#edit_stat_is_active').prop('checked', isActive == 1);
            });

            // Delete confirmation
            $('.delete-btn').click(function(e) {
                e.preventDefault();
                var form = $(this).closest('form');

                swal({
                    title: "هل أنت متأكد؟",
                    text: "لن تتمكن من استعادة هذه الإحصائية بعد حذفها!",
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
                            stats: itemsOrder
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
        });
    </script>
@endsection
