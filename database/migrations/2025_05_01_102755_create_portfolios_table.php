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
        // قبل إنشاء الجدول، نتحقق من عدم وجوده مسبقًا
        if (!Schema::hasTable('portfolios')) {
            Schema::create('portfolios', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('category')->nullable();
                $table->string('client_name')->nullable();
                $table->date('project_date')->nullable();
                $table->string('tags')->nullable();
                $table->string('image');
                $table->json('gallery')->nullable();
                $table->integer('display_order')->default(0);
                $table->boolean('is_featured')->default(false);
                $table->boolean('active')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
