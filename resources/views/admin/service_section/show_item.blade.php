@extends('admin.layouts.master')

@section('title', 'عرض تفاصيل الخدمة')

@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets-admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets-admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets-admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets-admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets-admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets-admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">إدارة المحتوى</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ <a href="{{ route('admin.service-section.index') }}">قسم
                        الخدمات</a> / عرض الخدمة</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <a href="{{ route('admin.service-section.index') }}" class="btn btn-primary mr-2">
                <i class="mdi mdi-arrow-left ml-1"></i> عودة إلى القائمة
            </a>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">تفاصيل الخدمة</h4>
                        <div>
                            <a href="#" class="btn btn-sm btn-info" data-toggle="modal"
                                data-target="#edit-item-modal">
                                <i class="fa fa-edit"></i> تعديل
                            </a>
                            <form class="d-inline" action="{{ route('admin.service-section.items.destroy', $item->id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger delete-btn">
                                    <i class="fa fa-trash"></i> حذف
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mg-b-0 text-md-nowrap border">
                            <tbody>
                                <tr>
                                    <th class="border-bottom-0 bg-light" style="width: 200px;">الأيقونة</th>
                                    <td class="border-bottom-0">
                                        @if ($item->icon)
                                            <i class="{{ $item->icon }} fa-2x"></i>
                                            <span class="mr-2">{{ $item->icon }}</span>
                                        @else
                                            <span class="text-muted">غير محدد</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="border-bottom-0 bg-light">العنوان</th>
                                    <td class="border-bottom-0">{{ $item->title }}</td>
                                </tr>
                                <tr>
                                    <th class="border-bottom-0 bg-light">الوصف</th>
                                    <td class="border-bottom-0">{!! nl2br($item->description) !!}</td>
                                </tr>
                                <tr>
                                    <th class="border-bottom-0 bg-light">الصورة</th>
                                    <td class="border-bottom-0">
                                        @if ($item->image && Storage::disk('public')->exists($item->image))
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}"
                                                style="max-height: 200px;" class="img-fluid rounded">
                                        @else
                                            <span class="text-muted">لا توجد صورة</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="border-bottom-0 bg-light">الحالة</th>
                                    <td class="border-bottom-0">
                                        @if ($item->is_active)
                                            <span class="badge badge-success">مفعل</span>
                                        @else
                                            <span class="badge badge-danger">غير مفعل</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="border-bottom-0 bg-light">الترتيب</th>
                                    <td class="border-bottom-0">{{ $item->ordering }}</td>
                                </tr>
                                <tr>
                                    <th class="border-bottom-0 bg-light">تاريخ الإنشاء</th>
                                    <td class="border-bottom-0">{{ $item->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th class="border-bottom-0 bg-light">تاريخ آخر تحديث</th>
                                    <td class="border-bottom-0">{{ $item->updated_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal" id="edit-item-modal">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">تعديل الخدمة</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('admin.service-section.items.update', $item->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="title">العنوان</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        value="{{ $item->title }}" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="icon">الأيقونة (استخدم فئات Font Awesome أو Bootstrap Icons)</label>
                                    <input type="text" class="form-control" id="icon" name="icon"
                                        value="{{ $item->icon }}">
                                    <small class="text-muted">مثال: fab fa-laravel أو bi bi-code-square</small>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="description">الوصف</label>
                                    <textarea class="form-control" id="description" name="description" rows="4">{{ $item->description }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="image">الصورة</label>
                                    <input type="file" class="form-control" id="image" name="image"
                                        accept="image/*">
                                    @if ($item->image && Storage::disk('public')->exists($item->image))
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}"
                                                style="max-height: 100px;" class="img-fluid rounded">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
                                        {{ $item->is_active ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">تفعيل</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Edit Modal -->
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

    <!-- Sweet Alert -->
    <script src="{{ URL::asset('assets-admin/plugins/sweet-alert/sweetalert.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Delete confirmation
            $('.delete-btn').click(function(e) {
                e.preventDefault();
                var form = $(this).closest('form');

                swal({
                    title: "هل أنت متأكد؟",
                    text: "لن تتمكن من استعادة هذه الخدمة بعد حذفها!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "نعم، احذفها!",
                    cancelButtonText: "إلغاء",
                    closeOnConfirm: false
                }, function(isConfirm) {
                    if (isConfirm) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
