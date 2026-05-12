@extends('admin.layouts.master')

@section('title', 'إضافة مرادف جديد')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الشات بوت</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المترادفات / إضافة جديد</span>
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
                    <h3 class="card-title">إضافة مرادف جديد</h3>
                    <a href="{{ route('admin.chatbot-synonyms.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-right"></i> عودة للقائمة
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

                <form action="{{ route('admin.chatbot-synonyms.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="main_word">الكلمة الرئيسية <span class="text-danger">*</span></label>
                        <input type="text" name="main_word" id="main_word"
                            class="form-control @error('main_word') is-invalid @enderror" value="{{ old('main_word') }}"
                            required>
                        <small class="form-text text-muted">أدخل الكلمة الرئيسية التي ستستخدم كمفتاح في البحث</small>
                    </div>

                    <div class="form-group">
                        <label for="synonyms">المرادفات <span class="text-danger">*</span></label>
                        <textarea name="synonyms" id="synonyms" rows="4" class="form-control @error('synonyms') is-invalid @enderror"
                            required>{{ old('synonyms') }}</textarea>
                        <small class="form-text text-muted">أدخل المرادفات مفصولة بفواصل، مثال: كلمة1, كلمة2, كلمة3</small>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="active" name="active" value="1"
                                {{ old('active', '1') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="active">مفعل</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> حفظ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
