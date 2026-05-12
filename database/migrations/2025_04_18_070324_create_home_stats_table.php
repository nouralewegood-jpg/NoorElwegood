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
        Schema::create('home_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_section_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('icon')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
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
        Schema::dropIfExists('home_stats');
    }
};
