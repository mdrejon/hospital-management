<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_phone');
            $table->text('message');
            $table->string('event_type'); // e.g. appointment_booked, appointment_confirmed, test_booked, test_completed, commission_credited, withdrawal_status, test_sms
            $table->string('provider')->nullable(); // e.g. ssl_wireless, greenweb, bulksms_bd, custom_http, twilio
            $table->enum('status', ['sent', 'failed', 'queued'])->default('sent');
            $table->text('gateway_response')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_logs');
    }
};
