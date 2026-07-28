<?php

namespace Database\Seeders;

use App\Models\Award;
use Illuminate\Database\Seeder;

class AwardSeeder extends Seeder
{
    /**
     * Service milestones from the hospital's own history (not third-party certifications).
     */
    public function run(): void
    {
        foreach ($this->awards() as $i => $award) {
            Award::updateOrCreate(
                ['sort_order' => $i + 1],
                array_merge($award, ['sort_order' => $i + 1])
            );
        }
    }

    private function awards(): array
    {
        return [
            [
                'title' => ['en' => '12+ Years of Service', 'bn' => '১২+ বছরের সেবা'],
                'subtitle' => ['en' => 'Serving Sitakund since 2013', 'bn' => '২০১৩ সাল থেকে সীতাকুণ্ডবাসীর সেবায়'],
                'link_text' => ['en' => 'Continuous Community Healthcare', 'bn' => 'নিরবচ্ছিন্ন কমিউনিটি স্বাস্থ্যসেবা'],
                'link_url' => '/history',
                'seal_variant' => 1,
                'is_active' => true,
            ],
            [
                'title' => ['en' => 'Free Medical Camps', 'bn' => 'ফ্রি মেডিকেল ক্যাম্প'],
                'subtitle' => ['en' => 'Monthly union-based free medical camps', 'bn' => 'ইউনিয়ন ভিত্তিক মাসিক ফ্রি মেডিকেল ক্যাম্প'],
                'link_text' => ['en' => 'Over 23,000+ Patients Served Free', 'bn' => '২৩,০০০+ রোগীকে বিনামূল্যে সেবা প্রদান'],
                'link_url' => '/achievements',
                'seal_variant' => 2,
                'is_active' => true,
            ],
            [
                'title' => ['en' => '24-Hour Emergency Care', 'bn' => '২৪ ঘন্টা জরুরী সেবা'],
                'subtitle' => ['en' => 'Round-the-clock emergency, pharmacy & ambulance', 'bn' => 'সার্বক্ষণিক জরুরী বিভাগ, ফার্মেসী ও এম্বুলেন্স'],
                'link_text' => ['en' => 'Always Open, Always Ready', 'bn' => 'সবসময় প্রস্তুত'],
                'link_url' => '/services',
                'seal_variant' => 3,
                'is_active' => true,
            ],
        ];
    }
}
