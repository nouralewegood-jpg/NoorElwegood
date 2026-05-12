@extends('admin.layouts.master')


@section('title', 'عرض الرسالة')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">تفاصيل الرسالة</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-outline-secondary">العودة للرسائل</a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $message->subject }}</h5>
                    <span class="badge {{ $message->is_read ? 'bg-success' : 'bg-warning' }}">
                        {{ $message->is_read ? 'مقروءة' : 'غير مقروءة' }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <p><strong>المرسل:</strong> {{ $message->name }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>البريد الإلكتروني:</strong> {{ $message->email }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>رقم الواتساب:</strong> {{ $message->whatsapp ?? 'غير متوفر' }}</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong>تاريخ الإرسال:</strong> {{ $message->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="message-content p-3 bg-light rounded">
                            <h6>محتوى الرسالة:</h6>
                            <p class="mt-2">{{ $message->message }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="btn-group">
                        <a href="mailto:{{ $message->email }}" class="btn btn-primary">
                            <i class="bi bi-envelope"></i> الرد بالبريد
                        </a>

                        @if ($message->whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $message->whatsapp) }}" target="_blank"
                                class="btn btn-success">
                                <i class="bi bi-whatsapp"></i> الرد على الواتساب
                            </a>
                        @endif

                        <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('هل أنت متأكد من حذف هذه الرسالة؟')">
                                <i class="bi bi-trash"></i> حذف الرسالة
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
