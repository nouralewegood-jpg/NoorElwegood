@extends('admin.layouts.master')

@section('title', 'اختبار الشات بوت')

@section('css')
    <!--- Internal Sweet-Alert css-->
    <link href="{{ URL::asset('assets-admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    <style>
        .chat-container {
            height: 500px;
            border: 1px solid #eee;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .chat-header {
            background-color: #28a745;
            color: #fff;
            padding: 15px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-messages {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
            background-color: #f8f9fa;
        }

        .chat-input {
            padding: 10px;
            border-top: 1px solid #eee;
            background-color: #fff;
            display: flex;
        }

        .chat-input input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-left: 10px;
        }

        .message {
            margin-bottom: 15px;
            max-width: 80%;
        }

        .message-user {
            margin-right: auto;
        }

        .message-bot {
            margin-left: auto;
            background-color: #28a745;
            color: #fff;
        }

        .message-content {
            padding: 10px 15px;
            border-radius: 18px;
            display: inline-block;
            background-color: #e9ecef;
            word-break: break-word;
        }

        .message-bot .message-content {
            background-color: #28a745;
        }

        .message-time {
            font-size: 12px;
            text-align: left;
            color: #999;
            margin-top: 5px;
        }

        .message-bot .message-time {
            text-align: right;
            color: #eee;
        }

        .chat-typing {
            padding: 5px 15px;
            font-size: 12px;
            color: #777;
            font-style: italic;
        }
    </style>
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الشات بوت</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اختبار</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        اختبار الشات بوت
                    </div>
                    <p class="mg-b-20">قم باختبار الشات بوت كما سيظهر للزوار</p>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="chat-container">
                                <div class="chat-header">
                                    <div class="d-flex align-items-center">
                                        @if (isset($settings->icon) && $settings->icon)
                                            <img src="{{ asset('storage/' . $settings->icon) }}" alt="شات بوت"
                                                class="ml-2" style="width: 30px; height: 30px;">
                                        @else
                                            <i class="fas fa-robot ml-2"></i>
                                        @endif
                                        <h5 class="mb-0">{{ $settings->title ?? 'شات المساعدة' }}</h5>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-light" id="resetChat">
                                            <i class="fas fa-redo"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="chat-messages" id="chatMessages">
                                    <div class="message message-bot">
                                        <div class="message-content">
                                            {{ $settings->welcome_message ?? 'مرحباً! كيف يمكنني مساعدتك؟' }}
                                        </div>
                                        <div class="message-time">الآن</div>
                                    </div>
                                </div>
                                <div id="typingIndicator" class="chat-typing d-none">
                                    جاري الكتابة...
                                </div>
                                <div class="chat-input">
                                    <input type="text" placeholder="اكتب رسالتك هنا..." id="userMessage">
                                    <button class="btn btn-success" id="sendMessage">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="card-title mb-0">إعدادات الاختبار</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="responseMode">وضع الرد</label>
                                        <select class="form-control" id="responseMode">
                                            <option value="auto" selected>رد تلقائي (آلي)</option>
                                            <option value="manual">رد يدوي (محاكاة)</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="responseDelay">تأخير الرد (بالثواني)</label>
                                        <input type="number" class="form-control" id="responseDelay" value="2"
                                            min="0" max="10">
                                    </div>
                                    <div class="form-group">
                                        <label for="chatColor">لون الشات</label>
                                        <input type="color" class="form-control" id="chatColor"
                                            value="{{ $settings->primary_color ?? '#28a745' }}">
                                    </div>
                                    <div class="custom-control custom-switch mb-3">
                                        <input type="checkbox" class="custom-control-input" id="showTyping" checked>
                                        <label class="custom-control-label" for="showTyping">إظهار مؤشر الكتابة</label>
                                    </div>
                                    <hr>
                                    <div class="text-center">
                                        <a href="{{ route('admin.chatbot.settings') }}" class="btn btn-primary">
                                            <i class="fas fa-cog"></i> تعديل الإعدادات
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert alert-info" role="alert">
                                <i class="fas fa-info-circle ml-2"></i>
                                هذه الصفحة لاختبار الشات بوت فقط. للتعديل على إعدادات الشات بوت يرجى الانتقال إلى
                                <a href="{{ route('admin.chatbot.settings') }}" class="alert-link">صفحة الإعدادات</a>.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->

    <!-- Manual Response Modal -->
    <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="responseModalLabel">كتابة رد</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="manualResponse">اكتب رد على رسالة المستخدم</label>
                        <textarea class="form-control" id="manualResponse" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-primary" id="sendResponse">إرسال</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!--Internal  Sweet-Alert js-->
    <script src="{{ URL::asset('assets-admin/plugins/sweet-alert/sweetalert.min.js') }}"></script>

    <script>
        $(function() {
            const messagesContainer = $('#chatMessages');
            const userInput = $('#userMessage');
            const sendButton = $('#sendMessage');
            const typingIndicator = $('#typingIndicator');
            const responseMode = $('#responseMode');
            const responseDelay = $('#responseDelay');
            const showTyping = $('#showTyping');
            const chatHeader = $('.chat-header');
            const botMessages = $('.message-bot .message-content');

            // Apply color settings
            const updateChatColor = (color) => {
                chatHeader.css('background-color', color);
                botMessages.css('background-color', color);
                $('.message-bot .message-content').css('background-color', color);
                $('#sendMessage').css('background-color', color).css('border-color', color);
            };

            $('#chatColor').on('input', function() {
                updateChatColor($(this).val());
            });

            // Auto responses for testing
            const autoResponses = [
                'شكراً على تواصلك معنا. كيف يمكنني مساعدتك؟',
                'أهلاً بك! يسعدني الإجابة على استفساراتك.',
                'سأقوم بتوجيهك للحصول على المعلومات التي تحتاجها.',
                'الرجاء الانتظار قليلاً ريثما أتحقق من المعلومات المتوفرة لدينا.',
                'هذا سؤال مثير للاهتمام! دعني أشارك معك بعض المعلومات حوله.'
            ];

            // Scroll to bottom of chat
            const scrollToBottom = () => {
                messagesContainer.scrollTop(messagesContainer[0].scrollHeight);
            };

            // Add message to chat
            const addMessage = (message, isUser = false) => {
                const now = new Date();
                const time = now.getHours() + ':' + (now.getMinutes() < 10 ? '0' : '') + now.getMinutes();

                const messageHtml = `
                    <div class="message message-${isUser ? 'user' : 'bot'}">
                        <div class="message-content">${message}</div>
                        <div class="message-time">${time}</div>
                    </div>
                `;

                messagesContainer.append(messageHtml);
                scrollToBottom();

                // Apply color to new bot messages
                if (!isUser) {
                    $('.message-bot .message-content').css('background-color', $('#chatColor').val());
                }
            };

            // Show typing indicator
            const showTypingIndicator = () => {
                if (showTyping.is(':checked')) {
                    typingIndicator.removeClass('d-none');
                    scrollToBottom();
                }
            };

            // Hide typing indicator
            const hideTypingIndicator = () => {
                typingIndicator.addClass('d-none');
            };

            // Generate bot response
            const generateResponse = (userMessage) => {
                return new Promise((resolve) => {
                    const delay = parseInt(responseDelay.val()) * 1000 || 1000;

                    showTypingIndicator();

                    setTimeout(() => {
                        hideTypingIndicator();

                        if (responseMode.val() === 'auto') {
                            // Auto response mode
                            const randomResponse = autoResponses[Math.floor(Math.random() *
                                autoResponses.length)];
                            resolve(randomResponse);
                        } else {
                            // Manual response mode
                            $('#responseModal').modal('show');

                            $('#sendResponse').off('click').on('click', function() {
                                const manualResponse = $('#manualResponse').val()
                                .trim() || 'لم يتم إدخال رد';
                                $('#responseModal').modal('hide');
                                $('#manualResponse').val('');
                                resolve(manualResponse);
                            });
                        }
                    }, delay);
                });
            };

            // Send user message
            const sendUserMessage = async () => {
                const message = userInput.val().trim();
                if (!message) return;

                addMessage(message, true);
                userInput.val('');

                const response = await generateResponse(message);
                addMessage(response);
            };

            // Event listeners
            sendButton.on('click', sendUserMessage);

            userInput.on('keypress', function(e) {
                if (e.which === 13) {
                    sendUserMessage();
                    return false;
                }
            });

            // Reset chat
            $('#resetChat').on('click', function() {
                swal({
                    title: "إعادة تعيين المحادثة",
                    text: "هل أنت متأكد من رغبتك في إعادة تعيين المحادثة؟",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "نعم، أعد التعيين",
                    cancelButtonText: "لا، إلغاء",
                    closeOnConfirm: false
                }, function() {
                    messagesContainer.html('');
                    addMessage("{{ $settings->welcome_message ?? 'مرحباً! كيف يمكنني مساعدتك؟' }}");
                    swal("تم!", "تم إعادة تعيين المحادثة بنجاح", "success");
                });
            });

            // Initial color setup
            updateChatColor($('#chatColor').val());
        });
    </script>
@endsection
