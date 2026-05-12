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
        Schema::table('service_items', function (Blueprint $table) {
            $table->foreignId('service_section_id')->nullable()->constrained('service_sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_items', function (Blueprint $table) {
            $table->dropForeign(['service_section_id']);
            $table->dropColumn('service_section_id');
        });
    }
};
