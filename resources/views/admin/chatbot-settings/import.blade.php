@extends('admin.layouts.master')

@section('title', 'استيراد أسئلة وأجوبة الشات بوت')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الشات بوت</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ استيراد أسئلة وأجوبة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">استيراد أسئلة وأجوبة الشات بوت</h1>
            <a href="{{ route('admin.chatbot-settings.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-right"></i> العودة للقائمة
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">استيراد من ملف Excel</h6>
                <a href="{{ route('admin.chatbot-settings.template') }}" class="btn btn-sm btn-outline-info">
                    <i class="fas fa-download"></i> تنزيل النموذج
                </a>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="alert alert-info">
                    <h5>إرشادات الاستيراد:</h5>
                    <ul>
                        <li>قم بتنزيل نموذج ملف الاستيراد باستخدام الزر أعلاه</li>
                        <li>يجب أن يحتوي الملف على الأعمدة التالية: السؤال، الإجابة، النوع، الحالة (مفعل)، عدد مرات السؤال
                        </li>
                        <li>حقل "السؤال" و "الإجابة" إلزامي لكل صف</li>
                        <li>حقل "النوع" يمكن أن يكون "text" أو "html"، الافتراضي هو "text"</li>
                        <li>حقل "مفعل" يمكن أن يكون "1" (مفعل) أو "0" (غير مفعل)، الافتراضي هو "1"</li>
                        <li>حقل "عدد مرات السؤال" يجب أن يكون رقماً، الافتراضي هو "0"</li>
                        <li>إذا كان السؤال موجوداً بالفعل، سيتم تحديث الإجابة والبيانات الأخرى</li>
                    </ul>
                </div>

                <form action="{{ route('admin.chatbot-settings.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="excel_file">ملف Excel <span class="text-danger">*</span></label>
                        <input type="file" name="excel_file" id="excel_file"
                            class="form-control @error('excel_file') is-invalid @enderror" required>
                        @error('excel_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">الصيغ المدعومة: .xlsx, .xls. الحد الأقصى للحجم: 10
                            ميجابايت</small>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> استيراد الأسئلة والأجوبة
                    </button>
                </form>
            </div>
        </div>

        <!-- شرح توضيحي -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">كيفية إعداد ملف الاستيراد</h6>
            </div>
            <div class="card-body">
                <p>يجب أن يحتوي ملف الاستيراد على صف عناوين (الصف الأول) وبه الأعمدة التالية:</p>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>السؤال</th>
                                <th>الإجابة</th>
                                <th>النوع (اختياري)</th>
                                <th>مفعل (اختياري)</th>
                                <th>عدد مرات السؤال (اختياري)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>كيف يمكنني التواصل معكم؟</td>
                                <td>يمكنك التواصل معنا عبر البريد الإلكتروني info@example.com أو الهاتف 123456789</td>
                                <td>text</td>
                                <td>1</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>ما هي خدماتكم؟</td>
                                <td>نقدم خدمات تطوير المواقع الإلكترونية وتطبيقات الهاتف وخدمات الذكاء الاصطناعي</td>
                                <td>text</td>
                                <td>1</td>
                                <td>0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <p class="mt-3">ملاحظات هامة:</p>
                <ul>
                    <li>يمكنك استيراد العديد من الأسئلة والإجابات في وقت واحد</li>
                    <li>استخدم النموذج المتاح للتنزيل لضمان تنسيق البيانات بشكل صحيح</li>
                    <li>سيقوم النظام بالتحقق من كل صف وإبلاغك إذا كانت هناك أي أخطاء</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
