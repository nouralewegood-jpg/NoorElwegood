@extends('admin.layouts.master')

@section('title', 'إدارة الأسئلة غير المجاب عليها')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الشات بوت</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الأسئلة غير المجاب عليها</span>
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
                    <h3 class="card-title">قائمة الأسئلة التي تحتاج إلى إجابات</h3>
                    <div>
                        <div class="btn-group mr-2">
                            <a href="{{ route('admin.chatbot-questions.index', ['status' => 'all']) }}"
                                class="btn btn-outline-primary {{ $status == 'all' ? 'active' : '' }}">
                                <i class="fas fa-list"></i> جميع الأسئلة
                            </a>
                            <a href="{{ route('admin.chatbot-questions.index', ['status' => 'pending']) }}"
                                class="btn btn-outline-warning {{ $status == 'pending' ? 'active' : '' }}">
                                <i class="fas fa-clock"></i> بانتظار الإجابة
                            </a>
                            <a href="{{ route('admin.chatbot-questions.index', ['status' => 'answered']) }}"
                                class="btn btn-outline-success {{ $status == 'answered' ? 'active' : '' }}">
                                <i class="fas fa-check"></i> تمت الإجابة
                            </a>
                            <a href="{{ route('admin.chatbot-questions.index', ['status' => 'transferred']) }}"
                                class="btn btn-outline-info {{ $status == 'transferred' ? 'active' : '' }}">
                                <i class="fas fa-share"></i> تم النقل
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($questions->isEmpty())
                    <div class="alert alert-info">لا توجد أسئلة متاحة حالياً.</div>
                @else
                    <form action="{{ route('admin.chatbot-questions.bulk-transfer') }}" method="POST" id="questions-form">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="40">
                                            <div class="icheck-primary">
                                                <input type="checkbox" id="check-all">
                                                <label for="check-all"></label>
                                            </div>
                                        </th>
                                        <th>السؤال</th>
                                        <th>الإجابة</th>
                                        <th>عدد مرات السؤال</th>
                                        <th>آخر مرة</th>
                                        <th>الحالة</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($questions as $question)
                                        <tr>
                                            <td>
                                                @if ($question->status === 'answered')
                                                    <div class="icheck-primary">
                                                        <input type="checkbox" name="questions[]"
                                                            value="{{ $question->id }}" id="question-{{ $question->id }}">
                                                        <label for="question-{{ $question->id }}"></label>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $question->question }}</td>
                                            <td>
                                                @if ($question->answer)
                                                    {{ Str::limit($question->answer, 100) }}
                                                @else
                                                    <span class="badge badge-secondary">لا توجد إجابة</span>
                                                @endif
                                            </td>
                                            <td><span class="badge badge-primary">{{ $question->frequency }}</span></td>
                                            <td>
                                                @if (is_string($question->last_asked_at))
                                                    {{ \Carbon\Carbon::parse($question->last_asked_at)->format('Y-m-d H:i') }}
                                                @else
                                                    {{ $question->last_asked_at->format('Y-m-d H:i') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($question->status === 'pending')
                                                    <span class="badge badge-warning">بانتظار الإجابة</span>
                                                @elseif($question->status === 'answered')
                                                    <span class="badge badge-success">تمت الإجابة</span>
                                                @elseif($question->status === 'transferred')
                                                    <span class="badge badge-info">تم النقل للإعدادات</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    @if ($question->status === 'pending')
                                                        <a href="{{ route('admin.chatbot-questions.edit', $question->id) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="fas fa-edit"></i> إضافة إجابة
                                                        </a>
                                                    @elseif($question->status === 'answered')
                                                        <a href="{{ route('admin.chatbot-questions.edit', $question->id) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="fas fa-edit"></i> تعديل الإجابة
                                                        </a>
                                                        <form
                                                            action="{{ route('admin.chatbot-questions.transfer', $question->id) }}"
                                                            method="POST" style="display:inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success">
                                                                <i class="fas fa-share"></i> نقل للإعدادات
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <form
                                                        action="{{ route('admin.chatbot-questions.destroy', $question->id) }}"
                                                        method="POST" style="display:inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('هل أنت متأكد من حذف هذا السؤال؟')">
                                                            <i class="fas fa-trash"></i> حذف
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary" id="bulk-transfer-btn" disabled>
                                    <i class="fas fa-share"></i> نقل الأسئلة المحددة إلى الإعدادات
                                </button>
                            </div>
                            <div class="col-md-6">
                                <div class="float-right">
                                    {{ $questions->appends(['status' => $status])->links() }}
                                </div>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // تحديد/إلغاء تحديد كل الصفوف
            $('#check-all').change(function() {
                $('input[name="questions[]"]').prop('checked', $(this).prop('checked'));
                updateBulkTransferButton();
            });

            // تحديث حالة زر النقل الجماعي
            $('input[name="questions[]"]').change(function() {
                updateBulkTransferButton();
            });

            function updateBulkTransferButton() {
                var checkedCount = $('input[name="questions[]"]:checked').length;
                $('#bulk-transfer-btn').prop('disabled', checkedCount === 0);
            }
        });
    </script>
@endsection
