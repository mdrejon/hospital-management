<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('facilities');

        DB::table('global_settings')->where('key', 'like', 'fac_%')->delete();
    }

    public function down(): void
    {
        // Irreversible — the Facilities feature and its schema were removed from the application.
    }
};
