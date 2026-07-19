<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('role')->nullable();       // short title shown on list card, e.g. "Cardiologist"
            $table->string('photo')->nullable();
            $table->string('specialty')->nullable();   // e.g. "Gynecology"
            $table->string('degrees')->nullable();      // e.g. "MD, Aesthetic & Reconstructive Medical"
            $table->string('experience')->nullable();   // e.g. "30 years, New York Urgent Medical Care"
            $table->string('awards')->nullable();        // e.g. "World Medical Congress – 2023"
            $table->longText('bio')->nullable();          // rich text detail-page description
            $table->json('skills')->nullable();            // "Professional Skills" checklist
            $table->json('schedule')->nullable();           // [{day, time}]
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->string('seo_og_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
