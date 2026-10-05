<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        // Clean up old FAQs before seeding
        DB::table('faqs')->truncate();

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
                    'en' => 'Answers to common questions about our diagnostic center, services, and appointments.',
                    'bn' => 'আমাদের ডায়াগনস্টিক সেন্টার, সেবা ও সিরিয়াল সম্পর্কিত সাধারণ প্রশ্নের উত্তর।',
                ],
                'items' => [
                    [
                        'question' => ['en' => 'What are your opening hours?', 'bn' => 'আপনাদের সেবার সময়সূচী কী?'],
                        'answer'   => [
                            'en' => 'Our diagnostic center is open every day from 8:00 AM to 8:00 PM.',
                            'bn' => 'আমাদের ডায়াগনস্টিক সেন্টার প্রতিদিন সকাল ৮টা থেকে রাত ৮টা পর্যন্ত খোলা থাকে।',
                        ],
                    ],
                    [
                        'question' => ['en' => 'How can I book a serial for a doctor?', 'bn' => 'কীভাবে ডাক্তারের সিরিয়াল নেব?'],
                        'answer'   => [
                            'en' => 'You can easily book a serial for our specialist doctors by calling us at 01711-307275.',
                            'bn' => 'আমাদের বিশেষজ্ঞ ডাক্তারদের সিরিয়াল নিতে 01711-307275 নম্বরে কল করতে পারেন।',
                        ],
                    ],
                    [
                        'question' => ['en' => 'What diagnostic tests are available?', 'bn' => 'কী কী ডায়াগনস্টিক পরীক্ষা করা যায়?'],
                        'answer'   => [
                            'en' => 'We offer Digital X-Ray, Pathology, ECG, Echocardiography, Ultrasonogram, Hormone Analysis, and Biochemistry tests.',
                            'bn' => 'আমাদের এখানে ডিজিটাল এক্স-রে, প্যাথলজি, ই.সি.জি, ইকোকার্ডিওগ্রাফি, আল্ট্রাসনোগ্রাম, হরমোন এনালাইসিস এবং বায়োকেমিস্ট্রি পরীক্ষা করা হয়।',
                        ],
                    ],
                    [
                        'question' => ['en' => 'Do you provide home services?', 'bn' => 'আপনারা কি হোম সার্ভিস প্রদান করেন?'],
                        'answer'   => [
                            'en' => 'Yes, we offer convenient home services for sample collection and medical checkups.',
                            'bn' => 'হ্যাঁ, আমরা রোগীদের সুবিধার্থে বাসায় গিয়ে স্যাম্পল কালেকশন ও স্বাস্থ্য পরীক্ষার হোম সার্ভিস প্রদান করি।',
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
                    'en' => 'Learn more about Medicare Lab Diagnostic Center and our commitment.',
                    'bn' => 'মেডিকেয়ার ল্যাব ডায়াগনস্টিক সেন্টার এবং আমাদের প্রতিশ্রুতি সম্পর্কে জানুন।',
                ],
                'items' => [
                    [
                        'question' => ['en' => 'Why choose Medicare Lab?', 'bn' => 'কেন মেডিকেয়ার ল্যাব বেছে নেবেন?'],
                        'answer'   => [
                            'en' => 'We provide reliable and quality medical services using modern lab facilities and experienced doctors.',
                            'bn' => 'আমরা আধুনিক ল্যাব সুবিধা ও অভিজ্ঞ চিকিৎসকদের মাধ্যমে নির্ভরযোগ্য ও মানসম্পন্ন চিকিৎসাসেবা প্রদান করি।',
                        ],
                    ],
                    [
                        'question' => ['en' => 'Are there specialist doctors available?', 'bn' => 'আপনাদের এখানে কি বিশেষজ্ঞ ডাক্তার বসেন?'],
                        'answer'   => [
                            'en' => 'Yes, we have a dedicated specialist doctor chamber where experienced physicians provide regular medical services.',
                            'bn' => 'হ্যাঁ, আমাদের বিশেষজ্ঞ ডাক্তারের চেম্বারে অভিজ্ঞ চিকিৎসকরা নিয়মিত চিকিৎসাসেবা প্রদান করেন।',
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
                    'en' => 'Everything you need to know about our medical center and testing facilities.',
                    'bn' => 'আমাদের ডায়াগনস্টিক সেন্টার ও পরীক্ষার সুবিধা সম্পর্কে যা জানা প্রয়োজন।',
                ],
                'items' => [
                    [
                        'question' => ['en' => 'Where is Medicare Lab located?', 'bn' => 'মেডিকেয়ার ল্যাব কোথায় অবস্থিত?'],
                        'answer'   => [
                            'en' => 'We are located at Ali Market, Sitakunda Bazar, Chattogram.',
                            'bn' => 'আমরা আলী মার্কেট, সীতাকুন্ড বাজার, চট্টগ্রাম-এ অবস্থিত।',
                        ],
                    ],
                    [
                        'question' => ['en' => 'Do you provide medical checkups for going abroad?', 'bn' => 'বিদেশগামী মেডিকেল চেকআপ করা যায় কি?'],
                        'answer'   => [
                            'en' => 'Yes, we offer comprehensive medical checkups specifically designed for passengers going abroad.',
                            'bn' => 'হ্যাঁ, আমাদের এখানে বিদেশগামী যাত্রীদের জন্য সম্পূর্ণ মেডিকেল চেকআপের সুবিধা রয়েছে।',
                        ],
                    ],
                    [
                        'question' => ['en' => 'Is vaccination service available?', 'bn' => 'টিকাদানের সুবিধা আছে কি?'],
                        'answer'   => [
                            'en' => 'Yes, we provide vaccination services administered by our experienced medical team.',
                            'bn' => 'হ্যাঁ, আমাদের এখানে অভিজ্ঞ ডাক্তার দ্বারা টিকাদানের ব্যবস্থা রয়েছে।',
                        ],
                    ],
                ],
                'is_active' => true,
            ],
        ];
    }
}
