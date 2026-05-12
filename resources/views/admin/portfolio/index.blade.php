@extends('admin.layouts.master')


@section('title', 'إدارة معرض الأعمال')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>إدارة معرض الأعمال</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item active">معرض الأعمال</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">قائمة الأعمال</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.portfolio.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> إضافة عمل جديد
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (count($portfolios) > 0)
                            <div class="table-responsive">
                                <table id="portfolios-table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%">الترتيب</th>
                                            <th width="10%">الصورة</th>
                                            <th width="20%">العنوان</th>
                                            <th width="15%">التصنيف</th>
                                            <th width="15%">تاريخ المشروع</th>
                                            <th width="10%">مميز</th>
                                            <th width="10%">الحالة</th>
                                            <th width="15%">الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sortable-portfolio">
                                        @foreach ($portfolios as $portfolio)
                                            <tr data-id="{{ $portfolio->id }}">
                                                <td class="handle text-center">
                                                    <i class="fas fa-arrows-alt"></i>
                                                    <span class="sr-only">{{ $portfolio->display_order }}</span>
                                                </td>
                                                <td>
                                                    @if ($portfolio->image)
                                                        <img src="{{ $portfolio->image_url }}" alt="{{ $portfolio->title }}"
                                                            class="img-thumbnail" width="80">
                                                    @else
                                                        <span class="badge badge-secondary">لا توجد صورة</span>
                                                    @endif
                                                </td>
                                                <td>{{ $portfolio->title }}</td>
                                                <td>{{ $portfolio->category ?? 'غير محدد' }}</td>
                                                <td>{{ $portfolio->project_date ? $portfolio->project_date->format('Y-m-d') : 'غير محدد' }}
                                                </td>
                                                <td class="text-center">
                                                    @if ($portfolio->is_featured)
                                                        <span class="badge badge-success">مميز</span>
                                                    @else
                                                        <span class="badge badge-secondary">غير مميز</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($portfolio->active)
                                                        <span class="badge badge-success">نشط</span>
                                                    @else
                                                        <span class="badge badge-danger">غير نشط</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.portfolio.show', $portfolio->id) }}"
                                                        class="btn btn-info btn-sm" title="عرض">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.portfolio.edit', $portfolio->id) }}"
                                                        class="btn btn-primary btn-sm" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target="#deleteModal{{ $portfolio->id }}" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>

                                                    <!-- Modal Delete -->
                                                    <div class="modal fade" id="deleteModal{{ $portfolio->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="deleteModalLabel{{ $portfolio->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="deleteModalLabel{{ $portfolio->id }}">تأكيد
                                                                        الحذف</h5>
                                                                    <button type="button" class="close ml-0"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>هل أنت متأكد من رغبتك في حذف العمل:
                                                                        <strong>{{ $portfolio->title }}</strong>؟</p>
                                                                    <p class="text-danger"><small>سيتم حذف جميع الصور
                                                                            المرتبطة بهذا العمل.</small></p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form
                                                                        action="{{ route('admin.portfolio.destroy', $portfolio->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">إلغاء</button>
                                                                        <button type="submit"
                                                                            class="btn btn-danger">حذف</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                لا توجد أعمال مضافة بعد. <a href="{{ route('admin.portfolio.create') }}">إضافة عمل جديد</a>
                            </div>
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets-admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets-admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <style>
        #sortable-portfolio .handle {
            cursor: move;
        }

        .ui-sortable-helper {
            display: table;
            background: #f9f9f9;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('assets-admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets-admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets-admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets-admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script>
        $(function() {
            // إعداد جدول البيانات
            $('#portfolios-table').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false, // تعطيل الترتيب لكي نستخدم الترتيب السحب والإفلات
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "language": {
                    "url": "{{ asset('assets-admin/plugins/datatables/ar.json') }}"
                }
            });

            // تفعيل خاصية السحب والإفلات
            $("#sortable-portfolio").sortable({
                items: "tr",
                cursor: "move",
                opacity: 0.6,
                handle: ".handle",
                update: function() {
                    updatePortfolioOrder();
                }
            });

            // تحديث ترتيب معرض الأعمال
            function updatePortfolioOrder() {
                var order = [];
                $('#sortable-portfolio tr').each(function(index, element) {
                    order.push({
                        id: $(this).attr('data-id'),
                        position: index + 1
                    });
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.portfolio.order') }}",
                    data: {
                        order: order,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success('تم تحديث ترتيب معرض الأعمال بنجاح');
                        } else {
                            toastr.error('حدث خطأ أثناء تحديث الترتيب');
                        }
                    }
                });
            }
        });
    </script>
@endsection
