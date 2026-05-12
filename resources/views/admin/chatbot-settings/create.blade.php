@extends('admin.layouts.master')

@section('title', 'إضافة إعداد جديد للشات بوت')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الشات بوت</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الإعدادات المتقدمة / إضافة جديد</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">إضافة إعداد جديد للشات بوت</h1>
            <a href="{{ route('admin.chatbot-settings.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-right"></i> العودة للقائمة
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('admin.chatbot-settings.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="key">Key <span class="text-danger">*</span></label>
                        <input type="text" name="key" id="key"
                            class="form-control @error('key') is-invalid @enderror" value="{{ old('key') }}" required>
                        @error('key')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="value">Value <span class="text-danger">*</span></label>
                        <textarea name="value" id="value" class="form-control @error('value') is-invalid @enderror" rows="4"
                            required>{{ old('value') }}</textarea>
                        @error('value')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select name="type" id="type" class="form-control">
                            <option value="text">Text</option>
                            <option value="html">HTML</option>
                        </select>
                    </div>
                    <div class="form-group form-check">
                        <input type="hidden" name="active" value="0">
                        <input type="checkbox" name="active" id="active" value="1" class="form-check-input"
                            {{ old('active', false) ? 'checked' : '' }}>
                        <label for="active" class="form-check-label">Active</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection
