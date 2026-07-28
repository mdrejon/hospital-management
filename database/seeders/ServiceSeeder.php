<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    /**
     * Seed content sourced from the Sitakund Modern Hospital Ltd. print brochure's service list.
     */
    public function run(): void
    {
        foreach ($this->services() as $i => $service) {
            $title = $service['title'];
            $slug  = Str::slug($title['en']);

            Service::updateOrCreate(
                ['slug' => $slug],
                [
                    'title'        => $title,
                    'slug'         => $slug,
                    'short_desc'   => $service['short_desc'],
                    'description'  => $service['short_desc'],
                    'is_featured'  => $i < 6,
                    'sort_order'   => $i + 1,
                    'is_active'    => true,
                ]
            );
        }
    }

    private function services(): array
    {
        return [
            [
                'title' => ['en' => 'Emergency Department', 'bn' => 'জরুরী বিভাগ'],
                'short_desc' => [
                    'en' => 'Emergency department open 24 hours a day for immediate patient care.',
                    'bn' => 'জরুরী বিভাগ ২৪ ঘন্টা খোলা থাকে জরুরী রোগীদের সেবা দেওয়ার জন্য।',
                ],
            ],
            [
                'title' => ['en' => 'Pharmacy', 'bn' => 'ফার্মেসী'],
                'short_desc' => [
                    'en' => 'Pharmacy open 24 hours, stocking all types of genuine medicines and vaccines.',
                    'bn' => 'ফার্মেসী ২৪ ঘন্টা খোলা থাকে, সকল প্রকার ন্যায্য মূল্যে ঔষধ ও ভ্যাকসিন পাওয়া যায়।',
                ],
            ],
            [
                'title' => ['en' => 'Ambulance Service', 'bn' => 'এম্বুলেন্স সার্ভিস'],
                'short_desc' => [
                    'en' => '24-hour ambulance service for patient transport.',
                    'bn' => '২৪ ঘন্টা এম্বুলেন্স সার্ভিস চালু রয়েছে।',
                ],
            ],
            [
                'title' => ['en' => 'Specialist Doctor Chamber', 'bn' => 'বিশেষজ্ঞ ডাক্তার চেম্বার'],
                'short_desc' => [
                    'en' => 'Daily chamber with specialist doctors for consultation.',
                    'bn' => 'প্রতিদিন বিশেষজ্ঞ ডাক্তার চেম্বারে রোগী দেখা হয়।',
                ],
            ],
            [
                'title' => ['en' => 'Digital 4-D Color Ultrasonography', 'bn' => 'ডিজিটাল ৪-ডি কালার আল্ট্রাসোনোগ্রাফী'],
                'short_desc' => [
                    'en' => 'Advanced digital 4-D color ultrasonography for accurate diagnosis.',
                    'bn' => 'ডিজিটাল ৪-ডি কালার আল্ট্রাসোনোগ্রাফীর মাধ্যমে নির্ভুল পরীক্ষা করা হয়।',
                ],
            ],
            [
                'title' => ['en' => 'Echocardiography', 'bn' => 'ইকোকার্ডিওগ্রাফী'],
                'short_desc' => [
                    'en' => 'Echocardiography (ECHO) test for heart diagnosis.',
                    'bn' => 'হৃদরোগ নির্ণয়ে ইকোকার্ডিওগ্রাফী পরীক্ষার সুবিধা রয়েছে।',
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
                'title' => ['en' => 'Digital X-Ray', 'bn' => 'ডিজিটাল এক্স-রে'],
                'short_desc' => [
                    'en' => 'Digital X-Ray service open 24 hours.',
                    'bn' => 'ডিজিটাল এক্স-রে সেবা ২৪ ঘন্টা খোলা থাকে।',
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
                'title' => ['en' => 'Nebulization', 'bn' => 'নেবুলাইজেশন'],
                'short_desc' => [
                    'en' => 'Nebulization treatment for respiratory patients.',
                    'bn' => 'শ্বাসকষ্টের রোগীদের জন্য নেবুলাইজেশন সেবা।',
                ],
            ],
            [
                'title' => ['en' => 'Incubator', 'bn' => 'ইনকিউবেটর'],
                'short_desc' => [
                    'en' => 'Incubator facility for newborn care.',
                    'bn' => 'নবজাতকের যত্নের জন্য ইনকিউবেটর সুবিধা।',
                ],
            ],
            [
                'title' => ['en' => 'Biochemistry (Auto Analyzer)', 'bn' => 'বায়োকেমিস্ট্রি (অটো অ্যানালাইজার)'],
                'short_desc' => [
                    'en' => 'Automated biochemistry analysis for fast, accurate lab results.',
                    'bn' => 'অটো অ্যানালাইজারের মাধ্যমে দ্রুত ও নির্ভুল বায়োকেমিস্ট্রি পরীক্ষা।',
                ],
            ],
            [
                'title' => ['en' => 'Microbiology', 'bn' => 'মাইক্রোবায়োলজী'],
                'short_desc' => [
                    'en' => 'Microbiology testing services.',
                    'bn' => 'মাইক্রোবায়োলজী পরীক্ষার সুবিধা রয়েছে।',
                ],
            ],
            [
                'title' => ['en' => 'Serology', 'bn' => 'সেরোলজী'],
                'short_desc' => [
                    'en' => 'Serology testing services.',
                    'bn' => 'সেরোলজী পরীক্ষার সুবিধা রয়েছে।',
                ],
            ],
            [
                'title' => ['en' => 'Diabetic Center', 'bn' => 'ডায়াবেটিক সেন্টার'],
                'short_desc' => [
                    'en' => 'Dedicated diabetic center for diagnosis and management of diabetes.',
                    'bn' => 'ডায়াবেটিস নির্ণয় ও ব্যবস্থাপনার জন্য আলাদা ডায়াবেটিক সেন্টার।',
                ],
            ],
            [
                'title' => ['en' => "Women's Operations & Caesarean", 'bn' => 'সিজারিয়ানসহ মহিলাদের অপারেশন'],
                'short_desc' => [
                    'en' => 'Caesarean section and all types of operations for women.',
                    'bn' => 'সিজারিয়ান সহ মহিলাদের যাবতীয় অপারেশন করা হয়।',
                ],
            ],
            [
                'title' => ['en' => 'General Surgery', 'bn' => 'জেনারেল সার্জারী'],
                'short_desc' => [
                    'en' => 'All types of general surgery operations.',
                    'bn' => 'জেনারেল সার্জারীর যাবতীয় অপারেশন করা হয়।',
                ],
            ],
            [
                'title' => ['en' => 'ENT (Nose, Ear & Throat) Operations', 'bn' => 'নাক, কান ও গলা রোগীদের অপারেশন'],
                'short_desc' => [
                    'en' => 'Operations for nose, ear and throat patients.',
                    'bn' => 'নাক, কান ও গলা রোগীদের অপারেশন করা হয়।',
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
                'title' => ['en' => 'Phototherapy', 'bn' => 'ফটোথেরাপি'],
                'short_desc' => [
                    'en' => 'Phototherapy treatment for newborns with jaundice.',
                    'bn' => 'নবজাতকদের জন্য ফটোথেরাপি সেবা।',
                ],
            ],
            [
                'title' => ['en' => 'Physiotherapy', 'bn' => 'ফিজিওথেরাপী'],
                'short_desc' => [
                    'en' => 'Physiotherapy services for rehabilitation and pain management.',
                    'bn' => 'ফিজিওথেরাপী সেবা প্রদান করা হয়।',
                ],
            ],
            [
                'title' => ['en' => 'Hormone Test', 'bn' => 'হরমোন পরীক্ষা'],
                'short_desc' => [
                    'en' => 'Hormone testing services.',
                    'bn' => 'হরমোন পরীক্ষার সুবিধা রয়েছে।',
                ],
            ],
        ];
    }
}
