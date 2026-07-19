<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * These fields don't correspond to anything in the current service-details
     * page template (no "benefits" section, no gallery, no per-service button
     * text) — leftover from the old hotel-site service schema.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'benefits_title', 'benefits_text',
                'gallery_image_1', 'gallery_image_2',
                'btn_text', 'btn_url',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('benefits_title')->default('We Give The Best Services');
            $table->longText('benefits_text')->nullable();
            $table->string('gallery_image_1')->nullable();
            $table->string('gallery_image_2')->nullable();
            $table->string('btn_text', 60)->default('View Services');
            $table->string('btn_url', 255)->default('#');
        });
    }
};
