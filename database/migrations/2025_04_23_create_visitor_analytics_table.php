<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visitor_analytics', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('page_url');
            $table->string('page_title')->nullable();
            $table->string('referrer_url')->nullable();
            $table->string('device_type')->nullable();
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->integer('visit_duration')->default(0); // بالثواني
            $table->boolean('is_unique')->default(true);
            $table->boolean('is_bounce')->default(true); // الزيارة لصفحة واحدة فقط
            $table->timestamps();
        });
        
        // إنشاء جدول إعدادات التحليلات
        Schema::create('analytics_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_enabled')->default(true);
            $table->boolean('track_bots')->default(false); // تتبع محركات البحث/روبوتات
            $table->integer('data_retention_days')->default(90); // الاحتفاظ بالبيانات لمدة معينة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_analytics');
        Schema::dropIfExists('analytics_settings');
    }
};
