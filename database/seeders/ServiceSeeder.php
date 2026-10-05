<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    /**
     * Seed content sourced from the updated services banner.
     */
    public function run(): void
    {
        $services = $this->services();
        $newSlugs = [];

        foreach ($services as $i => $service) {
            $title = $service['title'];
            $slug  = Str::slug($title['en']);
            $newSlugs[] = $slug;

            Service::updateOrCreate(
                ['slug' => $slug],
                [
                    'title'        => $title,
                    'slug'         => $slug,
                    'short_desc'   => $service['short_desc'],
                    'description'  => $service['short_desc'],
                    'is_featured'  => $i < 6, // feature the first 6
                    'sort_order'   => $i + 1,
                    'is_active'    => true,
                ]
            );
        }

        // Delete all other services not present in the new list
        Service::whereNotIn('slug', $newSlugs)->delete();
    }

    private function services(): array
    {
        return [
            [
                'title' => ['en' => 'Digital X-Ray', 'bn' => 'ডিজিটাল এক্স-রে'],
                'short_desc' => [
                    'en' => 'Digital X-Ray service open 24 hours.',
                    'bn' => 'ডিজিটাল এক্স-রে সেবা ২৪ ঘন্টা খোলা থাকে।',
                ],
            ],
            [
                'title' => ['en' => 'Pathology', 'bn' => 'প্যাথলজি'],
                'short_desc' => [
                    'en' => 'Fully equipped pathology laboratory for all types of tests.',
                    'bn' => 'সকল প্রকার পরীক্ষার জন্য সুসজ্জিত প্যাথলজি ল্যাব রয়েছে।',
                ],
            ],
            [
                'title' => ['en' => 'ECG', 'bn' => 'ই.সি.জি'],
                'short_desc' => [
                    'en' => 'ECG (Electrocardiogram) service open 24 hours.',
                    'bn' => 'ই.সি.জি সেবা ২৪ ঘন্টা খোলা থাকে।',
                ],
            ],
            [
                'title' => ['en' => 'Echocardiography', 'bn' => 'ইকোকার্ডিওগ্রাফি'],
                'short_desc' => [
                    'en' => 'Echocardiography (ECHO) test for heart diagnosis.',
                    'bn' => 'হৃদরোগ নির্ণয়ে ইকোকার্ডিওগ্রাফি পরীক্ষার সুবিধা রয়েছে।',
                ],
            ],
            [
                'title' => ['en' => 'Ultrasonogram', 'bn' => 'আল্ট্রাসনোগ্রাম'],
                'short_desc' => [
                    'en' => 'Advanced ultrasonogram for accurate diagnosis.',
                    'bn' => 'নির্ভুল রোগ নির্ণয়ে আল্ট্রাসনোগ্রাম সুবিধা রয়েছে।',
                ],
            ],
            [
                'title' => ['en' => 'Hormone Analysis', 'bn' => 'হরমোন এনালাইসিস'],
                'short_desc' => [
                    'en' => 'Hormone testing services.',
                    'bn' => 'হরমোন পরীক্ষার সুবিধা রয়েছে।',
                ],
            ],
            [
                'title' => ['en' => 'Biochemistry', 'bn' => 'বায়োকেমিস্ট্রি'],
                'short_desc' => [
                    'en' => 'Automated biochemistry analysis for fast, accurate lab results.',
                    'bn' => 'অটো অ্যানালাইজারের মাধ্যমে দ্রুত ও নির্ভুল বায়োকেমিস্ট্রি পরীক্ষা।',
                ],
            ],
            [
                'title' => ['en' => 'Vaccination', 'bn' => 'টিকাদান'],
                'short_desc' => [
                    'en' => 'Vaccination administered by experienced doctors.',
                    'bn' => 'অভিজ্ঞ ডাক্তার দ্বারা টিকাদান করা হয়।',
                ],
            ],
            [
                'title' => ['en' => 'Foreign Medical Checkup', 'bn' => 'বিদেশগামী মেডিকেল চেকআপ'],
                'short_desc' => [
                    'en' => 'Comprehensive medical checkup for passengers going abroad.',
                    'bn' => 'বিদেশগামী যাত্রীদের জন্য সম্পূর্ণ মেডিকেল চেকআপের সুবিধা রয়েছে।',
                ],
            ],
            [
                'title' => ['en' => 'Home Service', 'bn' => 'হোম সার্ভিস'],
                'short_desc' => [
                    'en' => 'Convenient home service for sample collection and testing.',
                    'bn' => 'রোগীদের সুবিধার্থে বাসায় গিয়ে স্যাম্পল কালেকশন ও স্বাস্থ্য পরীক্ষা সেবা।',
                ],
            ],
            [
                'title' => ['en' => 'Specialist Doctor Chamber', 'bn' => 'বিশেষজ্ঞ ডাক্তারের চেম্বার'],
                'short_desc' => [
                    'en' => 'Daily chamber with specialist doctors for consultation.',
                    'bn' => 'প্রতিদিন বিশেষজ্ঞ ডাক্তার চেম্বারে রোগী দেখা হয়।',
                ],
            ],
        ];
    }
}
