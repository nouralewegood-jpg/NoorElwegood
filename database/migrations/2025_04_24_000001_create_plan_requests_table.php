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
        Schema::create('plan_requests', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('phone_number');
            $table->string('country_code')->nullable();
            $table->string('country')->nullable();
            $table->text('project_details')->nullable();
            $table->string('plan_name');
            $table->string('plan_price');
            $table->string('plan_period')->nullable();
            $table->enum('status', ['new', 'in_progress', 'completed', 'cancelled'])->default('new');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_requests');
    }
};
