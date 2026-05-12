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
        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();
            $table->string('meta_text')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('main_image')->nullable();
            $table->string('secondary_image')->nullable();
            $table->string('ceo_name')->nullable();
            $table->string('ceo_position')->nullable();
            $table->string('ceo_image')->nullable();
            $table->string('phone_label')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('years_experience')->nullable();
            $table->text('experience_text')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_sections');
    }
};
