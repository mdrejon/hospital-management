<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->categories() as $i => $category) {
            $slug = Str::slug($category['name']['en']);

            BlogCategory::updateOrCreate(
                ['slug' => $slug],
                array_merge($category, ['slug' => $slug, 'sort_order' => $i + 1, 'is_active' => true])
            );
        }
    }

    private function categories(): array
    {
        return [
            [
                'name' => ['en' => 'Health Tips', 'bn' => 'স্বাস্থ্য পরামর্শ'],
                'description' => [
                    'en' => 'Practical tips for staying healthy every day.',
                    'bn' => 'প্রতিদিনের সুস্বাস্থ্য বজায় রাখার ব্যবহারিক পরামর্শ।',
                ],
            ],
            [
                'name' => ['en' => 'Maternal & Child Care', 'bn' => 'মা ও শিশু স্বাস্থ্য'],
                'description' => [
                    'en' => 'Guidance for expecting mothers and newborn care.',
                    'bn' => 'গর্ভবতী মা ও নবজাতকের যত্নের জন্য দিকনির্দেশনা।',
                ],
            ],
            [
                'name' => ['en' => 'Hospital News', 'bn' => 'হাসপাতালের খবর'],
                'description' => [
                    'en' => 'Updates, events and news from Sitakund Modern Hospital Ltd.',
                    'bn' => 'সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ এর সর্বশেষ খবর ও আপডেট।',
                ],
            ],
        ];
    }
}
