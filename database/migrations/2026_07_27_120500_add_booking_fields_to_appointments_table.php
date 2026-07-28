<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreignId('patient_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->foreignId('doctor_id')->nullable()->after('patient_id')->constrained()->nullOnDelete();
            $table->foreignId('booked_by_user_id')->nullable()->after('doctor_id')->constrained('users')->nullOnDelete();
            $table->string('appointment_type', 30)->nullable()->after('department'); // opd | follow_up
            $table->date('appointment_date')->nullable()->after('preferred_date');
            $table->string('time_slot', 20)->nullable()->after('appointment_date');
            $table->unsignedInteger('serial_number')->nullable()->after('time_slot');
            $table->decimal('fee', 10, 2)->nullable()->after('serial_number');
            $table->text('symptoms')->nullable()->after('message');
            $table->string('prescription_file')->nullable()->after('symptoms');
        });

        DB::statement("ALTER TABLE appointments MODIFY status ENUM('pending','confirmed','checked_in','in_consultation','completed','follow_up_required','cancelled','no_show') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE appointments MODIFY status ENUM('pending','confirmed','cancelled','completed') NOT NULL DEFAULT 'pending'");

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('patient_id');
            $table->dropConstrainedForeignId('doctor_id');
            $table->dropConstrainedForeignId('booked_by_user_id');
            $table->dropColumn([
                'appointment_type', 'appointment_date', 'time_slot',
                'serial_number', 'fee', 'symptoms', 'prescription_file',
            ]);
        });
    }
};
