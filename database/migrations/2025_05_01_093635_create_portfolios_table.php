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
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('title');              // عنوان العمل
            $table->text('description')->nullable(); // وصف العمل
            $table->string('image');             // صورة العمل الرئيسية
            $table->json('gallery')->nullable();  // معرض صور إضافية (اختياري)
            $table->string('client_name')->nullable(); // اسم العميل (اختياري)
            $table->date('project_date')->nullable(); // تاريخ المشروع (اختياري)
            $table->string('category')->nullable(); // تصنيف العمل (اختياري)
            $table->string('tags')->nullable();    // الكلمات المفتاحية (اختياري)
            $table->boolean('is_featured')->default(false); // هل هو عمل مميز يظهر في الصفحة الرئيسية
            $table->integer('display_order')->default(0); // ترتيب العرض
            $table->boolean('active')->default(true); // حالة النشاط
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
