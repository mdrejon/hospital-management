<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Agent Profiles
        Schema::create('agent_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('agent_code')->unique();
            $table->string('phone')->nullable();
            $table->string('nid_number')->nullable();
            $table->string('nid_file')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            
            // Commission configuration
            $table->enum('commission_type', ['percentage', 'fixed'])->default('percentage');
            $table->decimal('doctor_commission_rate', 8, 2)->default(10.00); // 10% or 100 BDT
            $table->decimal('test_commission_rate', 8, 2)->default(15.00);   // 15% or 150 BDT
            
            // Balances
            $table->decimal('wallet_balance', 10, 2)->default(0.00);
            $table->decimal('total_earned_commission', 10, 2)->default(0.00);
            $table->decimal('total_withdrawn_commission', 10, 2)->default(0.00);
            
            // Mobile Banking / Payout info (Bangladesh)
            $table->enum('payout_method', ['bkash', 'nagad', 'rocket', 'upay', 'bank'])->default('bkash');
            $table->string('payout_account_number')->nullable();
            $table->enum('payout_account_type', ['personal', 'agent'])->default('personal');
            $table->json('bank_details')->nullable(); // bank_name, branch, routing_number, account_name
            
            // Status & Approval
            $table->enum('status', ['pending', 'active', 'suspended', 'rejected'])->default('active');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 2. Agent Commissions
        Schema::create('agent_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained('agent_profiles')->cascadeOnDelete();
            $table->enum('source_type', ['appointment', 'medical_test']);
            $table->unsignedBigInteger('source_id');
            $table->string('booking_reference')->nullable();
            $table->decimal('amount', 10, 2);
            $table->decimal('commission_rate', 8, 2)->default(0.00);
            $table->enum('status', ['pending', 'credited', 'cancelled'])->default('pending');
            $table->timestamp('credited_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['source_type', 'source_id']);
        });

        // 3. Agent Withdrawals (Cash Out Requests)
        Schema::create('agent_withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained('agent_profiles')->cascadeOnDelete();
            $table->string('withdrawal_number')->unique();
            $table->decimal('amount', 10, 2);
            $table->enum('payout_method', ['bkash', 'nagad', 'rocket', 'upay', 'bank']);
            $table->string('account_number');
            $table->enum('account_type', ['personal', 'agent'])->default('personal');
            $table->json('bank_details')->nullable();
            $table->enum('status', ['pending', 'processing', 'approved', 'rejected'])->default('pending');
            $table->string('transaction_id')->nullable(); // BD MFS / Bank Txn ID
            $table->text('admin_notes')->nullable();
            $table->foreignId('processed_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });

        // 4. Agent Wallet Transaction Ledger
        Schema::create('agent_wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained('agent_profiles')->cascadeOnDelete();
            $table->enum('type', ['credit_commission', 'debit_withdrawal', 'adjustment_credit', 'adjustment_debit', 'withdrawal_refund']);
            $table->decimal('amount', 10, 2);
            $table->decimal('balance_before', 10, 2);
            $table->decimal('balance_after', 10, 2);
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agent_wallet_transactions');
        Schema::dropIfExists('agent_withdrawals');
        Schema::dropIfExists('agent_commissions');
        Schema::dropIfExists('agent_profiles');
    }
};
