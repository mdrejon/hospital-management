<?php

namespace Database\Seeders;

use App\Models\GalleryImage;
use Illuminate\Database\Seeder;

class GalleryImageSeeder extends Seeder
{
    /**
     * Uses the sample gallery-*.jpg files copied into storage/app/public/gallery.
     */
    public function run(): void
    {
        foreach ($this->images() as $i => $image) {
            GalleryImage::updateOrCreate(
                ['image' => $image['image']],
                array_merge($image, ['sort_order' => $i + 1, 'is_active' => true])
            );
        }
    }

    private function images(): array
    {
        return [
            [
                'image'     => 'gallery/gallery-1.jpg',
                'alt'       => ['en' => 'Sitakund Modern Hospital Ltd. reception', 'bn' => 'সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ রিসেপশন'],
                'sub_title' => ['en' => 'Reception', 'bn' => 'রিসেপশন'],
                'caption'   => ['en' => 'Sitakund Modern Hospital Ltd.', 'bn' => 'সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ'],
            ],
            [
                'image'     => 'gallery/gallery-2.jpg',
                'alt'       => ['en' => 'Operation theatre', 'bn' => 'অপারেশন থিয়েটার'],
                'sub_title' => ['en' => 'Operation Theatre', 'bn' => 'অপারেশন থিয়েটার'],
                'caption'   => ['en' => 'Sitakund Modern Hospital Ltd.', 'bn' => 'সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ'],
            ],
            [
                'image'     => 'gallery/gallery-3.jpg',
                'alt'       => ['en' => 'Nursing college classroom', 'bn' => 'নার্সিং কলেজের শ্রেণীকক্ষ'],
                'sub_title' => ['en' => 'Nursing College', 'bn' => 'নার্সিং কলেজ'],
                'caption'   => ['en' => 'Sitakund Modern Nursing College', 'bn' => 'সীতাকুণ্ড মডার্ণ নার্সিং কলেজ'],
            ],
            [
                'image'     => 'gallery/gallery-4.jpg',
                'alt'       => ['en' => 'Patient ward', 'bn' => 'রোগী ওয়ার্ড'],
                'sub_title' => ['en' => 'Patient Ward', 'bn' => 'রোগী ওয়ার্ড'],
                'caption'   => ['en' => 'Sitakund Modern Hospital Ltd.', 'bn' => 'সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ'],
            ],
            [
                'image'     => 'gallery/gallery-5.jpg',
                'alt'       => ['en' => 'Diagnostic laboratory', 'bn' => 'ডায়াগনস্টিক ল্যাবরেটরি'],
                'sub_title' => ['en' => 'Diagnostic Lab', 'bn' => 'ডায়াগনস্টিক ল্যাব'],
                'caption'   => ['en' => 'Sitakund Modern Hospital Lab', 'bn' => 'সীতাকুণ্ড মডার্ণ হসপিটাল ল্যাব'],
            ],
            [
                'image'     => 'gallery/gallery-6.jpg',
                'alt'       => ['en' => 'Nursing college students', 'bn' => 'নার্সিং কলেজের শিক্ষার্থীরা'],
                'sub_title' => ['en' => 'Nursing Students', 'bn' => 'নার্সিং শিক্ষার্থী'],
                'caption'   => ['en' => 'Sitakund Modern Nursing College', 'bn' => 'সীতাকুণ্ড মডার্ণ নার্সিং কলেজ'],
            ],
            [
                'image'     => 'gallery/gallery-7.jpg',
                'alt'       => ['en' => 'Pharmacy counter', 'bn' => 'ফার্মেসী কাউন্টার'],
                'sub_title' => ['en' => 'Pharmacy', 'bn' => 'ফার্মেসী'],
                'caption'   => ['en' => 'Sitakund Modern Hospital Pharmacy', 'bn' => 'সীতাকুণ্ড মডার্ণ হসপিটাল ফার্মেসী'],
            ],
            [
                'image'     => 'gallery/gallery-8.jpg',
                'alt'       => ['en' => 'Ambulance service', 'bn' => 'এম্বুলেন্স সার্ভিস'],
                'sub_title' => ['en' => 'Ambulance', 'bn' => 'এম্বুলেন্স'],
                'caption'   => ['en' => 'Sitakund Modern Hospital Ambulance', 'bn' => 'সীতাকুণ্ড মডার্ণ হসপিটাল এম্বুলেন্স'],
            ],
        ];
    }
}
