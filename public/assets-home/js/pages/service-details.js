/**
 * service-details.js
 * ملف جافا سكريبت لصفحة تفاصيل الخدمة
 */

document.addEventListener("DOMContentLoaded", function () {
    // التأكد من وجود مكتبة AOS
    if (typeof AOS !== "undefined") {
        // تهيئة تأثيرات AOS للتمرير بشكل فوري
        AOS.init({
            duration: 1000,
            once: false,
            mirror: false,
            offset: 120,
            easing: "ease-in-out",
            startEvent: "DOMContentLoaded", // تشغيل فوري عند تحميل الصفحة
        });

        // إعادة تهيئة AOS بعد لحظة للتأكد من عمله على جميع العناصر
        setTimeout(function () {
            AOS.refresh();
        }, 500);
    } else {
        console.error("مكتبة AOS غير محملة");
    }

    // بقية الكود ...

    // تأثير تفاعلي لأيقونة الخدمة الرئيسية
    const serviceIcon = document.querySelector(".service-icon");
    if (serviceIcon) {
        serviceIcon.addEventListener("mouseenter", function () {
            this.querySelector("i").classList.add(
                "animate__animated",
                "animate__tada"
            );
        });
        serviceIcon.addEventListener("mouseleave", function () {
            this.querySelector("i").classList.remove(
                "animate__animated",
                "animate__tada"
            );
        });
    }

    // تأثير تفاعلي لقائمة المميزات
    const featureItems = document.querySelectorAll(".features-list li");
    featureItems.forEach((item) => {
        item.addEventListener("mouseenter", function () {
            this.style.paddingLeft = "35px";
        });
        item.addEventListener("mouseleave", function () {
            this.style.paddingLeft = "30px";
        });
    });

    // تأثير الظهور التدريجي للعناصر عند التمرير
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px",
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("visible");
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document
        .querySelectorAll(
            ".service-details-content, .service-features, .other-service-card"
        )
        .forEach((el) => {
            el.classList.add("fade-in-element");
            observer.observe(el);
        });

    // تأثير متابعة المؤشر للعناصر التفاعلية
    const cards = document.querySelectorAll(".other-service-card");
    cards.forEach((card) => {
        card.addEventListener("mousemove", function (e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const deltaX = ((x - centerX) / centerX) * 5;
            const deltaY = ((y - centerY) / centerY) * 5;

            this.style.transform = `perspective(1000px) rotateX(${-deltaY}deg) rotateY(${deltaX}deg) scale3d(1.02, 1.02, 1.02)`;
        });

        card.addEventListener("mouseleave", function () {
            this.style.transform =
                "perspective(1000px) rotateX(0) rotateY(0) scale3d(1, 1, 1)";
        });
    });

    // مؤثر تسليط الضوء على الصورة الرئيسية
    const serviceImage = document.querySelector(".service-details-image");
    if (serviceImage) {
        serviceImage.addEventListener("mouseenter", function () {
            this.classList.add("highlight");
        });
        serviceImage.addEventListener("mouseleave", function () {
            this.classList.remove("highlight");
        });
    }
});
