<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Uploaded seal artwork. When set it replaces the built-in `seal_variant`
     * SVG on both the Home slider and the Achievements page.
     */
    public function up(): void
    {
        Schema::table('awards', function (Blueprint $table) {
            $table->string('seal_image')->nullable()->after('link_url');
        });
    }

    public function down(): void
    {
        Schema::table('awards', function (Blueprint $table) {
            $table->dropColumn('seal_image');
        });
    }
};
