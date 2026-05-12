<?php
/**
 * سكريبت لإصلاح مشكلة إعدادات تحليلات الزيارات
 * 
 * هذا الملف يقوم بإنشاء إعدادات افتراضية لنظام تحليلات الزيارات 
 */

// تضمين ملف autoload لاستخدام كلاسات Laravel
require_once __DIR__ . '/vendor/autoload.php';

// بدء تحميل التطبيق
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// استخدام نموذج إعدادات التحليلات 
use App\Models\AnalyticsSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "بدء إصلاح مشكلة نظام تحليلات الزيارات...\n";

// التحقق من وجود الجدول
if (!Schema::hasTable('analytics_settings')) {
    echo "! خطأ: جدول analytics_settings غير موجود\n";
    echo "جاري إنشاء الجدول...\n";
    
    Schema::create('analytics_settings', function ($table) {
        $table->id();
        $table->boolean('is_enabled')->default(true);
        $table->boolean('track_bots')->default(false);
        $table->integer('data_retention_days')->default(90);
        $table->timestamps();
    });
    
    echo "✓ تم إنشاء جدول analytics_settings بنجاح.\n";
} else {
    echo "✓ جدول analytics_settings موجود بالفعل.\n";
}

// إضافة سجل الإعدادات الافتراضية
$existingSettings = AnalyticsSetting::first();

if (!$existingSettings) {
    AnalyticsSetting::create([
        'is_enabled' => true,
        'track_bots' => false,
        'data_retention_days' => 90
    ]);
    echo "✓ تم إنشاء إعدادات التحليلات الافتراضية بنجاح.\n";
} else {
    echo "✓ إعدادات التحليلات موجودة بالفعل.\n";
    echo "القيم الحالية:\n";
    echo "- التحليلات مفعلة: " . ($existingSettings->is_enabled ? 'نعم' : 'لا') . "\n";
    echo "- تتبع الروبوتات: " . ($existingSettings->track_bots ? 'نعم' : 'لا') . "\n";
    echo "- مدة الاحتفاظ بالبيانات: " . $existingSettings->data_retention_days . " يوم\n";
}

// تسجيل ملف الهجرة في جدول الهجرات
$migrationExists = DB::table('migrations')
    ->where('migration', '2025_04_23_create_analytics_settings_table')
    ->exists();

if (!$migrationExists) {
    DB::table('migrations')->insert([
        'migration' => '2025_04_23_create_analytics_settings_table',
        'batch' => DB::table('migrations')->max('batch') + 1
    ]);
    echo "✓ تم تسجيل ملف الهجرة 2025_04_23_create_analytics_settings_table بنجاح.\n";
} else {
    echo "✓ ملف الهجرة مسجل بالفعل.\n";
}

echo "\nاكتمل الإصلاح بنجاح! يمكنك الآن الوصول إلى لوحة التحليلات من خلال الرابط /admin/analytics\n";
