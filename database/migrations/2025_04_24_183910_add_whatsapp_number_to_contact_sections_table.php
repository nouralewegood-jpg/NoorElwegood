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
        Schema::table('contact_sections', function (Blueprint $table) {
            // إضافة حقل رقم الواتساب
            $table->string('whatsapp_number')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_sections', function (Blueprint $table) {
            // حذف حقل رقم الواتساب عند التراجع
            $table->dropColumn('whatsapp_number');
        });
    }
};
