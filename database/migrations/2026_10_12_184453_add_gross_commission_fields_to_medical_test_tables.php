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
            $table->decimal('agent_gross_commission_amount', 10, 2)->default(0.00)->after('agent_commission_amount');
        });

        Schema::table('medical_test_booking_items', function (Blueprint $table) {
            $table->decimal('gross_commission_amount', 10, 2)->default(0.00)->after('commission_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_test_bookings', function (Blueprint $table) {
            $table->dropColumn('agent_gross_commission_amount');
        });

        Schema::table('medical_test_booking_items', function (Blueprint $table) {
            $table->dropColumn('gross_commission_amount');
        });
    }
};
