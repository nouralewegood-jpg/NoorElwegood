/**
 * بيكود - نظام تتبع وتحليل الزيارات
 */

class PickodAnalytics {
    constructor() {
        this.visitId = null;
        this.startTime = Date.now();
        this.isActive = true;
        this.setupEventListeners();
    }

    /**
     * تسجيل زيارة جديدة وإرجاع معرف الزيارة
     */
    init() {
        // الحصول على عنوان الصفحة الحالية
        const pageTitle = document.title;
        
        // إرسال طلب AJAX لتسجيل الزيارة
        fetch('/api/analytics/record', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.getCsrfToken()
            },
            body: JSON.stringify({ 
                page_title: pageTitle 
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.visit_id) {
                this.visitId = data.visit_id;
            }
        })
        .catch(error => {
            console.error('خطأ في تسجيل الزيارة:', error);
        });
    }

    /**
     * إعداد أحداث المتصفح للتتبع
     */
    setupEventListeners() {
        // تسجيل مدة الزيارة عندما يغادر المستخدم الصفحة
        window.addEventListener('beforeunload', this.recordDuration.bind(this));
        
        // تسجيل تجربة المستخدم (هل الصفحة نشطة أم لا)
        document.addEventListener('visibilitychange', this.handleVisibilityChange.bind(this));
    }

    /**
     * معالجة حدث تغيير رؤية الصفحة (عند تبديل التبويبات)
     */
    handleVisibilityChange() {
        this.isActive = document.visibilityState === 'visible';
    }

    /**
     * تسجيل مدة الزيارة عند مغادرة الصفحة
     */
    recordDuration() {
        if (!this.visitId) return;
        
        // احتساب مدة الزيارة بالثواني
        const duration = Math.floor((Date.now() - this.startTime) / 1000);
        
        // تسجيل مدة الزيارة عبر API
        fetch('/api/analytics/duration', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.getCsrfToken()
            },
            body: JSON.stringify({ 
                visit_id: this.visitId,
                duration: duration
            }),
            // استخدام sendBeacon لضمان وصول البيانات حتى عند إغلاق الصفحة
            keepalive: true
        });
    }

    /**
     * الحصول على رمز CSRF
     */
    getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    }
}

// تهيئة النظام عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', () => {
    window.pickodAnalytics = new PickodAnalytics();
    window.pickodAnalytics.init();
});
