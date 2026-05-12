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
        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_name');
            $table->string('plan_badge')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('price_period')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('btn_text')->nullable();
            $table->string('btn_link')->nullable();
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
        Schema::dropIfExists('pricing_plans');
    }
};
