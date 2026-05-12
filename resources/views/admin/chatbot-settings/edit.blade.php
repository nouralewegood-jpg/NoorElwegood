@extends('admin.layouts.master')

@section('title', 'تعديل إعدادات الشات بوت')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الشات بوت</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الإعدادات المتقدمة / تعديل</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">تعديل إعدادات الشات بوت</h1>
            <a href="{{ route('admin.chatbot-settings.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-right"></i> العودة للقائمة
            </a>
        </div>
        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('admin.chatbot-settings.update', $chatbotSetting->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="key">السؤال <span class="text-danger">*</span></label>
                        <input type="text" name="key" id="key"
                            class="form-control @error('key') is-invalid @enderror"
                            value="{{ old('key', $chatbotSetting->key) }}" required>
                        @error('key')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="value">الإجابة <span class="text-danger">*</span></label>
                        <textarea name="value" id="value" class="form-control @error('value') is-invalid @enderror" rows="4"
                            required>{{ old('value', $chatbotSetting->value) }}</textarea>
                        @error('value')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type">النوع</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="text" {{ $chatbotSetting->type == 'text' ? 'selected' : '' }}>نص
                                    </option>
                                    <option value="html" {{ $chatbotSetting->type == 'html' ? 'selected' : '' }}>HTML
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="frequency">عدد مرات السؤال</label>
                                <input type="number" name="frequency" id="frequency"
                                    class="form-control @error('frequency') is-invalid @enderror"
                                    value="{{ old('frequency', $chatbotSetting->frequency) }}" min="0">
                                @error('frequency')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-check">
                        <input type="hidden" name="active" value="0">
                        <input type="checkbox" name="active" id="active" value="1" class="form-check-input"
                            {{ old('active', $chatbotSetting->active) ? 'checked' : '' }}>
                        <label for="active" class="form-check-label">مفعل</label>
                    </div>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </form>
            </div>
        </div>
    </div>
@endsection
