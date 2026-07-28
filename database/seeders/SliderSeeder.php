<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->sliders() as $i => $slider) {
            Slider::updateOrCreate(
                ['sort_order' => $i + 1],
                array_merge($slider, ['sort_order' => $i + 1])
            );
        }
    }

    private function sliders(): array
    {
        return [
            [
                'label' => ['en' => 'Sitakund Modern Hospital Ltd.', 'bn' => 'সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ'],
                'title' => ['en' => 'Human Life, Humane Care', 'bn' => 'মানব জীবন মানবিক হউক'],
                'subtitle' => ['en' => 'Trusted Healthcare Since 2013', 'bn' => '২০১৩ সাল থেকে বিশ্বস্ত স্বাস্থ্যসেবা'],
                'description' => [
                    'en' => 'A modern hospital and diagnostic center serving Sitakund with 24-hour emergency, pharmacy, ambulance and specialist doctor services.',
                    'bn' => '২৪ ঘন্টা জরুরী বিভাগ, ফার্মেসী, এম্বুলেন্স ও বিশেষজ্ঞ ডাক্তারের সেবা নিয়ে সীতাকুণ্ডবাসীর পাশে একটি আধুনিক হাসপাতাল ও ডায়াগনস্টিক সেন্টার।',
                ],
                'button_text' => ['en' => 'Book Appointment', 'bn' => 'অ্যাপয়েন্টমেন্ট নিন'],
                'button_url'  => '/appointment',
                'star_label'  => ['en' => 'Trusted by our patients', 'bn' => 'রোগীদের আস্থার প্রতিষ্ঠান'],
                'star_rating' => 5,
                'is_active'   => true,
            ],
            [
                'label' => ['en' => 'Emergency Care', 'bn' => 'জরুরী সেবা'],
                'title' => ['en' => 'Emergency & Ambulance, 24 Hours', 'bn' => 'জরুরী বিভাগ ও এম্বুলেন্স, ২৪ ঘন্টা'],
                'subtitle' => ['en' => 'We Are Always Here For You', 'bn' => 'আমরা সবসময় আপনার পাশে'],
                'description' => [
                    'en' => 'Emergency department, pharmacy and ambulance service open around the clock, every day of the year.',
                    'bn' => 'জরুরী বিভাগ, ফার্মেসী ও এম্বুলেন্স সার্ভিস সারা বছর ২৪ ঘন্টা খোলা থাকে।',
                ],
                'button_text' => ['en' => 'Contact Us', 'bn' => 'যোগাযোগ করুন'],
                'button_url'  => '/contact',
                'star_label'  => ['en' => '12+ Years of Service', 'bn' => '১২+ বছরের সেবা'],
                'star_rating' => 5,
                'is_active'   => true,
            ],
            [
                'label' => ['en' => 'Diagnostic Center', 'bn' => 'ডায়াগনস্টিক সেন্টার'],
                'title' => ['en' => 'Modern Diagnostic Facilities', 'bn' => 'আধুনিক ডায়াগনস্টিক সুবিধা'],
                'subtitle' => ['en' => 'Digital 4-D Ultrasonography, ECHO, X-Ray & More', 'bn' => 'ডিজিটাল ৪-ডি আল্ট্রাসোনোগ্রাফী, ইকো, এক্স-রে সহ আরও অনেক কিছু'],
                'description' => [
                    'en' => 'Accurate diagnosis with digital 4-D color ultrasonography, ECHO, pathology, 24-hour digital X-ray and ECG.',
                    'bn' => 'ডিজিটাল ৪-ডি কালার আল্ট্রাসোনোগ্রাফী, ইকো, প্যাথলজি, ২৪ ঘন্টা ডিজিটাল এক্স-রে ও ই.সি.জি এর মাধ্যমে নির্ভুল পরীক্ষা।',
                ],
                'button_text' => ['en' => 'Our Services', 'bn' => 'আমাদের সেবাসমূহ'],
                'button_url'  => '/services',
                'star_label'  => ['en' => 'Quality You Can Trust', 'bn' => 'নির্ভরযোগ্য মান'],
                'star_rating' => 5,
                'is_active'   => true,
            ],
        ];
    }
}
