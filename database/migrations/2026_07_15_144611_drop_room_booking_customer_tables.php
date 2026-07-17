<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Schema::dropIfExists('booking_followups');
        Schema::dropIfExists('booking_logs');
        Schema::dropIfExists('booking_rooms');
        Schema::dropIfExists('room_type_amenity');
        Schema::dropIfExists('room_bookings');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('room_amenities');
        Schema::dropIfExists('room_types');
        Schema::dropIfExists('customers');

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Irreversible — the Room/Booking/Customer feature and its schema
        // were removed from the application.
    }
};
