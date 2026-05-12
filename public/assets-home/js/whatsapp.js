// وظائف للتعامل مع مودال الواتساب
function openWhatsAppModal() {
    document.getElementById("whatsappModal").classList.add("show");
    document.getElementById("whatsappName").focus();
}

function closeWhatsAppModal() {
    document.getElementById("whatsappModal").classList.remove("show");
}

function sendWhatsAppMessage() {
    const name = document.getElementById("whatsappName").value.trim();
    const message = document.getElementById("whatsappMessage").value.trim();

    if (!name || !message) {
        alert("الرجاء ملء جميع الحقول");
        return;
    }

    // الحصول على رقم الواتساب من العنصر المخفي (من قاعدة البيانات)
    const phoneNumber =
        document.getElementById("whatsappPhoneNumber").value || "966500000000";

    const encodedMessage = encodeURIComponent(
        `الاسم: ${name}\n\nالرسالة: ${message}`
    );
    const whatsappURL = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;

    window.open(whatsappURL, "_blank");
    closeWhatsAppModal();

    // إعادة تعيين الحقول
    document.getElementById("whatsappName").value = "";
    document.getElementById("whatsappMessage").value = "";
}

// إغلاق المودال عند النقر خارجه
window.addEventListener("click", function (event) {
    const modal = document.getElementById("whatsappModal");
    if (event.target == modal) {
        closeWhatsAppModal();
    }
});
