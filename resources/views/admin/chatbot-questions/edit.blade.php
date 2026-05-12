@extends('admin.layouts.master')

@section('title', 'إضافة/تعديل إجابة للسؤال')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الشات بوت</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الأسئلة غير المجاب عليها /
                    {{ $question->status === 'pending' ? 'إضافة إجابة' : 'تعديل إجابة' }}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        {{ $question->status === 'pending' ? 'إضافة إجابة للسؤال' : 'تعديل إجابة السؤال' }}</h3>
                    <a href="{{ route('admin.chatbot-questions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-right"></i> العودة للقائمة
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="alert alert-info">
                    <h5><i class="icon fas fa-info-circle"></i> السؤال</h5>
                    <p class="mb-0">{{ $question->question }}</p>
                    <small class="text-muted d-block mt-2">
                        تم طرح هذا السؤال {{ $question->frequency }} مرة، وآخر مرة كانت في
                        @if (is_string($question->last_asked_at))
                            {{ \Carbon\Carbon::parse($question->last_asked_at)->format('Y-m-d H:i') }}
                        @else
                            {{ $question->last_asked_at->format('Y-m-d H:i') }}
                        @endif
                    </small>
                </div>

                <form action="{{ route('admin.chatbot-questions.update', $question->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="answer">الإجابة <span class="text-danger">*</span></label>
                        <textarea name="answer" id="answer" rows="6" class="form-control @error('answer') is-invalid @enderror"
                            required>{{ old('answer', $question->answer) }}</textarea>
                        <small class="form-text text-muted">أدخل إجابة واضحة وشاملة للسؤال. يمكنك استخدام HTML البسيط في
                            الإجابة.</small>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> حفظ الإجابة
                        </button>

                        @if ($question->status === 'answered')
                            <a href="{{ route('admin.chatbot-questions.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> إلغاء
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
