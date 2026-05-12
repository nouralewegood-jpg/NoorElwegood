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
        Schema::create('home_sections', function (Blueprint $table) {
            $table->id();
            $table->string('company_badge')->nullable();
            $table->string('main_title_line1')->nullable();
            $table->string('main_title_line2')->nullable();
            $table->string('main_title_line3')->nullable();
            $table->text('description')->nullable();
            $table->string('btn_text')->nullable();
            $table->string('btn_link')->nullable();
            $table->string('video_btn_text')->nullable();
            $table->string('video_link')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('customer_count')->nullable();
            $table->text('customer_text')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('ordering')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_sections');
    }
};
