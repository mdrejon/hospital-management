<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->testimonials() as $i => $testimonial) {
            Testimonial::updateOrCreate(
                ['name' => $testimonial['name'], 'sort_order' => $i + 1],
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
                    'en' => 'I had my delivery at Sitakund Modern Hospital and the care from the doctors and nurses was excellent. They explained everything clearly and made me feel safe throughout.',
                    'bn' => 'আমি সীতাকুণ্ড মডার্ণ হসপিটালে আমার ডেলিভারী করিয়েছি এবং ডাক্তার ও নার্সদের সেবা ছিল অসাধারণ। তারা সবকিছু পরিষ্কারভাবে বুঝিয়ে দিয়েছেন এবং আমাকে নিরাপদ বোধ করিয়েছেন।',
                ],
                'is_active' => true,
            ],
            [
                'name'   => 'Md. Kamal Uddin',
                'role'   => ['en' => 'Patient', 'bn' => 'রোগী'],
                'rating' => 5,
                'review' => [
                    'en' => 'The 24-hour emergency and ambulance service saved precious time when my father needed urgent care. The staff were quick, professional and caring.',
                    'bn' => '২৪ ঘন্টা জরুরী বিভাগ ও এম্বুলেন্স সার্ভিস আমার বাবার জরুরী মুহূর্তে অনেক সময় বাঁচিয়েছে। স্টাফরা দ্রুত, পেশাদার ও যত্নশীল ছিলেন।',
                ],
                'is_active' => true,
            ],
            [
                'name'   => 'Sultana Akter',
                'role'   => ['en' => 'Patient', 'bn' => 'রোগী'],
                'rating' => 5,
                'review' => [
                    'en' => 'The digital ultrasonography and pathology reports were accurate and quick. I did not need to travel all the way to Chattogram city for tests anymore.',
                    'bn' => 'ডিজিটাল আল্ট্রাসোনোগ্রাফী ও প্যাথলজি রিপোর্ট নির্ভুল ও দ্রুত পেয়েছি। পরীক্ষার জন্য আর চট্টগ্রাম শহরে যেতে হয়নি।',
                ],
                'is_active' => true,
            ],
            [
                'name'   => 'Abdul Karim',
                'role'   => ['en' => 'Patient', 'bn' => 'রোগী'],
                'rating' => 4,
                'review' => [
                    'en' => 'Affordable treatment with a 10% discount on medicines and a friendly pharmacy staff. Grateful to have such a facility close to home.',
                    'bn' => 'সাশ্রয়ী চিকিৎসা, ওষুধে ১০% ডিসকাউন্ট এবং বন্ধুত্বপূর্ণ ফার্মেসী স্টাফ। বাড়ির কাছেই এমন একটি প্রতিষ্ঠান পেয়ে কৃতজ্ঞ।',
                ],
                'is_active' => true,
            ],
        ];
    }
}
