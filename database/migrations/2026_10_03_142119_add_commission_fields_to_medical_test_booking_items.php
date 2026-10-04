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
        Schema::table('medical_test_booking_items', function (Blueprint $table) {
            $table->decimal('agent_discount_amount', 10, 2)->default(0.00)->after('discount_amount');
            $table->decimal('commission_rate', 8, 2)->default(0.00)->after('agent_discount_amount');
            $table->decimal('commission_amount', 10, 2)->default(0.00)->after('commission_rate');
            $table->decimal('commission_base_price', 10, 2)->default(0.00)->after('commission_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_test_booking_items', function (Blueprint $table) {
            $table->dropColumn(['agent_discount_amount', 'commission_rate', 'commission_amount', 'commission_base_price']);
        });
    }
};
