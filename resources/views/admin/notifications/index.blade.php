@extends('admin.layouts.master')

@section('title')
    الإشعارات
@endsection

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
                <h4 class="content-title mb-0 my-auto">الإشعارات</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ جميع الإشعارات</span>
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
                        <h4 class="card-title mg-b-0">قائمة الإشعارات</h4>
                        <button class="btn btn-primary btn-sm" id="mark-all-notifications-read">تمييز الكل كمقروء</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="notifications-table">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">النوع</th>
                                    <th class="border-bottom-0">التفاصيل</th>
                                    <th class="border-bottom-0">الوقت</th>
                                    <th class="border-bottom-0">الحالة</th>
                                    <th class="border-bottom-0">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- طلبات الخطط -->
                                @php
                                    $newPlanRequests = App\Models\PlanRequest::where('status', 'new')->latest()->get();
                                @endphp

                                @foreach ($newPlanRequests as $index => $request)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><span class="badge badge-success">طلب خطة</span></td>
                                        <td>
                                            <strong>{{ $request->name }}</strong> -
                                            {{ $request->plan ? $request->plan->name : 'خطة غير محددة' }}
                                        </td>
                                        <td>{{ $request->created_at->diffForHumans() }}</td>
                                        <td><span class="badge badge-warning">جديد</span></td>
                                        <td>
                                            <a href="{{ route('admin.plan-requests.show', $request->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="las la-eye"></i> عرض
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                <!-- أسئلة الشات بوت -->
                                @php
                                    $chatbotQuestions = App\Models\ChatbotUnansweredQuestion::where('status', 'pending')
                                        ->latest()
                                        ->get();
                                @endphp

                                @foreach ($chatbotQuestions as $index => $question)
                                    <tr>
                                        <td>{{ count($newPlanRequests) + $index + 1 }}</td>
                                        <td><span class="badge badge-info">سؤال شات بوت</span></td>
                                        <td>{{ $question->question }}</td>
                                        <td>{{ $question->created_at->diffForHumans() }}</td>
                                        <td><span class="badge badge-warning">معلق</span></td>
                                        <td>
                                            <a href="{{ route('admin.chatbot-questions.index') }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="las la-eye"></i> عرض
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                @if (count($newPlanRequests) == 0 && count($chatbotQuestions) == 0)
                                    <tr>
                                        <td colspan="6" class="text-center">لا توجد إشعارات حالياً</td>
                                    </tr>
                                @endif
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
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#notifications-table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json'
                }
            });

            // تمييز جميع الإشعارات كمقروءة
            $('#mark-all-notifications-read').on('click', function() {
                $.ajax({
                    url: '{{ route('admin.notifications.mark-all-read') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        toastr.success('تم تمييز جميع الإشعارات كمقروءة');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }
                });
            });
        });
    </script>
@endsection
