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
        Schema::table('messages', function (Blueprint $table) {
            // إضافة حقول الأمان
            $table->string('ip_address', 45)->nullable()->after('message');
            $table->string('user_agent', 255)->nullable()->after('ip_address');
            $table->boolean('is_suspicious')->default(false)->after('user_agent');
            $table->text('security_notes')->nullable()->after('is_suspicious');
            $table->timestamp('blocked_at')->nullable()->after('security_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // حذف حقول الأمان عند التراجع
            $table->dropColumn(['ip_address', 'user_agent', 'is_suspicious', 'security_notes', 'blocked_at']);
        });
    }
};
