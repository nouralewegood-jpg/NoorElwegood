@extends('admin.layouts.master')

@section('title', 'إدارة محتوى قسم الخدمات')

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
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قسم الخدمات</span>
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
                        <h4 class="card-title mg-b-0">إعدادات قسم الخدمات</h4>
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

                    <form action="{{ route('admin.service-section.store') }}" method="POST" enctype="multipart/form-data">
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

    <!-- Services Items Section -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">الخدمات المتاحة</h4>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-service-modal">
                            <i class="fa fa-plus"></i> إضافة خدمة جديدة
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="services-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الأيقونة</th>
                                    <th>العنوان</th>
                                    <th>الصورة</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="sortable" data-url="{{ route('admin.service-section.items.order') }}">
                                @forelse($items as $index => $service)
                                    <tr data-id="{{ $service->id }}">
                                        <td><i class="fa fa-bars handle"></i> {{ $index + 1 }}</td>
                                        <td><i class="{{ $service->icon }}"></i> {{ $service->icon }}</td>
                                        <td>{{ $service->title }}</td>
                                        <td>
                                            @if ($service->image)

                                                @php
                                                    $imagePath = $service->image;
                                                    $imageUrl1 = asset('storage/' . $imagePath);
                                                @endphp
                                                <!-- محاولات متعددة لعرض الصورة -->
                                                <img src="{{$imageUrl1}}" alt="{{ $service->title }}"
                                                    style="max-height: 50px; max-width: 100px; object-fit: contain;"
                                                    onerror="this.onerror=null; this.src='{{ $imageUrl1 }}'; this.alt='محاولة 2'">
                                            @else
                                                <span class="text-muted">لا توجد صورة</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($service->is_active)
                                                <span class="badge badge-success">مفعل</span>
                                            @else
                                                <span class="badge badge-danger">غير مفعل</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.service-section.items.show', $service->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fa fa-eye"></i> تفاصيل
                                            </a>

                                            <button class="btn btn-sm btn-info edit-service" data-id="{{ $service->id }}"
                                                data-title="{{ $service->title }}"
                                                data-description="{{ $service->description }}"
                                                data-icon="{{ $service->icon }}"
                                                data-short-description="{{ $service->short_description }}"
                                                data-has-image="{{ $service->image ? '1' : '0' }}"
                                                data-image="{{ $service->image ? url('storage/' . $service->image) : '' }}"
                                                data-is-active="{{ $service->is_active }}" data-toggle="modal"
                                                data-target="#edit-service-modal">
                                                <i class="fa fa-edit"></i> تعديل
                                            </button>

                                            <form class="d-inline"
                                                action="{{ route('admin.service-section.items.destroy', $service->id) }}"
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
                                        <td colspan="6" class="text-center">لا توجد خدمات مضافة بعد</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Service Modal -->
    <div class="modal fade" id="add-service-modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">إضافة خدمة جديدة</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('admin.service-section.items.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">العنوان</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="short_description">وصف مختصر</label>
                            <textarea class="form-control" id="short_description" name="short_description" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="description">الوصف التفصيلي</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="icon">الأيقونة (Font Awesome)</label>
                            <input type="text" class="form-control" id="icon" name="icon"
                                placeholder="fa fa-cog">
                            <small class="form-text text-muted">يمكنك اختيار أيقونة من <a
                                    href="https://fontawesome.com/icons" target="_blank">هنا</a></small>
                        </div>
                        <div class="form-group">
                            <label for="image">الصورة</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="service_is_active"
                                    name="is_active" checked>
                                <label class="custom-control-label" for="service_is_active">تفعيل</label>
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

    <!-- Edit Service Modal -->
    <div class="modal fade" id="edit-service-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">تعديل الخدمة</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="edit-service-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_title">العنوان</label>
                            <input type="text" class="form-control" id="edit_title" name="title" required>
                        </div>

                        <div class="form-group">
                            <label for="edit_short_description">وصف مختصر</label>
                            <textarea class="form-control" id="edit_short_description" name="short_description" rows="2"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="edit_description">الوصف التفصيلي</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="edit_icon">الأيقونة (Font Awesome)</label>
                            <input type="text" class="form-control" id="edit_icon" name="icon">
                        </div>

                        <div class="form-group">
                            <label for="edit_image">الصورة</label>
                            <input type="file" class="form-control" id="edit_image" name="image">
                            <div id="current_image_container" class="mt-2">
                                <img id="current_image" src="" alt="Current Image"
                                    style="max-height:100px; object-fit: contain; display:none;"
                                    onerror="this.onerror=null; this.src='{{ asset('assets-admin/img/no-image.png') }}'; this.alt='صورة غير متوفرة'">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit_service_is_active"
                                    name="is_active" value="1">
                                <label class="custom-control-label" for="edit_service_is_active">تفعيل</label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">حفظ التعديلات</button>
                        <button class="btn ripple btn-secondary" type="button" data-dismiss="modal">إلغاء</button>
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
            $('#services-table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/ar.json'
                }
            });

            // JavaScript: Handle edit service modal
            $('.edit-service').click(function() {
                var id = $(this).data('id');

                // ضبّط action للفورم ليطابق الراوت: PUT service-section/items/{item}
                $('#edit-service-form').attr('action',
                    '{{ route('admin.service-section.items.update', '') }}/' + id);

                // عبّي حقول النصائح
                $('#edit_title').val($(this).data('title'));
                $('#edit_short_description').val($(this).data('short-description'));
                $('#edit_description').val($(this).data('description'));
                $('#edit_icon').val($(this).data('icon'));

                // حالة التفعيل
                var isActive = $(this).data('is-active') == 1;
                $('#edit_service_is_active').prop('checked', isActive);

                // عرض أو إخفاء الصورة الحالية
                if ($(this).data('has-image') == 1) {
                    $('#current_image').attr('src', $(this).data('image')).show();
                } else {
                    $('#current_image').hide();
                }
            });

            // Delete confirmation
            $('.delete-btn').click(function(e) {
                e.preventDefault();
                var form = $(this).closest('form');

                swal({
                    title: "هل أنت متأكد؟",
                    text: "لن تتمكن من استعادة هذه الخدمة بعد حذفها!",
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
                            services: itemsOrder
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
