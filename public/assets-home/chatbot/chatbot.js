// Chatbot functionality
document.addEventListener("DOMContentLoaded", function () {
    // التحقق من وجود CSRF token لطلبات API
    const metaTag = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = metaTag ? metaTag.getAttribute("content") : "";

    // حالة الشات بوت
    let isChatbotOpen = false;

    // قائمة برسائل الخطأ المخصصة
    const ERROR_MESSAGES = {
        SERVER_ERROR:
            "عذراً، حدث خطأ في الاتصال بالخادم. يرجى المحاولة مرة أخرى.",
        RATE_LIMIT:
            "لقد تجاوزت الحد المسموح به من الرسائل، يرجى الانتظار قليلاً قبل إرسال المزيد.",
        INPUT_ERROR: "يرجى إدخال رسالة صالحة.",
        EMPTY_MESSAGE:
            "يبدو أنك لم تكتب رسالة بعد. من فضلك اكتب سؤالك لنتمكن من مساعدتك.",
        VALIDATION_ERROR: "الرسالة تحتوي على محتوى غير مسموح به.",
    };

    // متغيرات تحكم بالأمان
    const SECURITY_CONFIG = {
        MAX_MESSAGE_LENGTH: 500,
        MIN_MESSAGE_LENGTH: 1, // تغيير الحد الأدنى للرسالة من 2 إلى 1 حرف
        MESSAGE_COOLDOWN_MS: 500, // منع الإرسال السريع للرسائل
        BLOCKED_PATTERNS: [
            /<script\b[^>]*>(.*?)<\/script>/i,
            /<iframe\b[^>]*>(.*?)<\/iframe>/i,
            /javascript:/i,
            /on\w+\s*=/i,
            /data:text\/html/i,
        ],
    };

    // ضبط معالجات الأحداث ومنع الإزالة
    let lastMessageTime = 0;
    let isProcessing = false;

    // إنشاء عنصر الطبقة الشفافة إذا لم يكن موجوداً
    let chatbotOverlay = document.getElementById("chatbot-overlay");
    if (!chatbotOverlay) {
        chatbotOverlay = document.createElement("div");
        chatbotOverlay.id = "chatbot-overlay";
        chatbotOverlay.className = "chatbot-overlay";
        document.body.appendChild(chatbotOverlay);
    }

    /**
     * تبديل عرض الشات بوت
     */
    function toggleChatBot() {
        const chatbot = document.getElementById("chatbot-container");
        const launcher = document.getElementById("chatbot-launcher");

        if (!chatbot || !launcher) return;

        if (isChatbotOpen) {
            chatbot.style.display = "none";
            launcher.style.display = "flex";
            chatbotOverlay.style.display = "none";
        } else {
            chatbot.style.display = "flex";
            launcher.style.display = "none";
            chatbotOverlay.style.display = "block";
            const inputField = document.getElementById("chatbot-input-field");
            if (inputField) inputField.focus();
        }

        isChatbotOpen = !isChatbotOpen;
    }
    window.toggleChatBot = toggleChatBot;

    /**
     * إغلاق الشات بوت
     */
    function closeChatBot() {
        const chatbot = document.getElementById("chatbot-container");
        const launcher = document.getElementById("chatbot-launcher");

        if (!chatbot || !launcher) return;

        chatbot.style.display = "none";
        launcher.style.display = "flex";
        chatbotOverlay.style.display = "none";
        isChatbotOpen = false;
    }
    window.closeChatBot = closeChatBot;

    /**
     * الحصول على الوقت الحالي بتنسيق HH:MM
     */
    function getCurrentTime() {
        const now = new Date();
        return (
            now.getHours().toString().padStart(2, "0") +
            ":" +
            now.getMinutes().toString().padStart(2, "0")
        );
    }

    /**
     * التحقق من أمان المحتوى المدخل
     * @param {string} message - الرسالة المراد فحصها
     * @returns {object} - نتيجة الفحص: {safe: boolean, reason: string}
     */
    function validateMessage(message) {
        // التحقق من الطول
        if (!message || message.trim().length === 0) {
            return { safe: false, reason: ERROR_MESSAGES.EMPTY_MESSAGE };
        }

        // تم إزالة التحقق من الحد الأدنى للرسالة لقبول الرسائل القصيرة مثل الرموز

        if (message.length > SECURITY_CONFIG.MAX_MESSAGE_LENGTH) {
            return { safe: false, reason: ERROR_MESSAGES.INPUT_ERROR };
        }

        // التحقق من وجود أنماط ضارة
        for (const pattern of SECURITY_CONFIG.BLOCKED_PATTERNS) {
            if (pattern.test(message)) {
                return { safe: false, reason: ERROR_MESSAGES.VALIDATION_ERROR };
            }
        }

        return { safe: true, reason: "" };
    }

    /**
     * تطهير النص من المحتوى الضار
     * @param {string} text - النص المراد تطهيره
     * @returns {string} - النص بعد التطهير
     */
    function sanitizeText(text) {
        // إذا كان النص فارغاً، إرجاع نص فارغ
        if (!text) return "";

        // استبدال العلامات والرموز بمكافئاتها الآمنة
        // مع الحفاظ على الرموز التعبيرية ونص عربي سليم
        const map = {
            "<": "&lt;",
            ">": "&gt;",
            '"': "&quot;",
            "'": "&#39;",
            "`": "&#x60;",
        };

        // تعديل النمط للسماح بالرموز التعبيرية والنصوص العربية
        return String(text).replace(/[<>"'`]/g, function (s) {
            return map[s];
        });
    }

    /**
     * عرض رسالة خطأ في الشات
     * @param {string} errorMessage - نص رسالة الخطأ
     */
    function showError(errorMessage) {
        const chatbotBody = document.getElementById("chatbotBody");
        if (!chatbotBody) return;

        // إخفاء مؤشر الكتابة إن وجد
        hideTypingIndicator(chatbotBody);

        // إضافة رسالة الخطأ
        const errorDiv = document.createElement("div");
        errorDiv.className = "chatbot-message bot-message";
        errorDiv.innerHTML = `
            <div class="message-content error-message">${sanitizeText(
                errorMessage
            )}</div>
            <div class="message-time">${getCurrentTime()}</div>
        `;
        chatbotBody.appendChild(errorDiv);

        // تمرير إلى أسفل
        chatbotBody.scrollTop = chatbotBody.scrollHeight;
    }

    /**
     * إرسال رسالة إلى الشات بوت
     */
    async function sendMessage() {
        const inputField = document.getElementById("chatbot-input-field");
        if (!inputField) return;

        const message = inputField.value.trim();

        // التحقق من صحة المدخلات
        const validation = validateMessage(message);
        if (!validation.safe) {
            showError(validation.reason);
            return;
        }

        // منع النقر المتكرر للإرسال
        const now = Date.now();
        if (
            now - lastMessageTime < SECURITY_CONFIG.MESSAGE_COOLDOWN_MS ||
            isProcessing
        ) {
            return;
        }
        lastMessageTime = now;

        // تعيين حالة المعالجة
        isProcessing = true;

        const chatbotBody = document.getElementById("chatbotBody");
        if (!chatbotBody) return;

        // إظهار مؤشر الكتابة
        showTypingIndicator(chatbotBody);

        // إضافة رسالة المستخدم (بعد التطهير)
        const userDiv = document.createElement("div");
        userDiv.className = "chatbot-message user-message";
        userDiv.innerHTML = `
            <div class="message-content">${sanitizeText(message)}</div>
            <div class="message-time">${getCurrentTime()}</div>
        `;
        chatbotBody.appendChild(userDiv);
        inputField.value = "";
        chatbotBody.scrollTop = chatbotBody.scrollHeight;

        try {
            // استدعاء API الشات بوت باستخدام عنوان نسبي
            const apiUrl = window.location.origin + "/api/chatbot";
            const response = await fetch(apiUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "X-Requested-With": "XMLHttpRequest",
                },
                body: JSON.stringify({
                    message,
                }),
                credentials: "same-origin",
            });

            // إخفاء مؤشر الكتابة
            hideTypingIndicator(chatbotBody);

            // محاولة تحليل البيانات مع التعامل مع الأخطاء المحتملة
            let data;
            try {
                data = await response.json();
            } catch (parseError) {
                console.error("Error parsing response:", parseError);
                showError(ERROR_MESSAGES.SERVER_ERROR);
                return;
            }

            if (response.ok) {
                // التحقق من وجود خطأ في الاستجابة
                if (data.error) {
                    showError(data.error);
                    return;
                }

                const botResponse = data.response;

                // التأكد من وجود استجابة صالحة
                if (!botResponse || typeof botResponse !== "string") {
                    showError(ERROR_MESSAGES.SERVER_ERROR);
                    return;
                }

                // إضافة رد البوت (بعد التطهير)
                const botDiv = document.createElement("div");
                botDiv.className = "chatbot-message bot-message";
                botDiv.innerHTML = `
                    <div class="message-content">${sanitizeText(
                        botResponse
                    )}</div>
                    <div class="message-time">${getCurrentTime()}</div>
                `;
                chatbotBody.appendChild(botDiv);
            } else {
                // معالجة أكواد الاستجابة المختلفة
                if (response.status === 429) {
                    showError(ERROR_MESSAGES.RATE_LIMIT);
                } else if (response.status === 422 && data && data.messages) {
                    // التأكد من وجود كائن messages في الاستجابة
                    const errorMessage = data.messages.message
                        ? data.messages.message
                        : Array.isArray(data.messages)
                        ? data.messages.join(", ")
                        : ERROR_MESSAGES.VALIDATION_ERROR;
                    showError(errorMessage);
                } else {
                    throw new Error("خطأ في الاستجابة: " + response.status);
                }
            }
        } catch (e) {
            console.error("Chatbot API error", e);
            showError(ERROR_MESSAGES.SERVER_ERROR);
        } finally {
            // إعادة تعيين حالة المعالجة
            isProcessing = false;

            // تمرير إلى الأسفل بعد إضافة الرسائل
            chatbotBody.scrollTop = chatbotBody.scrollHeight;
        }
    }
    window.sendMessage = sendMessage;

    /**
     * إظهار مؤشر الكتابة
     */
    function showTypingIndicator(chatbotBody) {
        // التحقق من وجود مؤشر كتابة سابق
        let typingIndicator = chatbotBody.querySelector(".chatbot-typing");
        if (!typingIndicator) {
            // إنشاء مؤشر كتابة جديد
            typingIndicator = document.createElement("div");
            typingIndicator.className = "chatbot-typing";
            typingIndicator.innerHTML = `
                <div class="typing-indicator">
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                </div>
            `;
            chatbotBody.appendChild(typingIndicator);
        } else {
            typingIndicator.style.display = "flex";
        }
    }

    /**
     * إخفاء مؤشر الكتابة
     */
    function hideTypingIndicator(chatbotBody) {
        const typingIndicator = chatbotBody.querySelector(".chatbot-typing");
        if (typingIndicator) {
            typingIndicator.style.display = "none";
        }
    }

    /**
     * معالجة ضغطات المفاتيح
     */
    function handleKeyPress(event) {
        // التأكد من أننا نتعامل فقط مع مفتاح الإدخال
        if (event.key === "Enter") {
            event.preventDefault();

            const inputField = document.getElementById("chatbot-input-field");

            // التأكد من وجود نص في حقل الإدخال والتحقق من عدم وجود معالجة جارية
            if (inputField && inputField.value.trim() !== "" && !isProcessing) {
                sendMessage();
            }
        }
    }
    window.handleKeyPress = handleKeyPress;

    // تهيئة الشات بوت عند تحميل الصفحة
    function initChatbot() {
        const chatbot = document.getElementById("chatbot-container");
        const launcher = document.getElementById("chatbot-launcher");

        if (chatbot && launcher) {
            chatbot.style.display = "none";
            launcher.style.display = "flex";

            // إضافة مستمع للنقر على الطبقة الشفافة لإغلاق الشات بوت
            chatbotOverlay.addEventListener("click", function () {
                closeChatBot();
            });

            // ربط حقل الإدخال بمعالج ضغطات المفاتيح
            const inputField = document.getElementById("chatbot-input-field");
            if (inputField) {
                // حماية من التلاعب بالمدخلات عن طريق التحقق النشط
                inputField.addEventListener("input", function () {
                    if (
                        this.value.length > SECURITY_CONFIG.MAX_MESSAGE_LENGTH
                    ) {
                        this.value = this.value.substring(
                            0,
                            SECURITY_CONFIG.MAX_MESSAGE_LENGTH
                        );
                    }

                    // فحص أنماط ضارة أثناء الكتابة
                    for (const pattern of SECURITY_CONFIG.BLOCKED_PATTERNS) {
                        if (pattern.test(this.value)) {
                            this.value = this.value.replace(pattern, "");
                        }
                    }
                });

                inputField.addEventListener("keypress", handleKeyPress);
            }
        }
    }

    // تشغيل تهيئة الشات بوت
    initChatbot();
});
