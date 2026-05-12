/**
 * سكريبت تتبع الزيارات لنظام التحليلات
 * يقوم بإرسال بيانات الزيارات إلى الخادم وتسجيل مدة الزيارة
 */

class AnalyticsTracker {
    constructor() {
        this.startTime = new Date().getTime();
        this.visitId = null;
        this.hasTracked = false;
    }

    /**
     * بدء تتبع الزيارة
     */
    init() {
        // نتأكد من أننا لسنا في لوحة التحكم
        if (window.location.href.indexOf("/admin") === -1) {
            // تسجيل الزيارة
            this.recordVisit();

            // تسجيل مدة الزيارة عند مغادرة الصفحة
            window.addEventListener("beforeunload", () => this.trackDuration());
        }
    }

    /**
     * تسجيل زيارة جديدة
     */
    recordVisit() {
        if (this.hasTracked) {
            return;
        }

        const data = {
            page_title: document.title,
            page_url: window.location.href,
        };

        fetch("/api/analytics/record", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": this.getCSRFToken(),
            },
            body: JSON.stringify(data),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success && data.visit_id) {
                    this.visitId = data.visit_id;
                    this.hasTracked = true;
                    console.log("تم تسجيل الزيارة بنجاح");
                }
            })
            .catch((error) => {
                console.error("خطأ في تسجيل الزيارة:", error);
            });
    }

    /**
     * تتبع مدة الزيارة عند مغادرة الصفحة
     */
    trackDuration() {
        if (!this.visitId) {
            return;
        }

        // حساب المدة بالثواني
        const duration = Math.floor(
            (new Date().getTime() - this.startTime) / 1000
        );

        // لا نرسل البيانات إذا كانت المدة أقل من ثانية واحدة
        if (duration < 1) {
            return;
        }

        // استخدام واجهة sendBeacon للإرسال في حالة مغادرة الصفحة
        const beaconData = new FormData();
        beaconData.append("visit_id", this.visitId);
        beaconData.append("duration", duration);
        beaconData.append("_token", this.getCSRFToken());

        if (navigator.sendBeacon) {
            navigator.sendBeacon("/api/analytics/duration", beaconData);
        } else {
            // البديل إذا لم يكن متصفح المستخدم يدعم sendBeacon
            fetch("/api/analytics/duration", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "X-CSRF-TOKEN": this.getCSRFToken(),
                },
                body: `visit_id=${this.visitId}&duration=${duration}`,
                keepalive: true,
            }).catch((e) => console.error("خطأ في تحديث مدة الزيارة:", e));
        }
    }

    /**
     * الحصول على رمز CSRF
     */
    getCSRFToken() {
        return (
            document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content") || ""
        );
    }
}

// بدء التتبع عند تحميل الصفحة
document.addEventListener("DOMContentLoaded", () => {
    const tracker = new AnalyticsTracker();
    tracker.init();
});
