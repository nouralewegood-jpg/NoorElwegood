# 📋 Deployment Guide

## نظرة عامة
هذا المشروع يحتوي على نظام معالجة شامل للأخطاء مع استراتيجيات الاسترجاع التلقائي.

## 🚀 خيارات النشر

### 1️⃣ النشر على Render
```bash
# يتم النشر تلقائياً عند كل push
# تأكد من render.yaml موجود في الجذر
```

### 2️⃣ النشر المحلي مع Docker
```bash
docker-compose up --build
```

### 3️⃣ النشر اليدوي
```bash
python3 deploy.py
```

## 📁 ملفات التكوين الرئيسية

| الملف | الوصف |
|------|-------|
| `error-config.py` | تكوين معالجة الأخطاء والاسترجاع |
| `deploy.py` | سكريبت النشر الشامل |
| `Dockerfile` | تكوين الحاوية |
| `docker-compose.yml` | تكوين الخدمات المتعددة |
| `render.yaml` | تكوين Render |
| `build.sh` | سكريبت البناء |

## ⚙️ معالجة الأخطاء

### أكواد الأخطاء الرئيسية:
- **1001**: فشل تثبيت Composer
- **1002**: فشل تثبيت NPM
- **2001**: فشل الاتصال بقاعدة البيانات
- **2002**: فشل الترحيل
- **4001**: رفض الصلاحيات
- **5001**: مساحة القرص منخفضة

### استراتيجيات الاسترجاع:
كل خطأ له استراتيجية استرجاع تلقائية مع إعادة محاولة متعددة وتأخير متزايد (exponential backoff).

## 🏥 فحوصات الصحة

يتم فحص التطبيق تلقائياً على:
- **HTTP**: `http://localhost:10000/health`
- **Database**: `localhost:5432` (TCP)

## 📊 مراقبة الأداء

الحدود المنبهة:
- CPU Usage: 80%
- Memory Usage: 85%
- Disk Usage: 90%
- Response Time: 5000ms

## 📝 السجلات

السجلات تُحفظ في:
- **ملف**: `/var/www/html/logs/error.log`
- **حجم أقصى**: 100MB
- **نسخ احتياطية**: 10 ملفات سابقة

## ✅ خطوات التحقق بعد النشر

```bash
# 1. فحص الحاوية
docker ps | grep noorelwegood

# 2. عرض السجلات
docker logs noorelwegood_app

# 3. اختبار الاتصال
curl http://localhost:10000/health

# 4. فحص قاعدة البيانات
docker exec noorelwegood_postgres psql -U postgres -d noorelwegood_db -c "SELECT version();"
```

## 🔧 استكشاف الأخطاء الشائعة

### خطأ: Composer installation failed
```bash
composer clear-cache
rm -rf vendor
composer install --no-dev
```

### خطأ: Database connection failed
```bash
# تحقق من PostgreSQL
docker exec noorelwegood_postgres pg_isready -U postgres

# أعد تشغيل الخدمة
docker restart noorelwegood_postgres
```

### خطأ: Permission denied
```bash
sudo chown -R $USER:$USER .
chmod -R 775 storage bootstrap/cache
```

## 📞 الدعم

للمزيد من المعلومات، راجع `error-config.py` و`deploy.py`
