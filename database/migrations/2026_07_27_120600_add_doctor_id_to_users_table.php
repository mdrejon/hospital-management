<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Links a "Doctor" role login to their public Doctor profile. */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('doctor_id')->nullable()->after('role_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('doctor_id');
        });
    }
};
