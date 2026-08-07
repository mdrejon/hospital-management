<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Medical Test Categories
        Schema::create('medical_test_categories', function (Blueprint $table) {
            $table->id();
            $table->json('name'); // translatable
            $table->string('slug')->unique();
            $table->json('description')->nullable();
            $table->string('icon')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Medical Tests Catalog
        Schema::create('medical_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('medical_test_categories')->nullOnDelete();
            $table->string('code')->unique();
            $table->json('name'); // translatable
            $table->json('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->enum('discount_type', ['none', 'percentage', 'fixed'])->default('none');
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('final_price', 10, 2);
            $table->decimal('commission_rate', 8, 2)->nullable(); // override commission rate if specified
            $table->json('preparation_instructions')->nullable(); // translatable
            $table->string('estimated_delivery_time')->nullable(); // e.g. "24 Hours"
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Medical Test Bookings (Orders)
        Schema::create('medical_test_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique();
            $table->foreignId('patient_id')->nullable()->constrained('patients')->nullOnDelete();
            $table->foreignId('doctor_id')->nullable()->constrained('doctors')->nullOnDelete(); // Referring doctor
            $table->foreignId('booked_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('agent_id')->nullable()->constrained('agent_profiles')->nullOnDelete();
            
            // Patient details
            $table->string('patient_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->default('male');
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            
            // Booking schedule
            $table->date('booking_date');
            $table->date('preferred_date')->nullable();
            
            // Billing & Pricing
            $table->decimal('subtotal_amount', 10, 2)->default(0.00);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('total_amount', 10, 2)->default(0.00);
            $table->decimal('paid_amount', 10, 2)->default(0.00);
            $table->decimal('due_amount', 10, 2)->default(0.00);
            
            // Payment tracking
            $table->enum('payment_status', ['unpaid', 'partial', 'paid'])->default('unpaid');
            $table->enum('payment_method', ['cash', 'bkash', 'nagad', 'rocket', 'card', 'online'])->nullable();
            
            // Agent Commission
            $table->decimal('agent_commission_amount', 10, 2)->default(0.00);
            $table->enum('agent_commission_status', ['none', 'pending', 'credited', 'cancelled'])->default('none');
            
            // Service Status
            $table->enum('status', ['pending', 'sample_collected', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->date('report_delivery_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 4. Medical Test Booking Items
        Schema::create('medical_test_booking_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_test_booking_id')->constrained('medical_test_bookings')->cascadeOnDelete();
            $table->foreignId('medical_test_id')->constrained('medical_tests');
            $table->string('test_name');
            $table->string('test_code');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('final_price', 10, 2);
            $table->enum('status', ['pending', 'sample_collected', 'testing', 'completed', 'cancelled'])->default('pending');
            $table->string('report_file')->nullable(); // Uploaded report PDF/Image
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_test_booking_items');
        Schema::dropIfExists('medical_test_bookings');
        Schema::dropIfExists('medical_tests');
        Schema::dropIfExists('medical_test_categories');
    }
};
