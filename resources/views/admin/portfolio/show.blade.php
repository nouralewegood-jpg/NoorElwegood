@extends('admin.layouts.master')


@section('title', 'عرض تفاصيل العمل')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>عرض تفاصيل العمل</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.portfolio.index') }}">معرض الأعمال</a></li>
                    <li class="breadcrumb-item active">عرض تفاصيل العمل</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <!-- بطاقة المعلومات الرئيسية -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $portfolio->title }}</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.portfolio.edit', $portfolio->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> تعديل
                            </a>
                            <a href="{{ route('portfolio.show', $portfolio->id) }}" class="btn btn-info btn-sm"
                                target="_blank">
                                <i class="fas fa-eye"></i> عرض في الموقع
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            @if ($portfolio->image)
                                <img src="{{ $portfolio->image_url }}" alt="{{ $portfolio->title }}"
                                    class="img-fluid rounded" style="max-height: 400px;">
                            @else
                                <div class="alert alert-warning">لا توجد صورة رئيسية لهذا العمل</div>
                            @endif
                        </div>

                        <h4>وصف العمل</h4>
                        <div class="p-3 bg-light rounded mb-4">
                            @if ($portfolio->description)
                                {!! nl2br(e($portfolio->description)) !!}
                            @else
                                <p class="text-muted">لا يوجد وصف لهذا العمل</p>
                            @endif
                        </div>

                        @if ($portfolio->gallery && count($portfolio->gallery) > 0)
                            <h4>معرض الصور</h4>
                            <div class="row mb-4">
                                @foreach ($portfolio->gallery_urls as $imageUrl)
                                    <div class="col-md-3 col-sm-4 mb-3">
                                        <a href="{{ $imageUrl }}" data-toggle="lightbox"
                                            data-gallery="portfolio-gallery" data-title="{{ $portfolio->title }}">
                                            <img src="{{ $imageUrl }}" class="img-fluid rounded"
                                                style="height: 120px; width: 100%; object-fit: cover;">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if ($portfolio->tags)
                            <h4>الوسوم</h4>
                            <div class="mb-4">
                                @foreach (explode(',', $portfolio->tags) as $tag)
                                    <span class="badge badge-primary p-2 mr-1">{{ trim($tag) }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <!-- نهاية بطاقة المعلومات الرئيسية -->
            </div>

            <div class="col-md-4">
                <!-- بطاقة المعلومات الإضافية -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">معلومات إضافية</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th style="width: 40%">التصنيف</th>
                                    <td>{{ $portfolio->category ?? 'غير محدد' }}</td>
                                </tr>
                                <tr>
                                    <th>اسم العميل</th>
                                    <td>{{ $portfolio->client_name ?? 'غير محدد' }}</td>
                                </tr>
                                <tr>
                                    <th>تاريخ المشروع</th>
                                    <td>{{ $portfolio->project_date ? $portfolio->project_date->format('Y-m-d') : 'غير محدد' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>ترتيب العرض</th>
                                    <td>{{ $portfolio->display_order }}</td>
                                </tr>
                                <tr>
                                    <th>الحالة</th>
                                    <td>
                                        @if ($portfolio->active)
                                            <span class="badge badge-success">نشط</span>
                                        @else
                                            <span class="badge badge-danger">غير نشط</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>مميز</th>
                                    <td>
                                        @if ($portfolio->is_featured)
                                            <span class="badge badge-success">مميز</span>
                                        @else
                                            <span class="badge badge-secondary">غير مميز</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>تاريخ الإنشاء</th>
                                    <td>{{ $portfolio->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>آخر تحديث</th>
                                    <td>{{ $portfolio->updated_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- نهاية بطاقة المعلومات الإضافية -->

                <!-- بطاقة الإجراءات -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">الإجراءات</h3>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('admin.portfolio.edit', $portfolio->id) }}"
                            class="btn btn-primary btn-block mb-2">
                            <i class="fas fa-edit"></i> تعديل
                        </a>
                        <button type="button" class="btn btn-danger btn-block" data-toggle="modal"
                            data-target="#deleteModal">
                            <i class="fas fa-trash"></i> حذف
                        </button>

                        <hr>

                        <a href="{{ route('admin.portfolio.index') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-arrow-right"></i> العودة إلى القائمة
                        </a>
                    </div>
                </div>
                <!-- نهاية بطاقة الإجراءات -->
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">تأكيد الحذف</h5>
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من رغبتك في حذف العمل: <strong>{{ $portfolio->title }}</strong>؟</p>
                    <p class="text-danger"><small>سيتم حذف جميع الصور المرتبطة بهذا العمل.</small></p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('admin.portfolio.destroy', $portfolio->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets-admin/plugins/ekko-lightbox/ekko-lightbox.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets-admin/plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
    <script>
        $(function() {
            // تفعيل معرض الصور
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true,
                    showArrows: true
                });
            });
        });
    </script>
@endsection
