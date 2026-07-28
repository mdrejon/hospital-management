<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            LanguageSeeder::class,
            GlobalSettingSeeder::class,
            DoctorSeeder::class,
            ServiceSeeder::class,
            SliderSeeder::class,
            AwardSeeder::class,
            TestimonialSeeder::class,
            FaqSeeder::class,
            BlogCategorySeeder::class,
            BlogSeeder::class,
            GalleryImageSeeder::class,
            ManagementMemberSeeder::class,
            PageSeeder::class,
            PackageSeeder::class,
        ]);
    }
}
