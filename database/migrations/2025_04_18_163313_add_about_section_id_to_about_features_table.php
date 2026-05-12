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
        Schema::table('about_features', function (Blueprint $table) {
            $table->foreignId('about_section_id')->nullable()->constrained('about_sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_features', function (Blueprint $table) {
            $table->dropForeign(['about_section_id']);
            $table->dropColumn('about_section_id');
        });
    }
};
