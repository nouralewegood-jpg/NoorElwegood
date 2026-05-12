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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar'); // اسم الدولة باللغة العربية
            $table->string('name_en'); // اسم الدولة باللغة الإنجليزية
            $table->string('country_code', 10); // رمز الدولة الهاتفي مثل +966
            $table->string('code', 5); // رمز الدولة المختصر مثل SA
            $table->string('flag', 20)->nullable(); // رمز علم الدولة (Emoji)
            $table->tinyInteger('min_length'); // الحد الأدنى لطول رقم الهاتف
            $table->tinyInteger('max_length'); // الحد الأقصى لطول رقم الهاتف
            $table->boolean('is_active')->default(true); // حالة الدولة (فعالة/غير فعالة)
            $table->integer('sort_order')->default(0); // ترتيب العرض
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
