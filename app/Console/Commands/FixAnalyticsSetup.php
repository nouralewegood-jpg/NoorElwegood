<?php

namespace App\Console\Commands;

use App\Models\AnalyticsSetting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixAnalyticsSetup extends Command
{
    /**
     * الاسم والوصف الخاصين بالأمر.
     *
     * @var string
     */
    protected $signature = 'analytics:fix';

    /**
     * وصف الأمر.
     *
     * @var string
     */
    protected $description = 'إصلاح إعداد التحليلات وجداولها';

    /**
     * تنفيذ الأمر.
     */
    public function handle()
    {
        $this->info('جاري إصلاح إعداد نظام التحليلات...');

        // التحقق من وجود جدول الإعدادات
        if (!Schema::hasTable('analytics_settings')) {
            $this->error('جدول analytics_settings غير موجود! جاري إنشاء الجدول...');
            
            Schema::create('analytics_settings', function ($table) {
                $table->id();
                $table->boolean('is_enabled')->default(true);
                $table->boolean('track_bots')->default(false);
                $table->integer('data_retention_days')->default(90);
                $table->timestamps();
            });
            
            $this->info('تم إنشاء جدول analytics_settings بنجاح.');
        } else {
            $this->info('جدول analytics_settings موجود بالفعل.');
        }

        // تسجيل ملف الهجرة في جدول الهجرات إذا لم يكن مسجلاً بالفعل
        $migrationExists = DB::table('migrations')
            ->where('migration', '2025_04_23_create_analytics_settings_table')
            ->exists();

        if (!$migrationExists) {
            DB::table('migrations')->insert([
                'migration' => '2025_04_23_create_analytics_settings_table',
                'batch' => DB::table('migrations')->max('batch') + 1
            ]);
            $this->info('تم تسجيل ملف الهجرة الخاص بجدول analytics_settings.');
        } else {
            $this->info('ملف الهجرة مسجل بالفعل.');
        }

        // التحقق من وجود إعدادات التحليلات وإنشائها إذا لم تكن موجودة
        $settings = AnalyticsSetting::first();
        
        if (!$settings) {
            AnalyticsSetting::create([
                'is_enabled' => true,
                'track_bots' => false,
                'data_retention_days' => 90
            ]);
            $this->info('تم إنشاء إعدادات التحليلات الافتراضية.');
        } else {
            $this->info('إعدادات التحليلات موجودة بالفعل.');
        }

        $this->info('تم إصلاح نظام التحليلات بنجاح! يمكنك الآن الوصول إلى لوحة التحليلات من خلال الرابط /admin/analytics');
    }
}
