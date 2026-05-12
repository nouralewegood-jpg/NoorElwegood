@extends('admin.layouts.master')
@section('css')
    <!--  Owl-carousel css-->
    <link href="{{ URL::asset('assets-admin/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{ URL::asset('assets-admin/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">مرحباً بك في لوحة المشرف!</h2>
                <p class="mg-b-0">لوحة تحكم للمشرفين لإدارة المحتوى.</p>
            </div>
        </div>
        <div class="main-dashboard-header-right">
            <div>
                <label class="tx-13">تقييمات العملاء</label>
                <div class="main-star">
                    <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i
                        class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i
                        class="typcn typcn-star"></i> <span>(14,873)</span>
                </div>
            </div>
            <div>
                <label class="tx-13">المبيعات عبر الإنترنت</label>
                <h5>563,275</h5>
            </div>
            <div>
                <label class="tx-13">المبيعات الفعلية</label>
                <h5>783,675</h5>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-primary-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">إجمالي المحتوى</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">120</h4>
                                <p class="mb-0 tx-12 text-white op-7">مقارنة بالأسبوع الماضي</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="fas fa-arrow-circle-up text-white"></i>
                                <span class="text-white op-7"> +15</span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">التعليقات الجديدة</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">45</h4>
                                <p class="mb-0 tx-12 text-white op-7">مقارنة بالأسبوع الماضي</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="fas fa-arrow-circle-down text-white"></i>
                                <span class="text-white op-7"> -10%</span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">الزوار اليوميين</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">8,125</h4>
                                <p class="mb-0 tx-12 text-white op-7">مقارنة بالأسبوع الماضي</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="fas fa-arrow-circle-up text-white"></i>
                                <span class="text-white op-7"> +25%</span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
            </div>
        </div>
    </div>
    <!-- row closed -->

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-md-12 col-lg-12 col-xl-7">
            <div class="card">
                <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">حالة المحتوى</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 text-muted mb-0">متابعة حالة المحتوى وتحديثاته.</p>
                </div>
                <div class="card-body">
                    <div class="total-revenue">
                        <div>
                            <h4>98</h4>
                            <label><span class="bg-primary"></span>منشور</label>
                        </div>
                        <div>
                            <h4>32</h4>
                            <label><span class="bg-danger"></span>مراجعة</label>
                        </div>
                        <div>
                            <h4>12</h4>
                            <label><span class="bg-warning"></span>مسودة</label>
                        </div>
                    </div>
                    <div id="bar" class="sales-bar mt-4"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-5 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header pb-1">
                    <h3 class="card-title mb-2">آخر التعليقات</h3>
                    <p class="tx-12 mb-0 text-muted">آخر التعليقات التي تحتاج إلى مراجعة المشرفين</p>
                </div>
                <div class="card-body p-0 customers mt-1">
                    <div class="list-group list-lg-group list-group-flush">
                        <div class="list-group-item list-group-item-action">
                            <div class="media mt-0">
                                <img class="avatar-lg rounded-circle ml-3 my-auto"
                                    src="{{ URL::asset('assets-admin/img/faces/3.jpg') }}" alt="صورة المستخدم">
                                <div class="media-body">
                                    <div class="d-flex align-items-center">
                                        <div class="mt-0">
                                            <h5 class="mb-1 tx-15">سارة أحمد</h5>
                                            <p class="mb-0 tx-13 text-muted">خدمة رائعة ومتميزة، شكراً لكم!</p>
                                            <small class="text-muted">منذ 20 دقيقة</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item list-group-item-action">
                            <div class="media mt-0">
                                <img class="avatar-lg rounded-circle ml-3 my-auto"
                                    src="{{ URL::asset('assets-admin/img/faces/11.jpg') }}" alt="صورة المستخدم">
                                <div class="media-body">
                                    <div class="d-flex align-items-center">
                                        <div class="mt-1">
                                            <h5 class="mb-1 tx-15">محمد خالد</h5>
                                            <p class="mb-0 tx-13 text-muted">أتمنى أن تضيفوا المزيد من الخيارات في المستقبل
                                            </p>
                                            <small class="text-muted">منذ ساعة</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item list-group-item-action">
                            <div class="media mt-0">
                                <img class="avatar-lg rounded-circle ml-3 my-auto"
                                    src="{{ URL::asset('assets-admin/img/faces/17.jpg') }}" alt="صورة المستخدم">
                                <div class="media-body">
                                    <div class="d-flex align-items-center">
                                        <div class="mt-1">
                                            <h5 class="mb-1 tx-15">نورا سامي</h5>
                                            <p class="mb-0 tx-13 text-muted">تجربة سيئة للغاية، لم أجد ما أبحث عنه!</p>
                                            <small class="text-muted">منذ 3 ساعات</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets-admin/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Moment js -->
    <script src="{{ URL::asset('assets-admin/plugins/raphael/raphael.min.js') }}"></script>
    <!--Internal  Flot js-->
    <script src="{{ URL::asset('assets-admin/plugins/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/jquery.flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/jquery.flot/jquery.flot.categories.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/js/dashboard.sampledata.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/js/chart.flot.sampledata.js') }}"></script>
    <!--Internal Apexchart js-->
    <script src="{{ URL::asset('assets-admin/js/apexcharts.js') }}"></script>
    <!-- Internal Map -->
    <script src="{{ URL::asset('assets-admin/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/js/modal-popup.js') }}"></script>
    <!--Internal  index js -->
    <script src="{{ URL::asset('assets-admin/js/index.js') }}"></script>
    <script src="{{ URL::asset('assets-admin/js/jquery.vmap.sampledata.js') }}"></script>
@endsection
