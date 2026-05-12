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
        Schema::create('chatbot_unanswered_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question', 500);  // السؤال الذي لم يتم الإجابة عليه
            $table->text('answer')->nullable(); // الإجابة المقترحة (يتم إضافتها من لوحة التحكم)
            $table->integer('frequency')->default(1); // عدد مرات طرح السؤال
            $table->enum('status', ['pending', 'answered', 'transferred'])->default('pending'); // حالة السؤال
            $table->timestamp('last_asked_at')->useCurrent(); // آخر مرة تم فيها طرح السؤال
            $table->timestamp('answered_at')->nullable(); // تاريخ إضافة الإجابة
            $table->timestamp('transferred_at')->nullable(); // تاريخ نقل السؤال والإجابة إلى الإعدادات الرئيسية
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_unanswered_questions');
    }
};
