@extends('admin.layouts.master')

@section('title', 'إدارة محتوى قسم التسعير')

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
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قسم التسعير</span>
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
                        <h4 class="card-title mg-b-0">إعدادات قسم التسعير</h4>
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

                    <form action="{{ route('admin.pricing-section.store') }}" method="POST">
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

    <!-- Pricing Plans Section -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">خطط الأسعار</h4>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-plan-modal">
                            <i class="fa fa-plus"></i> إضافة خطة جديدة
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="plans-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>العنوان</th>
                                    <th>السعر</th>
                                    <th>العملة</th>
                                    <th>فترة الدفع</th>
                                    <th>نص الزر</th>
                                    <th>رابط الزر</th>
                                    <th>الحالة</th>
                                    <th>الخطة المميزة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="sortable" data-url="{{ route('admin.pricing-section.plans.order') }}">
                                @forelse($plans as $index => $plan)
                                    <tr data-id="{{ $plan->id }}">
                                        <td><i class="fa fa-bars handle"></i> {{ $index + 1 }}</td>
                                        <td>{{ $plan->plan_name }}</td>
                                        <td>{{ $plan->price }}</td>
                                        <td>{{ $plan->currency }}</td>
                                        <td>{{ $plan->price_period }}</td>
                                        <td>{{ $plan->btn_text }}</td>
                                        <td>{{ $plan->btn_link }}</td>
                                        <td>
                                            @if ($plan->is_active)
                                                <span class="badge badge-success">مفعل</span>
                                            @else
                                                <span class="badge badge-danger">غير مفعل</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($plan->is_featured)
                                                <span class="badge badge-warning">مميزة</span>
                                            @else
                                                <span class="badge badge-light">عادية</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-info edit-plan" data-id="{{ $plan->id }}"
                                                data-title="{{ $plan->plan_name }}" data-price="{{ $plan->price }}"
                                                data-duration="{{ $plan->price_period }}"
                                                data-currency="{{ $plan->currency }}"
                                                data-btn-text="{{ $plan->btn_text }}" data-btn-url="{{ $plan->btn_link }}"
                                                data-is-active="{{ $plan->is_active }}"
                                                data-is-featured="{{ $plan->is_featured }}" data-toggle="modal"
                                                data-target="#edit-plan-modal">
                                                <i class="fa fa-edit"></i> تعديل
                                            </button>

                                            <a href="{{ route('admin.pricing-section.plans.show', $plan->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fa fa-list"></i> الميزات
                                            </a>

                                            <form class="d-inline"
                                                action="{{ route('admin.pricing-section.plans.destroy', $plan->id) }}"
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
                                        <td colspan="10" class="text-center">لا توجد خطط أسعار مضافة بعد</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Plan Modal -->
    <div class="modal fade" id="add-plan-modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">إضافة خطة تسعير جديدة</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form id="add-plan-form" action="{{ route('admin.pricing-section.plans.store') }}" method="POST"
                    autocomplete="off">
                    @csrf
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">عنوان الخطة</label>
                                    <input type="text" class="form-control" id="title" name="title" required
                                        maxlength="255" pattern="[^<>&]*" title="الرجاء إدخال نص خالٍ من الرموز الخاصة"
                                        oninput="this.value = this.value.replace(/[<>&]/g, '')">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">السعر</label>
                                    <input type="number" step="0.01" class="form-control" id="price"
                                        name="price" required min="0" max="100000">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="currency">العملة</label>
                                    <select class="form-control" id="currency" name="currency">
                                        <option value="ريال">ريال سعودي (ر.س)</option>
                                        <option value="درهم">درهم إماراتي (د.إ)</option>
                                        <option value="دينار">دينار كويتي (د.ك)</option>
                                        <option value="$">دولار أمريكي ($)</option>
                                        <option value="€">يورو (€)</option>
                                        <option value="جنيه">جنيه مصري (ج.م)</option>
                                        <option value="">بدون عملة</option>
                                        <option value="custom">عملة مخصصة</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 custom-currency-container d-none">
                                <div class="form-group">
                                    <label for="custom_currency">عملة مخصصة</label>
                                    <input type="text" class="form-control" id="custom_currency" maxlength="10"
                                        pattern="[^<>&]*" oninput="this.value = this.value.replace(/[<>&]/g, '')">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="duration">فترة الدفع</label>
                                    <input type="text" class="form-control" id="duration" name="duration"
                                        placeholder="شهرياً" maxlength="50" pattern="[^<>&]*"
                                        oninput="this.value = this.value.replace(/[<>&]/g, '')">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="btn_text">نص الزر</label>
                                    <input type="text" class="form-control" id="btn_text" name="btn_text"
                                        placeholder="ابدأ الآن" maxlength="50" pattern="[^<>&]*"
                                        oninput="this.value = this.value.replace(/[<>&]/g, '')">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="btn_url">رابط الزر</label>
                                    <input type="text" class="form-control" id="btn_url" name="btn_url"
                                        placeholder="#pricing" maxlength="255" pattern="[^<>]*"
                                        oninput="this.value = this.value.replace(/[<>]/g, '')">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="plan_is_active"
                                            name="is_active" checked>
                                        <label class="custom-control-label" for="plan_is_active">تفعيل الخطة</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_featured"
                                            name="is_featured">
                                        <label class="custom-control-label" for="is_featured">خطة مميزة</label>
                                    </div>
                                </div>
                            </div>
                            <!-- جهاز كشف الروبوت -->
                            <div class="col-md-12">
                                <div class="form-group d-none">
                                    <label for="honeypot">اترك هذا الحقل فارغًا</label>
                                    <input type="text" id="honeypot" name="honeypot" class="form-control">
                                </div>
                                <input type="hidden" name="security_token" value="{{ md5(uniqid(time(), true)) }}">
                                <input type="hidden" name="submission_time" value="{{ time() }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit" id="submit-plan-btn"
                            onclick="setTimeout(() => {this.disabled=true;},1)">حفظ</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Plan Modal -->
    <div class="modal fade" id="edit-plan-modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">تعديل خطة التسعير</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form id="edit-plan-form" action="" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_title">عنوان الخطة</label>
                                    <input type="text" class="form-control" id="edit_title" name="title" required
                                        maxlength="255" pattern="[^<>&]*" title="الرجاء إدخال نص خالٍ من الرموز الخاصة"
                                        oninput="this.value = this.value.replace(/[<>&]/g, '')">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_price">السعر</label>
                                    <input type="number" step="0.01" class="form-control" id="edit_price"
                                        name="price" required min="0" max="100000">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_currency">العملة</label>
                                    <select class="form-control" id="edit_currency" name="currency">
                                        <option value="ريال">ريال سعودي (ر.س)</option>
                                        <option value="درهم">درهم إماراتي (د.إ)</option>
                                        <option value="دينار">دينار كويتي (د.ك)</option>
                                        <option value="$">دولار أمريكي ($)</option>
                                        <option value="€">يورو (€)</option>
                                        <option value="جنيه">جنيه مصري (ج.م)</option>
                                        <option value="">بدون عملة</option>
                                        <option value="custom">عملة مخصصة</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 edit-custom-currency-container d-none">
                                <div class="form-group">
                                    <label for="edit_custom_currency">عملة مخصصة</label>
                                    <input type="text" class="form-control" id="edit_custom_currency" maxlength="10"
                                        pattern="[^<>&]*" oninput="this.value = this.value.replace(/[<>&]/g, '')">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_duration">فترة الدفع</label>
                                    <input type="text" class="form-control" id="edit_duration" name="duration"
                                        placeholder="شهرياً" maxlength="50" pattern="[^<>&]*"
                                        oninput="this.value = this.value.replace(/[<>&]/g, '')">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_btn_text">نص الزر</label>
                                    <input type="text" class="form-control" id="edit_btn_text" name="btn_text"
                                        placeholder="ابدأ الآن" maxlength="50" pattern="[^<>&]*"
                                        oninput="this.value = this.value.replace(/[<>&]/g, '')">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_btn_url">رابط الزر</label>
                                    <input type="text" class="form-control" id="edit_btn_url" name="btn_url"
                                        placeholder="#pricing" maxlength="255" pattern="[^<>]*"
                                        oninput="this.value = this.value.replace(/[<>]/g, '')">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="edit_plan_is_active"
                                            name="is_active" checked>
                                        <label class="custom-control-label" for="edit_plan_is_active">تفعيل الخطة</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="edit_is_featured"
                                            name="is_featured">
                                        <label class="custom-control-label" for="edit_is_featured">خطة مميزة</label>
                                    </div>
                                </div>
                            </div>
                            <!-- حماية إضافية -->
                            <div class="col-md-12">
                                <input type="hidden" name="security_token" value="{{ md5(uniqid(time(), true)) }}">
                                <input type="hidden" name="submission_time" value="{{ time() }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit" id="edit-submit-btn"
                            onclick="setTimeout(() => {this.disabled=true;},1)">تحديث</button>
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
            $('#plans-table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/ar.json'
                }
            });

            // Handle currency selection in add modal
            $('#currency').change(function() {
                if ($(this).val() === 'custom') {
                    $('.custom-currency-container').removeClass('d-none');
                } else {
                    $('.custom-currency-container').addClass('d-none');
                }
            });

            // Handle currency selection in edit modal
            $('#edit_currency').change(function() {
                if ($(this).val() === 'custom') {
                    $('.edit-custom-currency-container').removeClass('d-none');
                } else {
                    $('.edit-custom-currency-container').addClass('d-none');
                }
            });

            // Set custom currency input value to currency field before form submission
            $('#add-plan-form').submit(function() {
                if ($('#currency').val() === 'custom') {
                    $('#currency').val($('#custom_currency').val());
                }
            });

            // Set custom currency input value to currency field before form submission in edit form
            $('#edit-plan-form').submit(function() {
                if ($('#edit_currency').val() === 'custom') {
                    $('#edit_currency').val($('#edit_custom_currency').val());
                }
            });

            // Handle edit plan modal
            $('.edit-plan').click(function() {
                var id = $(this).data('id');
                var title = $(this).data('title');
                var price = $(this).data('price');
                var currency = $(this).data('currency');
                var duration = $(this).data('duration');
                var btnText = $(this).data('btn-text');
                var btnUrl = $(this).data('btn-url');
                var isActive = $(this).data('is-active');
                var isFeatured = $(this).data('is-featured');

                $('#edit-plan-form').attr('action',
                    '{{ route('admin.pricing-section.plans.update', '') }}/' + id);
                $('#edit_title').val(title);
                $('#edit_price').val(price);

                // Set the currency correctly in the dropdown or custom field
                var currencyFound = false;
                $('#edit_currency option').each(function() {
                    if ($(this).val() === currency) {
                        currencyFound = true;
                        return false; // break the loop
                    }
                });

                if (currencyFound) {
                    $('#edit_currency').val(currency);
                    $('.edit-custom-currency-container').addClass('d-none');
                } else if (currency) {
                    $('#edit_currency').val('custom');
                    $('#edit_custom_currency').val(currency);
                    $('.edit-custom-currency-container').removeClass('d-none');
                } else {
                    $('#edit_currency').val('');
                    $('.edit-custom-currency-container').addClass('d-none');
                }

                $('#edit_duration').val(duration);
                $('#edit_btn_text').val(btnText);
                $('#edit_btn_url').val(btnUrl);
                $('#edit_plan_is_active').prop('checked', isActive == 1);
                $('#edit_is_featured').prop('checked', isFeatured == 1);
            });

            // Delete confirmation
            $('.delete-btn').click(function(e) {
                e.preventDefault();
                var form = $(this).closest('form');

                swal({
                    title: "هل أنت متأكد؟",
                    text: "لن تتمكن من استعادة خطة التسعير هذه بعد حذفها!",
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
                    var plansOrder = [];
                    $('.sortable tbody tr').each(function() {
                        plansOrder.push($(this).data('id'));
                    });

                    // Send order to server
                    $.ajax({
                        url: $('.sortable').data('url'),
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            plans: plansOrder
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
