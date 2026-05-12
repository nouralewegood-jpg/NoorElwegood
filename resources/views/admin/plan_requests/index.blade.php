@extends('admin.layouts.master')

@section('title', 'إدارة طلبات الخطط')

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
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">إدارة المحتوى</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ طلبات الخطط</span>
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
                        <h4 class="card-title mg-b-0">قائمة طلبات الخطط</h4>
                        <div class="btn-group">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-expanded="false">
                                الإجراءات الجماعية <i class="fas fa-caret-down"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item bulk-action" data-action="mark_in_progress" href="#"><i
                                        class="far fa-clock text-info"></i> تحديد كـ "قيد المعالجة"</a>
                                <a class="dropdown-item bulk-action" data-action="mark_completed" href="#"><i
                                        class="fas fa-check-circle text-success"></i> تحديد كـ "مكتمل"</a>
                                <a class="dropdown-item bulk-action" data-action="mark_cancelled" href="#"><i
                                        class="fas fa-ban text-danger"></i> تحديد كـ "ملغي"</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger bulk-action" data-action="delete" href="#"><i
                                        class="fas fa-trash-alt"></i> حذف المحدد</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form id="bulk-action-form" action="{{ route('admin.plan-requests.bulk-update') }}" method="post">
                        @csrf
                        <input type="hidden" name="action" id="bulk-action-input">

                        <div class="table-responsive">
                            <table class="table text-md-nowrap" id="requests-table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select-all"></th>
                                        <th>الرقم</th>
                                        <th>اسم العميل</th>
                                        <th>رقم الهاتف</th>
                                        <th>الدولة</th>
                                        <th>الخطة</th>
                                        <th>السعر</th>
                                        <th>الحالة</th>
                                        <th>تاريخ الطلب</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($planRequests as $request)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="ids[]" value="{{ $request->id }}"
                                                    class="select-item">
                                            </td>
                                            <td>{{ $request->id }}</td>
                                            <td>{{ $request->client_name }}</td>
                                            <td>{{ $request->country_code }} {{ $request->phone_number }}</td>
                                            <td>{{ $request->country }}</td>
                                            <td>{{ $request->plan_name }}</td>
                                            <td>{{ $request->plan_price }}</td>
                                            <td>
                                                <span class="badge badge-{{ $request->getStatusColor() }}">
                                                    {{ $request->getStatusText() }}
                                                </span>
                                            </td>
                                            <td>{{ $request->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.plan-requests.show', $request->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-danger delete-btn"
                                                        data-id="{{ $request->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    <a href="https://wa.me/{{ $request->getFullPhoneNumber() }}"
                                                        target="_blank" class="btn btn-sm btn-success">
                                                        <i class="fab fa-whatsapp"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            {{ $planRequests->links() }}
                        </div>
                    </form>

                    <!-- Delete Form -->
                    <form id="delete-form" action="" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
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
    <script>
        $(document).ready(function() {
            // تحديد الكل
            $('#select-all').on('click', function() {
                $('.select-item').prop('checked', $(this).prop('checked'));
            });

            // التحقق من اختيار أي عناصر عند النقر على الإجراءات الجماعية
            $('.bulk-action').on('click', function(e) {
                e.preventDefault();

                // التحقق من اختيار أي عناصر
                if ($('.select-item:checked').length === 0) {
                    swal({
                        title: "تنبيه",
                        text: "الرجاء اختيار عنصر واحد على الأقل",
                        type: "warning",
                        confirmButtonText: "موافق"
                    });
                    return;
                }

                const action = $(this).data('action');
                let confirmMessage = '';
                let confirmButtonText = 'نعم، متأكد';

                switch (action) {
                    case 'mark_in_progress':
                        confirmMessage = 'هل أنت متأكد من تحديث حالة الطلبات المختارة إلى "قيد المعالجة"؟';
                        break;
                    case 'mark_completed':
                        confirmMessage = 'هل أنت متأكد من تحديث حالة الطلبات المختارة إلى "مكتمل"؟';
                        break;
                    case 'mark_cancelled':
                        confirmMessage = 'هل أنت متأكد من تحديث حالة الطلبات المختارة إلى "ملغي"؟';
                        break;
                    case 'delete':
                        confirmMessage = 'هل أنت متأكد من حذف الطلبات المختارة نهائياً؟';
                        confirmButtonText = 'نعم، احذف';
                        break;
                }

                swal({
                    title: "تأكيد",
                    text: confirmMessage,
                    type: action === 'delete' ? 'warning' : 'info',
                    showCancelButton: true,
                    confirmButtonColor: action === 'delete' ? '#d33' : '#3085d6',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: confirmButtonText,
                    cancelButtonText: 'إلغاء',
                }, function(isConfirm) {
                    if (isConfirm) {
                        $('#bulk-action-input').val(action);
                        $('#bulk-action-form').submit();
                    }
                });
            });

            // حذف طلب محدد
            $('.delete-btn').on('click', function(e) {
                e.preventDefault();

                const id = $(this).data('id');

                swal({
                    title: "هل أنت متأكد؟",
                    text: "سيتم حذف هذا الطلب نهائياً!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'نعم، احذف!',
                    cancelButtonText: 'إلغاء'
                }, function(isConfirm) {
                    if (isConfirm) {
                        const form = $('#delete-form');
                        form.attr('action', '/admin/plan-requests/' + id);
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
