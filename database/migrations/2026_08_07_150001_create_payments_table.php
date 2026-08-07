<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payable_type'); // App\Models\Appointment or App\Models\MedicalTestBooking
            $table->unsignedBigInteger('payable_id');
            $table->string('gateway'); // sslcommerz, bkash, etc.
            $table->string('transaction_id')->unique();
            $table->string('val_id')->nullable(); // SSLCommerz Validation ID or bKash paymentID
            $table->string('payment_method')->nullable(); // bKash, VISA, Mastercard, etc.
            $table->string('currency', 10)->default('BDT');
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->enum('status', ['pending', 'successful', 'failed', 'cancelled'])->default('pending');
            $table->json('payment_details')->nullable();
            $table->json('ipn_response')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['payable_type', 'payable_id']);
        });

        // Ensure payment_method columns in appointments and test bookings can store string values
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('payment_method', 50)->nullable()->change();
        });

        Schema::table('medical_test_bookings', function (Blueprint $table) {
            $table->string('payment_method', 50)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
