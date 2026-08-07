<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid')->after('fee');
            $table->decimal('paid_amount', 10, 2)->default(0.00)->after('payment_status');
            $table->enum('payment_method', ['cash', 'bkash', 'nagad', 'rocket', 'card', 'online'])->nullable()->after('paid_amount');
            $table->foreignId('agent_id')->nullable()->after('booked_by_user_id')->constrained('agent_profiles')->nullOnDelete();
            $table->decimal('agent_commission_amount', 10, 2)->default(0.00)->after('fee');
            $table->enum('agent_commission_status', ['none', 'pending', 'credited', 'cancelled'])->default('none')->after('agent_commission_amount');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['agent_id']);
            $table->dropColumn([
                'payment_status',
                'paid_amount',
                'payment_method',
                'agent_id',
                'agent_commission_amount',
                'agent_commission_status',
            ]);
        });
    }
};
