@extends('admin.layouts.master')


@section('title', 'إدارة الرسائل')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">إدارة الرسائل</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- معلومات الحماية من التكرار -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">الحماية من الطلبات المتكررة</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="alert alert-info">
                            <h6><i class="fas fa-shield-alt me-2"></i> نظام الحماية من التكرار:</h6>
                            <p>تم تمكين نظام الحماية من الإرسالات المتكررة للرسائل من نفس المستخدم.</p>
                            <ul>
                                <li><strong>الحد الأقصى للرسائل:</strong> 3 رسائل لكل مستخدم</li>
                                <li><strong>الفترة الزمنية:</strong> 60 دقيقة</li>
                            </ul>
                            <p><small>تعتمد آلية الحماية على عنوان IP والبريد الإلكتروني للمستخدم.</small></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="alert alert-warning">
                            <h6><i class="fas fa-exclamation-triangle me-2"></i> تنبيه أمني:</h6>
                            <p>نظام الحماية من التكرار يحمي موقعك من:</p>
                            <ul>
                                <li>هجمات بريدية عشوائية</li>
                                <li>محاولات إغراق قاعدة البيانات</li>
                                <li>إساءة استخدام نموذج الاتصال</li>
                            </ul>
                            <p><small>يمكن تعديل إعدادات الحماية من خلال ملف <code>MessageRateLimiter.php</code></small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- نموذج الإجراءات الجماعية الرئيسي -->
        <form id="bulk-action-form" action="{{ route('admin.messages.bulk-update') }}" method="POST">
            @csrf
            <input type="hidden" name="action" id="bulk-action-type" value="">
            <div id="message-ids-container">
                <!-- سيتم إضافة معرفات الرسائل هنا بواسطة جافاسكريبت -->
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">قائمة الرسائل</h5>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="bulkActionsDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                إجراءات جماعية
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="bulkActionsDropdown">
                                <li>
                                    <button type="button" class="dropdown-item bulk-action-btn" data-action="mark_read">تعليم كمقروءة</button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item bulk-action-btn" data-action="mark_unread">تعليم كغير مقروءة</button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item text-danger bulk-action-btn" data-action="delete">حذف المحدد</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mg-b-0 text-md-nowrap ">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                            <label class="form-check-label" for="selectAll"></label>
                                        </div>
                                    </th>
                                    <th>الاسم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>رقم الواتساب</th>
                                    <th>الموضوع</th>
                                    <th>التاريخ</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($messages as $message)
                                    <tr class="{{ $message->is_read ? '' : 'fw-bold' }}">
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input message-checkbox" type="checkbox"
                                                    value="{{ $message->id }}" id="message{{ $message->id }}">
                                                <label class="form-check-label" for="message{{ $message->id }}"></label>
                                            </div>
                                        </td>
                                        <td>{{ $message->name }}</td>
                                        <td>{{ $message->email }}</td>
                                        <td>{{ $message->whatsapp ?? '-' }}</td>
                                        <td>{{ Str::limit($message->subject, 30) }}</td>
                                        <td>{{ $message->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            @if ($message->is_read)
                                                <span class="badge bg-success">مقروءة</span>
                                            @else
                                                <span class="badge bg-warning">غير مقروءة</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.messages.show', $message->id) }}"
                                                class="btn btn-sm btn-primary">عرض</a>
                                            <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('هل أنت متأكد من حذف هذه الرسالة؟')">حذف</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">لا توجد رسائل</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // زر تحديد الكل
            const selectAllCheckbox = document.getElementById('selectAll');
            const messageCheckboxes = document.querySelectorAll('.message-checkbox');

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('click', function() {
                    const isChecked = this.checked;
                    messageCheckboxes.forEach(checkbox => {
                        checkbox.checked = isChecked;
                    });
                });
            }

            // أزرار الإجراءات الجماعية
            const bulkActionForm = document.getElementById('bulk-action-form');
            const bulkActionType = document.getElementById('bulk-action-type');
            const messageIdsContainer = document.getElementById('message-ids-container');
            const bulkActionButtons = document.querySelectorAll('.bulk-action-btn');

            bulkActionButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const action = this.getAttribute('data-action');
                    const checkedBoxes = document.querySelectorAll('.message-checkbox:checked');

                    if (checkedBoxes.length === 0) {
                        alert('الرجاء تحديد رسالة واحدة على الأقل');
                        return;
                    }

                    // تأكيد الحذف إذا كان الإجراء هو الحذف
                    if (action === 'delete') {
                        if (!confirm('هل أنت متأكد من حذف الرسائل المحددة؟')) {
                            return;
                        }
                    }

                    // تعيين نوع الإجراء
                    bulkActionType.value = action;

                    // إزالة أي حقول سابقة
                    messageIdsContainer.innerHTML = '';

                    // إضافة معرفات الرسائل المحددة
                    checkedBoxes.forEach(checkbox => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'message_ids[]';
                        input.value = checkbox.value;
                        messageIdsContainer.appendChild(input);
                    });

                    // إرسال النموذج
                    bulkActionForm.submit();
                });
            });
        });
    </script>
@endsection
