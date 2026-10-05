<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('testimonials')->truncate();

        foreach ($this->testimonials() as $i => $testimonial) {
            Testimonial::updateOrCreate(
                ['name' => $testimonial['name']],
                array_merge($testimonial, ['sort_order' => $i + 1])
            );
        }
    }

    private function testimonials(): array
    {
        return [
            [
                'name'   => 'Rahima Begum',
                'role'   => ['en' => 'Patient', 'bn' => 'রোগী'],
                'rating' => 5,
                'review' => [
                    'en' => 'I visited the specialist doctor chamber at Medicare Lab. The doctor was very patient and explained everything clearly. The environment was clean and welcoming.',
                    'bn' => 'আমি মেডিকেয়ার ল্যাবে বিশেষজ্ঞ ডাক্তারের চেম্বারে দেখিয়েছিলাম। ডাক্তার খুব যত্ন সহকারে দেখেছেন এবং সবকিছু বুঝিয়ে বলেছেন। পরিবেশ খুবই পরিষ্কার ও সুন্দর ছিল।',
                ],
                'is_active' => true,
            ],
            [
                'name'   => 'Md. Kamal Uddin',
                'role'   => ['en' => 'Patient', 'bn' => 'রোগী'],
                'rating' => 5,
                'review' => [
                    'en' => 'The home service for sample collection is a blessing. The staff came to my house on time and took the samples professionally. Highly recommended!',
                    'bn' => 'স্যাম্পল কালেকশনের জন্য হোম সার্ভিস সত্যিই একটি আশীর্বাদ। স্টাফরা সঠিক সময়ে বাসায় এসে খুব পেশাদারিত্বের সাথে স্যাম্পল নিয়েছেন। আমি সবাইকে সুপারিশ করব!',
                ],
                'is_active' => true,
            ],
            [
                'name'   => 'Sultana Akter',
                'role'   => ['en' => 'Patient', 'bn' => 'রোগী'],
                'rating' => 5,
                'review' => [
                    'en' => 'The digital ultrasonography and pathology reports from Medicare Lab were accurate and delivered quickly. I did not need to travel to Chattogram city for my tests.',
                    'bn' => 'মেডিকেয়ার ল্যাবের ডিজিটাল আল্ট্রাসনোগ্রাম ও প্যাথলজি রিপোর্ট নির্ভুল এবং খুব দ্রুত পেয়েছি। পরীক্ষার জন্য আমাকে আর চট্টগ্রাম শহরে যেতে হয়নি।',
                ],
                'is_active' => true,
            ],
            [
                'name'   => 'Abdul Karim',
                'role'   => ['en' => 'Patient', 'bn' => 'রোগী'],
                'rating' => 5,
                'review' => [
                    'en' => 'I did my medical checkup for going abroad at Medicare Lab. The whole process was smooth, hassle-free, and very reliable.',
                    'bn' => 'আমি বিদেশ যাওয়ার জন্য মেডিকেল চেকআপ মেডিকেয়ার ল্যাব থেকেই করেছি। পুরো প্রক্রিয়াটি খুব সুন্দর, ঝামেলামুক্ত এবং অত্যন্ত নির্ভরযোগ্য ছিল।',
                ],
                'is_active' => true,
            ],
        ];
    }
}
