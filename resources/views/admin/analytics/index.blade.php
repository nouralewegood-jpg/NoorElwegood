@extends('admin.layouts.master')
@section('title', 'تحليلات الزيارات')

@section('css')
    <style>
        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        .map-container {
            height: 400px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets-admin/plugins/chart.js/Chart.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid mt-5">
        <!-- Page Header -->
        <div class="page-header mb-3">
            <div>
                <h2 class="main-content-title tx-24 mg-b-5">تحليلات الزيارات</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                    <li class="breadcrumb-item active">تحليلات الزيارات</li>
                </ol>
            </div>
            <div class="d-flex">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="exportDropdown"
                        data-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-download ml-1"></i> تصدير
                    </button>
                    <div class="dropdown-menu" aria-labelledby="exportDropdown">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#exportModal">تصدير CSV</a>
                    </div>
                </div>
                <a href="{{ route('admin.analytics.settings') }}" class="btn btn-outline-primary mr-2">
                    <i class="fas fa-cog ml-1"></i> الإعدادات
                </a>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- ملخص الإحصائيات -->
        <div class="row row-sm">
            <div class="col-lg-3 col-md-6">
                <div class="card stat-card bg-primary-transparent">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="mb-3">إجمالي الزيارات</h6>
                                <h3 class="mb-0">{{ number_format($totalVisits) }}</h3>
                            </div>
                            <div>
                                <span class="round-icon bg-primary-light"><i
                                        class="fas fa-chart-line text-primary"></i></span>
                            </div>
                        </div>
                        <p class="mb-0 text-muted"><i class="fas fa-users mr-1"></i> زيارة للموقع</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card stat-card bg-success-transparent">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="mb-3">الزيارات الفريدة</h6>
                                <h3 class="mb-0">{{ number_format($uniqueVisits) }}</h3>
                            </div>
                            <div>
                                <span class="round-icon bg-success-light"><i
                                        class="fas fa-user-check text-success"></i></span>
                            </div>
                        </div>
                        <p class="mb-0 text-muted"><i class="fas fa-fingerprint mr-1"></i> زائر فريد</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card stat-card bg-warning-transparent">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="mb-3">معدل الارتداد</h6>
                                <h3 class="mb-0">{{ $bounceRate }}%</h3>
                            </div>
                            <div>
                                <span class="round-icon bg-warning-light"><i
                                        class="fas fa-sign-out-alt text-warning"></i></span>
                            </div>
                        </div>
                        <p class="mb-0 text-muted"><i class="fas fa-undo mr-1"></i> من إجمالي الزيارات</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card stat-card bg-info-transparent">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="mb-3">زيارات اليوم</h6>
                                <h3 class="mb-0">{{ number_format($totalVisitorsToday) }}</h3>
                            </div>
                            <div>
                                <span class="round-icon bg-info-light"><i class="fas fa-calendar-day text-info"></i></span>
                            </div>
                        </div>
                        <p class="mb-0 text-muted"><i class="fas fa-clock mr-1"></i> زيارة اليوم</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- مخطط الزيارات -->
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">تحليل الزيارات خلال الـ 30 يوم الأخيرة</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="visitsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- تحليلات حسب الدول والأجهزة -->
        <div class="row row-sm">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">الزيارات حسب الدول</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($visitorsByCountry->isEmpty())
                            <div class="text-center p-4">
                                <i class="fas fa-globe fa-4x text-muted mb-3"></i>
                                <h5>لا توجد بيانات متاحة</h5>
                                <p class="text-muted">سيتم عرض توزيع الزيارات حسب الدول هنا عند توفر البيانات.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover mg-b-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الدولة</th>
                                            <th>عدد الزيارات</th>
                                            <th>النسبة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($visitorsByCountry as $index => $country)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $country->country ?? 'غير معروف' }}</td>
                                                <td>{{ number_format($country->total) }}</td>
                                                <td>{{ round(($country->total / $totalVisits) * 100, 1) }}%</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">الزيارات حسب نوع الجهاز</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($visitorsByDevice->isEmpty())
                            <div class="text-center p-4">
                                <i class="fas fa-mobile-alt fa-4x text-muted mb-3"></i>
                                <h5>لا توجد بيانات متاحة</h5>
                                <p class="text-muted">سيتم عرض توزيع الزيارات حسب نوع الجهاز هنا عند توفر البيانات.</p>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-md-7">
                                    <canvas id="deviceChart" height="240"></canvas>
                                </div>
                                <div class="col-md-5">
                                    <div class="mt-4">
                                        @foreach ($visitorsByDevice as $device)
                                            <div class="mb-3">
                                                <h6>{{ ucfirst($device->device_type ?? 'غير معروف') }}</h6>
                                                <div class="progress">
                                                    @php
                                                        $percent = ($device->total / $totalVisits) * 100;
                                                        $color = '';
                                                        if ($device->device_type == 'mobile') {
                                                            $color = 'primary';
                                                        } elseif ($device->device_type == 'tablet') {
                                                            $color = 'info';
                                                        } elseif ($device->device_type == 'desktop') {
                                                            $color = 'success';
                                                        } else {
                                                            $color = 'secondary';
                                                        }
                                                    @endphp
                                                    <div class="progress-bar bg-{{ $color }}" role="progressbar"
                                                        style="width: {{ $percent }}%">{{ round($percent, 1) }}%
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- الصفحات الأكثر زيارة والمتصفحات -->
        <div class="row row-sm">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">الصفحات الأكثر زيارة</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($topPages->isEmpty())
                            <div class="text-center p-4">
                                <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
                                <h5>لا توجد بيانات متاحة</h5>
                                <p class="text-muted">سيتم عرض الصفحات الأكثر زيارة هنا عند توفر البيانات.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover mg-b-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>عنوان الصفحة</th>
                                            <th>الرابط</th>
                                            <th>عدد الزيارات</th>
                                            <th>النسبة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topPages as $index => $page)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $page->page_title ?? 'بدون عنوان' }}</td>
                                                <td>
                                                    <a href="{{ $page->page_url }}" target="_blank"
                                                        class="text-truncate d-inline-block" style="max-width: 200px;">
                                                        {{ \Illuminate\Support\Str::limit(str_replace(url('/'), '', $page->page_url), 50) }}
                                                    </a>
                                                </td>
                                                <td>{{ number_format($page->total) }}</td>
                                                <td>{{ round(($page->total / $totalVisits) * 100, 1) }}%</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title">أهم المتصفحات</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($visitorsByBrowser->isEmpty())
                            <div class="text-center p-4">
                                <i class="fas fa-browser fa-4x text-muted mb-3"></i>
                                <h5>لا توجد بيانات متاحة</h5>
                                <p class="text-muted">سيتم عرض توزيع المتصفحات هنا عند توفر البيانات.</p>
                            </div>
                        @else
                            <canvas id="browserChart" height="260"></canvas>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal تصدير البيانات -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">تصدير بيانات التحليلات</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.analytics.export') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="start_date">من تاريخ</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="form-group">
                            <label for="end_date">إلى تاريخ</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">تصدير CSV</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets-admin/plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        $(function() {
            // Set default dates for export modal
            const today = new Date();
            const thirtyDaysAgo = new Date(today);
            thirtyDaysAgo.setDate(today.getDate() - 30);

            document.getElementById('start_date').value = thirtyDaysAgo.toISOString().substr(0, 10);
            document.getElementById('end_date').value = today.toISOString().substr(0, 10);

            // Chart: Visits Over Time
            const visitsCtx = document.getElementById('visitsChart').getContext('2d');
            new Chart(visitsCtx, {
                type: 'line',
                data: {
                    labels: @json($last30Days->pluck('label')),
                    datasets: [{
                        label: 'عدد الزيارات',
                        data: @json($last30Days->pluck('visits')),
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        borderColor: 'rgba(13, 110, 253, 1)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgba(13, 110, 253, 1)',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });

            @if (!$visitorsByDevice->isEmpty())
                // Chart: Devices
                const deviceCtx = document.getElementById('deviceChart').getContext('2d');
                new Chart(deviceCtx, {
                    type: 'doughnut',
                    data: {
                        labels: @json(
                            $visitorsByDevice->pluck('device_type')->map(function ($item) {
                                return ucfirst($item ?? 'غير معروف');
                            })),
                        datasets: [{
                            data: @json($visitorsByDevice->pluck('total')),
                            backgroundColor: [
                                '#404770', // mobile - primary
                                '#17a2b8', // tablet - info
                                '#28a745', // desktop - success
                                '#6c757d' // other - secondary
                            ],
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        },
                        cutout: '60%'
                    }
                });
            @endif

            @if (!$visitorsByBrowser->isEmpty())
                // Chart: Browsers
                const browserCtx = document.getElementById('browserChart').getContext('2d');
                new Chart(browserCtx, {
                    type: 'pie',
                    data: {
                        labels: @json(
                            $visitorsByBrowser->pluck('browser')->map(function ($item) {
                                return $item ?? 'غير معروف';
                            })),
                        datasets: [{
                            data: @json($visitorsByBrowser->pluck('total')),
                            backgroundColor: [
                                '#404770', // primary
                                '#28a745', // success
                                '#fd7e14', // orange
                                '#17a2b8', // info
                                '#6c757d' // secondary
                            ],
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            @endif
        });

        // Helper function for capitalizing first letter
        function ucfirst(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    </script>
@endsection
