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
        Schema::table('medical_test_bookings', function (Blueprint $table) {
            $table->decimal('agent_discount_amount', 10, 2)->default(0.00)->after('discount_amount');
            $table->enum('agent_discount_type', ['none', 'percentage', 'fixed'])->default('none')->after('agent_discount_amount');
            $table->decimal('agent_discount_value', 8, 2)->default(0.00)->after('agent_discount_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_test_bookings', function (Blueprint $table) {
            $table->dropColumn(['agent_discount_amount', 'agent_discount_type', 'agent_discount_value']);
        });
    }
};
