<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Informational directory of chambers a doctor sits at (ours and elsewhere).
     * Online booking availability is driven only by doctor_availabilities /
     * doctor_leaves for our own hospital — this table is not used for slot
     * generation, `is_own_hospital` is display-only context.
     */
    public function up(): void
    {
        Schema::create('doctor_chambers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('hospital_branch')->nullable();
            $table->string('floor')->nullable();
            $table->string('room_no')->nullable();
            $table->text('address')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('google_map_url')->nullable();
            $table->boolean('is_own_hospital')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_chambers');
    }
};
