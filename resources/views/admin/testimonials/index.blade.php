@extends('admin.layouts.master')

@section('title', 'إدارة آراء العملاء')

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
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ آراء العملاء</span>
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
                        <h4 class="card-title mg-b-0">جميع آراء العملاء</h4>
                        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus fa-sm"></i> إضافة رأي جديد
                        </a>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mx-4 mt-3" role="alert">
                        <span>{{ session('success') }}</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم العميل</th>
                                    <th>المنصب</th>
                                    <th>الاقتباس</th>
                                    <th>التقييم</th>
                                    <th>الصورة</th>
                                    <th>الحالة</th>
                                    <th>الترتيب</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($testimonials as $t)
                                    <tr>
                                        <td>{{ $t->id }}</td>
                                        <td>{{ $t->customer_name }}</td>
                                        <td>{{ $t->customer_position }}</td>
                                        <td>{{ Str::limit($t->quote, 50) }}</td>
                                        <td>
                                            <div class="stars-display text-warning">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star{{ $i <= $t->stars ? '' : '-o text-muted' }}"></i>
                                                @endfor
                                                <span class="text-muted">({{ $t->stars }})</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($t->image)
                                                <img src="{{ asset('storage/' . $t->image) }}" width="50"
                                                    height="50" alt="صورة العميل" class="rounded">
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($t->is_active)
                                                <span class="badge badge-success">مفعل</span>
                                            @else
                                                <span class="badge badge-secondary">غير مفعل</span>
                                            @endif
                                        </td>
                                        <td>{{ $t->ordering }}</td>
                                        <td>
                                            <a href="{{ route('admin.testimonials.edit', $t->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i> تعديل
                                            </a>

                                            <form action="{{ route('admin.testimonials.destroy', $t->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger delete-btn">
                                                    <i class="fas fa-trash"></i> حذف
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">لا توجد آراء مضافة</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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
    <!--Internal  Sweet-Alert js-->
    <script src="{{ URL::asset('assets-admin/plugins/sweet-alert/sweetalert.min.js') }}"></script>

    <script>
        $(function() {
            // Initialize datatable
            $('#dataTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/ar.json'
                },
                paging: false,
                searching: true,
                ordering: true,
                info: false
            });

            // Delete confirmation
            $('.delete-btn').click(function(e) {
                e.preventDefault();
                var form = $(this).closest('form');

                swal({
                    title: "هل أنت متأكد؟",
                    text: "لن تتمكن من استعادة هذا الرأي بعد حذفه!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "نعم، احذفه!",
                    cancelButtonText: "لا، إلغاء!",
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    closeOnConfirm: false
                }, function() {
                    form.submit();
                });
            });
        });
    </script>
@endsection
