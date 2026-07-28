<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PackageSeeder extends Seeder
{
    /**
     * Health packages derived from the hospital's actual service list (pathology, ultrasonography,
     * ECG, diabetic center, etc.) — not third-party sourced pricing.
     */
    public function run(): void
    {
        foreach ($this->packages() as $i => $package) {
            $slug = Str::slug($package['title']['en']);

            Package::updateOrCreate(
                ['slug' => $slug],
                array_merge($package, [
                    'slug'       => $slug,
                    'sort_order' => $i + 1,
                    'is_active'  => true,
                ])
            );
        }
    }

    private function packages(): array
    {
        return [
            [
                'title' => ['en' => 'Full Body Checkup Package', 'bn' => 'ফুল বডি চেকআপ প্যাকেজ'],
                'short_desc' => [
                    'en' => 'A comprehensive health screening covering blood tests, ECG and ultrasonography.',
                    'bn' => 'রক্ত পরীক্ষা, ই.সি.জি ও আল্ট্রাসোনোগ্রাফীসহ একটি পূর্ণাঙ্গ স্বাস্থ্য পরীক্ষা প্যাকেজ।',
                ],
                'description' => [
                    'en' => 'Our Full Body Checkup Package combines pathology, biochemistry, ECG and digital 4-D ultrasonography to give you a complete picture of your health, reviewed by our specialist physicians.',
                    'bn' => 'আমাদের ফুল বডি চেকআপ প্যাকেজে প্যাথলজি, বায়োকেমিস্ট্রি, ই.সি.জি ও ডিজিটাল ৪-ডি আল্ট্রাসোনোগ্রাফী একসাথে করা হয়, যা আমাদের বিশেষজ্ঞ চিকিৎসকদের দ্বারা পর্যালোচনা করা হয়।',
                ],
                'features' => [
                    ['en' => 'Complete Blood Count (CBC)', 'bn' => 'সম্পূর্ণ রক্ত পরীক্ষা (সিবিসি)'],
                    ['en' => 'ECG & Blood Sugar Test', 'bn' => 'ই.সি.জি ও রক্তে সুগার পরীক্ষা'],
                    ['en' => 'Abdominal Ultrasonography', 'bn' => 'পেটের আল্ট্রাসোনোগ্রাফী'],
                    ['en' => 'Physician Consultation', 'bn' => 'ডাক্তারের পরামর্শ'],
                ],
                'badge_value' => '10%',
                'badge_label' => ['en' => 'Discount', 'bn' => 'ছাড়'],
                'is_featured' => true,
            ],
            [
                'title' => ['en' => 'Antenatal Care Package', 'bn' => 'গর্ভকালীন সেবা প্যাকেজ'],
                'short_desc' => [
                    'en' => 'Complete pregnancy care from checkup to delivery, guided by our Gynecology & Obstetrics team.',
                    'bn' => 'আমাদের স্ত্রীরোগ ও ধাত্রীবিদ্যা বিভাগের তত্ত্বাবধানে চেকআপ থেকে ডেলিভারী পর্যন্ত সম্পূর্ণ গর্ভকালীন সেবা।',
                ],
                'description' => [
                    'en' => 'Regular antenatal checkups, 4-D ultrasonography, and delivery care (normal or caesarean) under the supervision of our experienced Gynecology & Obstetrics surgeon.',
                    'bn' => 'আমাদের অভিজ্ঞ স্ত্রীরোগ ও ধাত্রীবিদ্যা সার্জনের তত্ত্বাবধানে নিয়মিত গর্ভকালীন চেকআপ, ৪-ডি আল্ট্রাসোনোগ্রাফী এবং ডেলিভারী (নরমাল বা সিজার) সেবা।',
                ],
                'features' => [
                    ['en' => 'Monthly Antenatal Checkup', 'bn' => 'মাসিক গর্ভকালীন চেকআপ'],
                    ['en' => '4-D Ultrasonography', 'bn' => '৪-ডি আল্ট্রাসোনোগ্রাফী'],
                    ['en' => 'Normal Delivery / Caesarean', 'bn' => 'নরমাল ডেলিভারী / সিজার'],
                    ['en' => 'Postnatal Follow-up', 'bn' => 'প্রসব পরবর্তী ফলো-আপ'],
                ],
                'badge_value' => null,
                'badge_label' => ['en' => 'Popular', 'bn' => 'জনপ্রিয়'],
                'is_featured' => true,
            ],
            [
                'title' => ['en' => 'Diabetic Care Package', 'bn' => 'ডায়াবেটিক কেয়ার প্যাকেজ'],
                'short_desc' => [
                    'en' => 'Regular diabetes monitoring and consultation from our Diabetic Center.',
                    'bn' => 'আমাদের ডায়াবেটিক সেন্টার থেকে নিয়মিত ডায়াবেটিস পর্যবেক্ষণ ও পরামর্শ সেবা।',
                ],
                'description' => [
                    'en' => 'Blood sugar monitoring, HbA1c testing and consultation with a certified diabetologist, designed for long-term diabetes management.',
                    'bn' => 'রক্তে সুগার পর্যবেক্ষণ, এইচবিএ১সি পরীক্ষা এবং সার্টিফাইড ডায়াবেটোলজিস্টের পরামর্শসহ দীর্ঘমেয়াদী ডায়াবেটিস ব্যবস্থাপনার জন্য এই প্যাকেজ তৈরি।',
                ],
                'features' => [
                    ['en' => 'Fasting & Random Blood Sugar', 'bn' => 'ফাস্টিং ও র‍্যান্ডম ব্লাড সুগার'],
                    ['en' => 'HbA1c Test', 'bn' => 'এইচবিএ১সি পরীক্ষা'],
                    ['en' => 'Diabetologist Consultation', 'bn' => 'ডায়াবেটোলজিস্টের পরামর্শ'],
                ],
                'badge_value' => null,
                'badge_label' => ['en' => 'Ongoing Care', 'bn' => 'নিয়মিত পরিচর্যা'],
                'is_featured' => false,
            ],
            [
                'title' => ['en' => 'Emergency & Ambulance Care Package', 'bn' => 'জরুরী ও এম্বুলেন্স সেবা প্যাকেজ'],
                'short_desc' => [
                    'en' => '24-hour emergency response with ambulance pickup for critical situations.',
                    'bn' => 'জরুরী পরিস্থিতিতে এম্বুলেন্স পিকআপসহ ২৪ ঘন্টা জরুরী সেবা।',
                ],
                'description' => [
                    'en' => 'Round-the-clock emergency department access with ambulance service, immediate physician assessment and access to our on-site pharmacy and pathology lab.',
                    'bn' => 'এম্বুলেন্স সার্ভিসসহ ২৪ ঘন্টা জরুরী বিভাগের সুবিধা, তাৎক্ষণিক চিকিৎসক মূল্যায়ন এবং হাসপাতাল প্রাঙ্গণে ফার্মেসী ও প্যাথলজি ল্যাবের সুবিধা।',
                ],
                'features' => [
                    ['en' => '24/7 Ambulance Pickup', 'bn' => '২৪/৭ এম্বুলেন্স পিকআপ'],
                    ['en' => 'Immediate Physician Assessment', 'bn' => 'তাৎক্ষণিক চিকিৎসক মূল্যায়ন'],
                    ['en' => 'On-site Pharmacy & Lab', 'bn' => 'হাসপাতাল প্রাঙ্গণে ফার্মেসী ও ল্যাব'],
                ],
                'badge_value' => '24/7',
                'badge_label' => ['en' => 'Always Open', 'bn' => 'সবসময় খোলা'],
                'is_featured' => false,
            ],
        ];
    }
}
