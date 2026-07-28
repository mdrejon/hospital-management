<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->groups() as $group) {
            Faq::updateOrCreate(
                ['page' => $group['page']],
                $group
            );
        }
    }

    private function groups(): array
    {
        return [
            [
                'page'  => 'home',
                'badge' => ['en' => 'FAQ', 'bn' => 'সাধারণ জিজ্ঞাসা'],
                'title' => ['en' => 'Frequently Asked Questions', 'bn' => 'সচরাচর জিজ্ঞাসিত প্রশ্ন'],
                'description' => [
                    'en' => 'Answers to common questions about our hospital, services and appointments.',
                    'bn' => 'আমাদের হাসপাতাল, সেবা ও অ্যাপয়েন্টমেন্ট সম্পর্কিত সাধারণ প্রশ্নের উত্তর।',
                ],
                'items' => [
                    [
                        'question' => ['en' => 'Is the emergency department open 24 hours?', 'bn' => 'জরুরী বিভাগ কি ২৪ ঘন্টা খোলা থাকে?'],
                        'answer'   => [
                            'en' => 'Yes, our emergency department, pharmacy and ambulance service are open 24 hours a day, every day.',
                            'bn' => 'হ্যাঁ, আমাদের জরুরী বিভাগ, ফার্মেসী ও এম্বুলেন্স সার্ভিস প্রতিদিন ২৪ ঘন্টা খোলা থাকে।',
                        ],
                    ],
                    [
                        'question' => ['en' => 'How can I book an appointment with a doctor?', 'bn' => 'কীভাবে ডাক্তারের সাথে অ্যাপয়েন্টমেন্ট নেব?'],
                        'answer'   => [
                            'en' => 'You can book an appointment online through our Appointment page or call us at 01849-727858 / 01974-300824.',
                            'bn' => 'আমাদের অ্যাপয়েন্টমেন্ট পেজ থেকে অনলাইনে বুক করতে পারেন অথবা ০১৮৪৯-৭২৭৮৫৮ / ০১৯৭৪-৩০০৮২১ নম্বরে কল করতে পারেন।',
                        ],
                    ],
                    [
                        'question' => ['en' => 'What diagnostic tests are available?', 'bn' => 'কী কী ডায়াগনস্টিক পরীক্ষা করা যায়?'],
                        'answer'   => [
                            'en' => 'We offer digital 4-D color ultrasonography, ECHO, pathology, digital X-ray, ECG, biochemistry, microbiology, serology and hormone tests.',
                            'bn' => 'আমাদের এখানে ডিজিটাল ৪-ডি কালার আল্ট্রাসোনোগ্রাফী, ইকো, প্যাথলজি, ডিজিটাল এক্স-রে, ই.সি.জি, বায়োকেমিস্ট্রি, মাইক্রোবায়োলজী, সেরোলজী ও হরমোন পরীক্ষা করা হয়।',
                        ],
                    ],
                    [
                        'question' => ['en' => 'Do you provide medicine discounts?', 'bn' => 'ওষুধে কি ছাড় দেওয়া হয়?'],
                        'answer'   => [
                            'en' => 'Yes, our pharmacy offers a 10% discount on medicines for all customers, and additional discounts for registered shareholders.',
                            'bn' => 'হ্যাঁ, আমাদের ফার্মেসীতে সকলের জন্য ওষুধে ১০% ছাড় দেওয়া হয়, এবং নিবন্ধিত শেয়ার হোল্ডারদের জন্য অতিরিক্ত ছাড় রয়েছে।',
                        ],
                    ],
                ],
                'is_active' => true,
            ],
            [
                'page'  => 'about',
                'badge' => ['en' => 'FAQ', 'bn' => 'সাধারণ জিজ্ঞাসা'],
                'title' => ['en' => 'About Us — FAQ', 'bn' => 'আমাদের সম্পর্কে — সাধারণ জিজ্ঞাসা'],
                'description' => [
                    'en' => 'Learn more about our history, mission and the team behind Sitakund Modern Hospital Ltd.',
                    'bn' => 'সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ এর ইতিহাস, লক্ষ্য ও টিম সম্পর্কে আরও জানুন।',
                ],
                'items' => [
                    [
                        'question' => ['en' => 'When was the hospital established?', 'bn' => 'হাসপাতালটি কবে প্রতিষ্ঠিত হয়েছে?'],
                        'answer'   => [
                            'en' => 'Sitakund Modern Hospital Ltd. was established in January 2013 to ensure modern healthcare for the people of Sitakund.',
                            'bn' => 'সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ ২০১৩ সালের জানুয়ারিতে সীতাকুণ্ডবাসীর জন্য আধুনিক স্বাস্থ্যসেবা নিশ্চিত করতে প্রতিষ্ঠিত হয়।',
                        ],
                    ],
                    [
                        'question' => ['en' => 'Is the hospital a registered company?', 'bn' => 'হাসপাতালটি কি একটি নিবন্ধিত প্রতিষ্ঠান?'],
                        'answer'   => [
                            'en' => 'Yes, Sitakund Modern Hospital Ltd. is a registered joint-stock limited company with 12 directors.',
                            'bn' => 'হ্যাঁ, সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ একটি জয়েন্টস্টক কোম্পানীর নিবন্ধিত লিমিটেড কোম্পানী, যাতে পরিচালক আছেন ১২ জন।',
                        ],
                    ],
                    [
                        'question' => ['en' => 'What are the future plans of the hospital?', 'bn' => 'হাসপাতালের ভবিষ্যৎ পরিকল্পনা কী?'],
                        'answer'   => [
                            'en' => 'We are working on establishing our own modern hospital, diagnostic center and nursing college building on newly acquired land.',
                            'bn' => 'আমরা নতুন জায়গায় নিজস্ব ভবনে একটি আধুনিক হাসপাতাল, ডায়াগনস্টিক সেন্টার ও নার্সিং কলেজ গড়ে তোলার কাজ করছি।',
                        ],
                    ],
                ],
                'is_active' => true,
            ],
            [
                'page'  => 'faq',
                'badge' => ['en' => 'Help Center', 'bn' => 'হেল্প সেন্টার'],
                'title' => ['en' => 'Frequently Asked Questions', 'bn' => 'সচরাচর জিজ্ঞাসিত প্রশ্ন'],
                'description' => [
                    'en' => 'Everything you need to know about visiting, treatment and our facilities.',
                    'bn' => 'হাসপাতালে আসা, চিকিৎসা ও আমাদের সুবিধা সম্পর্কে যা জানা প্রয়োজন সবকিছু।',
                ],
                'items' => [
                    [
                        'question' => ['en' => 'Where is the hospital located?', 'bn' => 'হাসপাতালটি কোথায় অবস্থিত?'],
                        'answer'   => [
                            'en' => 'Amirabad (Sitakund South Bypass) 07, Sitakund Municipality, Sitakund, Chattogram.',
                            'bn' => 'আমিরাবাদ (সীতাকুণ্ড দক্ষিণ বাইপাস) ০৭, সীতাকুণ্ড পৌরসভা, সীতাকুণ্ড, চট্টগ্রাম।',
                        ],
                    ],
                    [
                        'question' => ['en' => 'Do you offer free medical camps?', 'bn' => 'ফ্রি মেডিকেল ক্যাম্পের সুবিধা আছে কি?'],
                        'answer'   => [
                            'en' => 'Yes, we organize monthly free medical camps in different unions of Sitakund, along with free blood group and diabetes checkups for students.',
                            'bn' => 'হ্যাঁ, আমরা প্রতি মাসে সীতাকুণ্ডের বিভিন্ন ইউনিয়নে ফ্রি মেডিকেল ক্যাম্প পরিচালনা করি, পাশাপাশি শিক্ষার্থীদের জন্য ফ্রি রক্তের গ্রুপ ও ডায়াবেটিস চেকআপের ব্যবস্থাও রয়েছে।',
                        ],
                    ],
                    [
                        'question' => ['en' => 'Is there parking and ambulance pickup available?', 'bn' => 'পার্কিং ও এম্বুলেন্স পিকআপ সুবিধা আছে কি?'],
                        'answer'   => [
                            'en' => 'Yes, our 24-hour ambulance service can pick up patients, and parking is available on hospital premises.',
                            'bn' => 'হ্যাঁ, আমাদের ২৪ ঘন্টা এম্বুলেন্স সার্ভিস রোগী নিয়ে আসতে পারে, এবং হাসপাতাল প্রাঙ্গণে পার্কিং সুবিধা রয়েছে।',
                        ],
                    ],
                ],
                'is_active' => true,
            ],
        ];
    }
}
