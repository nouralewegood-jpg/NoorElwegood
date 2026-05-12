@extends('admin.layouts.master')

@section('title', 'تفاصيل خطة التسعير')

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
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قسم التسعير / خطة التسعير</span>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.pricing-section.index') }}" class="btn btn-primary">
                <i class="fa fa-arrow-right ml-2"></i> العودة إلى قائمة الخطط
            </a>
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
                        <h4 class="card-title mg-b-0">تفاصيل خطة التسعير "{{ $plan->plan_name }}"</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>اسم الخطة:</strong> {{ $plan->plan_name }}</p>
                            <p><strong>السعر:</strong> {{ $plan->currency }} {{ $plan->price }}</p>
                            <p><strong>فترة الدفع:</strong> {{ $plan->price_period }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>نص الزر:</strong> {{ $plan->btn_text }}</p>
                            <p><strong>رابط الزر:</strong> {{ $plan->btn_link }}</p>
                            <p><strong>الحالة:</strong>
                                @if ($plan->is_active)
                                    <span class="badge badge-success">مفعلة</span>
                                @else
                                    <span class="badge badge-danger">غير مفعلة</span>
                                @endif
                            </p>
                            <p><strong>خطة مميزة:</strong>
                                @if ($plan->is_featured)
                                    <span class="badge badge-warning">مميزة</span>
                                @else
                                    <span class="badge badge-light">عادية</span>
                                @endif
                            </p>
                        </div>
                    </div>
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
                        <h4 class="card-title mg-b-0">ميزات الخطة</h4>
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
                                    <th>مضمنة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="sortable"
                                data-url="{{ route('admin.pricing-section.plans.features.order', $plan->id) }}">
                                @forelse($features as $index => $feature)
                                    <tr data-id="{{ $feature->id }}">
                                        <td><i class="fa fa-bars handle"></i> {{ $index + 1 }}</td>
                                        <td>{{ $feature->feature_text }}</td>
                                        <td>
                                            @if ($feature->is_included)
                                                <span class="badge badge-success">مضمنة</span>
                                            @else
                                                <span class="badge badge-danger">غير مضمنة</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-info edit-feature" data-toggle="modal"
                                                data-target="#edit-feature-modal" data-id="{{ $feature->id }}"
                                                data-feature-text="{{ $feature->feature_text }}"
                                                data-is-included="{{ $feature->is_included }}">
                                                <i class="fa fa-edit"></i> تعديل
                                            </button>

                                            <form class="d-inline"
                                                action="{{ route('admin.pricing-section.plans.features.destroy', ['plan' => $plan->id, 'feature' => $feature->id]) }}"
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
                                        <td colspan="4" class="text-center">لا توجد ميزات مضافة لهذه الخطة بعد</td>
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
    <div class="modal fade" id="add-feature-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">إضافة ميزة جديدة للخطة</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('admin.pricing-section.plans.features.store', $plan->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="feature_text">نص الميزة</label>
                            <input type="text" class="form-control" id="feature_text" name="feature_text" required>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_included" name="is_included"
                                    checked>
                                <label class="custom-control-label" for="is_included">الميزة مضمنة في الخطة</label>
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
    <div class="modal fade" id="edit-feature-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">تعديل ميزة الخطة</h6>
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
                                <input type="checkbox" class="custom-control-input" id="edit_is_included"
                                    name="is_included">
                                <label class="custom-control-label" for="edit_is_included">الميزة مضمنة في الخطة</label>
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
                var featureText = $(this).data('feature-text');
                var isIncluded = $(this).data('is-included');

                $('#edit-feature-form').attr('action',
                    '{{ route('admin.pricing-section.plans.features.update', ['plan' => $plan->id, 'feature' => ':feature_id']) }}'
                    .replace(':feature_id', id));
                $('#edit_feature_text').val(featureText);
                $('#edit_is_included').prop('checked', isIncluded == 1);
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
                    var featuresOrder = [];
                    $('.sortable tbody tr').each(function() {
                        featuresOrder.push($(this).data('id'));
                    });

                    // Send order to server
                    $.ajax({
                        url: $('.sortable').data('url'),
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            features: featuresOrder
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
