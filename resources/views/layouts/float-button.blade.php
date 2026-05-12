<!-- أزرار الاتصال العائمة -->
<div class="floating-contact-buttons">
    <div class="floating-button whatsapp-btn" id="whatsappButton" onclick="openWhatsAppModal()">
        <i class="bi bi-whatsapp"></i>
    </div>
    <div class="floating-button phone-btn">
        <a href="tel:{{ preg_replace('/\s+/', '', $contactSection->phone ?? '') }}">
            <i class="bi bi-telephone"></i>
        </a>
    </div>
</div>

<style>
    /* تنسيقات أزرار الاتصال العائمة */
    .floating-contact-buttons {
        position: fixed;
        bottom: 100px;
        right: 20px;
        display: flex;
        flex-direction: column;
        gap: 15px;
        z-index: 997;
    }

    .floating-button {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .floating-button:hover {
        transform: scale(1.1);
    }

    .whatsapp-btn {
        background-color: #25D366;
        color: white;
        animation: pulse-whatsapp 2s infinite;
    }

    .phone-btn {
        background-color: #0ea2bd;
        color: white;
    }

    .phone-btn a {
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        font-size: 1.5rem;
    }

    .floating-button i {
        font-size: 1.5rem;
    }

    @keyframes pulse-whatsapp {
        0% {
            box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(37, 211, 102, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
        }
    }

    /* تنسيقات مودال الواتساب */
    .whatsapp-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 1000;
        display: none;
    }

    .whatsapp-modal-centered {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .whatsapp-modal-centered.show {
        display: flex !important;
    }

    .whatsapp-modal-content {
        background-color: #fff;
        border-radius: 10px;
        width: 90%;
        max-width: 400px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        margin: auto;
        opacity: 0;
        transform: translateY(-30px);
        transition: all 0.3s ease;
    }

    .whatsapp-modal-centered.show .whatsapp-modal-content {
        opacity: 1;
        transform: translateY(0);
    }

    .whatsapp-modal-header {
        background-color: #25D366;
        padding: 15px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .whatsapp-modal-header h5 {
        margin: 0;
        font-size: 18px;
        display: flex;
        align-items: center;
        line-height: 1;
    }

    .whatsapp-close {
        cursor: pointer;
        font-size: 28px;
        font-weight: bold;
        line-height: 1;
        opacity: 0.8;
        transition: all 0.2s;
    }

    .whatsapp-close:hover {
        opacity: 1;
    }

    .whatsapp-modal-body {
        padding: 20px;
    }

    .whatsapp-modal-body p {
        margin-bottom: 20px;
        color: #555;
    }

    .whatsapp-modal-body .form-control {
        border-radius: 8px;
        box-shadow: none !important;
        border: 1px solid #ddd;
        padding: 10px 15px;
    }

    .whatsapp-modal-body .form-control:focus {
        border-color: #25D366;
    }

    .whatsapp-modal-body .btn-success {
        background-color: #25D366;
        border: none;
        padding: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .whatsapp-modal-body .btn-success:hover {
        background-color: #1ea952;
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(37, 211, 102, 0.3);
    }

    @media screen and (max-width: 480px) {
        .whatsapp-modal-content {
            width: 95%;
        }
    }
</style>

<!-- نافذة واتساب المنبثقة -->
<div id="whatsappModal" class="whatsapp-modal whatsapp-modal-centered">
    <div class="whatsapp-modal-content">
        <div class="whatsapp-modal-header">
            <h5><i class="bi bi-whatsapp me-2"></i>تواصل معنا عبر واتساب</h5>
            <span class="whatsapp-close" onclick="closeWhatsAppModal()">&times;</span>
        </div>
        <div class="whatsapp-modal-body">
            <p>مرحباً! كيف يمكننا مساعدتك اليوم؟</p>
            <div class="mb-3">
                <input type="text" class="form-control mb-2" id="whatsappName" placeholder="الاسم">
                <textarea class="form-control mb-2" id="whatsappMessage" placeholder="رسالتك" rows="3"></textarea>
                <button class="btn btn-success w-100" onclick="sendWhatsAppMessage()">
                    <i class="bi bi-whatsapp me-2"></i>إرسال
                </button>
                <!-- عنصر مخفي يحمل رقم الواتساب -->
                <input type="hidden" id="whatsappPhoneNumber"
                    value="{{ preg_replace('/\s+/', '', str_replace('+', '', $contactSection->whatsapp_number ?? ($contactSection->phone ?? ''))) }}">
            </div>
        </div>
    </div>
</div>

<!-- شات بوت -->
<div class="chatbot-overlay" id="chatbot-overlay"></div>
<div id="chatbot-container" class="chatbot-container">
    <div class="chatbot-header">
        <div class="chatbot-title">
            <img src="{{ asset('assets-home') }}/img/favicon.png" alt="Pikkod Support" class="chatbot-avatar">
            <span>دعم شركة نور الوجود</span>
        </div>
        <div class="chatbot-controls">
            <span class="chatbot-minimize" onclick="toggleChatBot()">
                <i class="bi bi-dash"></i>
            </span>
            <span class="chatbot-close" onclick="closeChatBot()">
                <i class="bi bi-x"></i>
            </span>
        </div>
    </div>
    <div class="chatbot-body" id="chatbotBody">
        <div class="chatbot-message bot-message">
            <div class="message-content">
                مرحبًا بك في شركة نور الوجود! كيف يمكنني مساعدتك اليوم؟
            </div>
            <div class="message-time">الآن</div>
        </div>
    </div>
    <div class="chatbot-typing" id="chatbot-typing" style="display: none;">
        <div class="typing-indicator">
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
        </div>
    </div>
    <div class="chatbot-input">
        <button onclick="sendMessage()">
            <i class="bi bi-send"></i>
        </button>
        <input type="text" id="chatbot-input-field" placeholder="اكتب رسالتك هنا..."
            onkeypress="handleKeyPress(event)">
    </div>
</div>

<div class="chatbot-launcher" id="chatbot-launcher" onclick="toggleChatBot()">
    <i class="bi bi-chat-dots-fill"></i>
</div>

<!-- زر التمرير للأعلى -->
<a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

<script>
    // وظائف للتعامل مع مودال الواتساب
    function openWhatsAppModal() {
        const modal = document.getElementById("whatsappModal");
        if (!modal) return;

        // تنشيط النافذة
        modal.classList.add("show");

        // توجيه التركيز لحقل الاسم
        setTimeout(() => {
            const nameInput = document.getElementById("whatsappName");
            if (nameInput) nameInput.focus();
        }, 100);
    }

    function closeWhatsAppModal() {
        const modal = document.getElementById("whatsappModal");
        if (!modal) return;

        modal.classList.remove("show");
    }

    function sendWhatsAppMessage() {
        const name = document.getElementById("whatsappName")?.value.trim() || "";
        const message = document.getElementById("whatsappMessage")?.value.trim() || "";

        if (!name || !message) {
            alert("الرجاء ملء جميع الحقول");
            return;
        }

        // الحصول على رقم الواتساب من العنصر المخفي
        const phoneNumberInput = document.getElementById("whatsappPhoneNumber");
        const phoneNumber = phoneNumberInput ? phoneNumberInput.value : "966500000000";

        const encodedMessage = encodeURIComponent(`الاسم: ${name}\n\nالرسالة: ${message}`);
        const whatsappURL = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;

        window.open(whatsappURL, "_blank");
        closeWhatsAppModal();

        // إعادة تعيين الحقول
        if (document.getElementById("whatsappName")) document.getElementById("whatsappName").value = "";
        if (document.getElementById("whatsappMessage")) document.getElementById("whatsappMessage").value = "";
    }

    // تأكد من إعداد مستمع الأحداث للنقر خارج المودال عند تحميل الصفحة
    document.addEventListener("DOMContentLoaded", function() {
        // إغلاق المودال عند النقر خارجه
        window.addEventListener("click", function(event) {
            const modal = document.getElementById("whatsappModal");
            if (event.target === modal) {
                closeWhatsAppModal();
            }
        });
    });
</script>

<!-- إضافة CSS و JS الخاصين بالشات بوت -->
<link rel="stylesheet" href="{{ asset('assets-home/chatbot/chatbot.css') }}">
<script src="{{ asset('assets-home/chatbot/chatbot.js') }}"></script>
