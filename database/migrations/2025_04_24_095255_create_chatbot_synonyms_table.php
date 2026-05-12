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
        Schema::create('chatbot_synonyms', function (Blueprint $table) {
            $table->id();
            $table->string('main_word')->unique();  // الكلمة الرئيسية
            $table->json('synonyms')->nullable();    // المرادفات كمصفوفة JSON
            $table->boolean('active')->default(true); // حالة التفعيل
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_synonyms');
    }
};
