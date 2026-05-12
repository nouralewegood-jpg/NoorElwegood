@extends('admin.layouts.master')

@section('title', 'إدارة محتوى قسم الميزات')

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
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قسم الميزات</span>
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
                        <h4 class="card-title mg-b-0">إعدادات قسم الميزات</h4>
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

                    <form action="{{ route('admin.feature-section.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
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

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
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

    <!-- Features Items Section -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">عناصر قسم الميزات</h4>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-item-modal">
                            <i class="fa fa-plus"></i> إضافة ميزة جديدة
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="items-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>التبويب</th>
                                    <th>العنوان</th>
                                    <th>الأيقونة</th>
                                    <th>الصورة</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="sortable" data-url="{{ route('admin.feature-section.items.order') }}">
                                @forelse($items as $index => $item)
                                    <tr data-id="{{ $item->id }}">
                                        <td><i class="fa fa-bars handle"></i> {{ $index + 1 }}</td>
                                        <td>{{ $item->tab_name }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td><i class="{{ $item->icon }}"></i> {{ $item->icon }}</td>
                                        <td>
                                            @if ($item->image)
                                                <img src="{{ asset('storage/' . $item->image) }}"
                                                    alt="{{ $item->title }}" style="max-height: 50px;">
                                            @else
                                                <span class="text-muted">لا توجد صورة</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->is_active)
                                                <span class="badge badge-success">مفعل</span>
                                            @else
                                                <span class="badge badge-danger">غير مفعل</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-info edit-item" data-id="{{ $item->id }}"
                                                data-tab-name="{{ $item->tab_name }}" data-title="{{ $item->title }}"
                                                data-description="{{ $item->description }}"
                                                data-icon="{{ $item->icon }}"
                                                data-has-image="{{ $item->image ? '1' : '0' }}"
                                                data-image="{{ asset('storage/' . $item->image) }}"
                                                data-is-active="{{ $item->is_active }}" data-toggle="modal"
                                                data-target="#edit-item-modal">
                                                <i class="fa fa-edit"></i> تعديل
                                            </button>

                                            <form class="d-inline"
                                                action="{{ route('admin.feature-section.items.destroy', $item->id) }}"
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
                                        <td colspan="7" class="text-center">لا توجد عناصر مضافة بعد</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Item Modal -->
    <div class="modal fade" id="add-item-modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">إضافة ميزة جديدة</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('admin.feature-section.items.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tab_name">اسم التبويب</label>
                            <select class="form-control" id="tab_name" name="tab_name">
                                <option value="">اختر التبويب</option>
                                @foreach ($tabs as $tab)
                                    <option value="{{ $tab }}">{{ $tab }}</option>
                                @endforeach
                                <option value="new_tab_name">إضافة تبويب جديد</option>
                            </select>
                            <div id="new_tab_container" class="mt-2" style="display:none;">
                                <input type="text" class="form-control" id="new_tab_name" name="new_tab_name"
                                    placeholder="اسم التبويب الجديد">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="icon">الأيقونة (Font Awesome)</label>
                            <input type="text" class="form-control" id="icon" name="icon"
                                placeholder="fa fa-lightbulb">
                            <small class="form-text text-muted">يمكنك اختيار أيقونة من <a
                                    href="https://fontawesome.com/icons" target="_blank">هنا</a></small>
                        </div>
                        <div class="form-group">
                            <label for="title">العنوان</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="description">الوصف</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">الصورة</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="item_is_active" name="is_active"
                                    checked>
                                <label class="custom-control-label" for="item_is_active">تفعيل</label>
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

    <!-- Edit Item Modal -->
    <div class="modal fade" id="edit-item-modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">تعديل الميزة</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form id="edit-item-form" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_tab_name">اسم التبويب</label>
                            <input type="text" class="form-control" id="edit_tab_name" name="tab_name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_icon">الأيقونة (Font Awesome)</label>
                            <input type="text" class="form-control" id="edit_icon" name="icon">
                        </div>
                        <div class="form-group">
                            <label for="edit_title">العنوان</label>
                            <input type="text" class="form-control" id="edit_title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">الوصف</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_image">الصورة</label>
                            <input type="file" class="form-control" id="edit_image" name="image">
                            <div id="current_image_container" class="mt-2">
                                <img id="current_image" src="" alt="Current Image"
                                    style="max-height: 100px; display:none;">
                                <input type="hidden" id="current_image_path" name="current_image_path" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit_item_is_active"
                                    name="is_active" value="1">
                                <label class="custom-control-label" for="edit_item_is_active">تفعيل</label>
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
            $('#items-table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/ar.json'
                }
            });

            // Handle new tab name
            $('#tab_name').change(function() {
                if ($(this).val() === 'new_tab_name') {
                    $('#new_tab_container').show();
                } else {
                    $('#new_tab_container').hide();
                }
            });

            // Handle edit item modal
            $('.edit-item').click(function() {
                var id = $(this).data('id');
                var tabName = $(this).data('tab-name');
                var title = $(this).data('title');
                var description = $(this).data('description');
                var icon = $(this).data('icon');
                var hasImage = $(this).data('has-image') == '1';
                var image = $(this).data('image');
                var isActive = $(this).data('is-active');

                $('#edit-item-form').attr('action',
                    '{{ route('admin.feature-section.items.update', '') }}/' + id);
                $('#edit_tab_name').val(tabName);
                $('#edit_title').val(title);
                $('#edit_description').val(description);
                $('#edit_icon').val(icon);
                $('#edit_item_is_active').prop('checked', isActive == 1);

                if (hasImage) {
                    $('#current_image').attr('src', image).show();
                    // تخزين مسار الصورة الحالية
                    var originalPath = image.replace('{{ asset('storage/') }}/', '');
                    $('#current_image_path').val(originalPath);
                } else {
                    $('#current_image').hide();
                    $('#current_image_path').val('');
                }
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
                            items: itemsOrder
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
