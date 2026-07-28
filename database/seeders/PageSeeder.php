<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->pages() as $i => $page) {
            Page::updateOrCreate(
                ['slug' => $page['slug']],
                array_merge($page, ['sort_order' => $i + 1, 'is_active' => true])
            );
        }
    }

    private function pages(): array
    {
        return [
            [
                'slug'  => 'privacy-policy',
                'title' => ['en' => 'Privacy Policy', 'bn' => 'গোপনীয়তা নীতি'],
                'breadcrumb_title' => ['en' => 'Privacy Policy', 'bn' => 'গোপনীয়তা নীতি'],
                'content' => [
                    'en' => "<p>Sitakund Modern Hospital Ltd. respects your privacy. Any personal or medical information you share with us — including appointment details, contact information and treatment records — is kept strictly confidential and used only to provide you with quality healthcare services.</p><p>We do not sell or share your personal information with third parties, except where required by law or with your explicit consent. If you have questions about how your information is handled, please contact us at sitakundmodernhospital@gmail.com.</p>",
                    'bn' => "<p>সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ আপনার গোপনীয়তাকে সম্মান করে। আপনার সাথে শেয়ার করা যেকোনো ব্যক্তিগত বা চিকিৎসা সংক্রান্ত তথ্য — যেমন অ্যাপয়েন্টমেন্টের বিবরণ, যোগাযোগের তথ্য ও চিকিৎসার রেকর্ড — সম্পূর্ণ গোপনীয় রাখা হয় এবং শুধুমাত্র আপনাকে মানসম্পন্ন স্বাস্থ্যসেবা প্রদানের জন্য ব্যবহার করা হয়।</p><p>আইনগত প্রয়োজন বা আপনার সরাসরি অনুমতি ব্যতীত আমরা আপনার ব্যক্তিগত তথ্য কোনো তৃতীয় পক্ষের সাথে বিক্রি বা শেয়ার করি না। আপনার তথ্য কীভাবে ব্যবহৃত হয় সে সম্পর্কে কোনো প্রশ্ন থাকলে sitakundmodernhospital@gmail.com এ যোগাযোগ করুন।</p>",
                ],
                'seo_title' => ['en' => 'Privacy Policy — Sitakund Modern Hospital Ltd.', 'bn' => 'গোপনীয়তা নীতি — সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ'],
                'seo_description' => [
                    'en' => 'Read the privacy policy of Sitakund Modern Hospital Ltd. to understand how we handle your personal and medical information.',
                    'bn' => 'আপনার ব্যক্তিগত ও চিকিৎসা তথ্য কীভাবে ব্যবহৃত হয় তা জানতে সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ এর গোপনীয়তা নীতি পড়ুন।',
                ],
            ],
            [
                'slug'  => 'terms-conditions',
                'title' => ['en' => 'Terms & Conditions', 'bn' => 'শর্তাবলী'],
                'breadcrumb_title' => ['en' => 'Terms & Conditions', 'bn' => 'শর্তাবলী'],
                'content' => [
                    'en' => "<p>By using the services of Sitakund Modern Hospital Ltd., including our website, appointment booking and treatment services, you agree to the following terms.</p><p>Appointments are subject to doctor availability and may be rescheduled in case of emergencies. Shareholder benefits, discounts and offers described on this website are subject to the internal policy of Sitakund Modern Hospital Ltd. and may change without prior notice. All medical advice is provided at the discretion of our qualified doctors based on individual patient assessment.</p>",
                    'bn' => "<p>সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ এর সেবা, ওয়েবসাইট, অ্যাপয়েন্টমেন্ট বুকিং ও চিকিৎসা সেবা ব্যবহার করার মাধ্যমে আপনি নিম্নলিখিত শর্তাবলীতে সম্মত হচ্ছেন।</p><p>অ্যাপয়েন্টমেন্ট ডাক্তারের সময়সূচীর উপর নির্ভরশীল এবং জরুরী প্রয়োজনে পুনঃনির্ধারিত হতে পারে। এই ওয়েবসাইটে উল্লেখিত শেয়ার হোল্ডার সুবিধা, ছাড় ও অফার সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ এর অভ্যন্তরীণ নীতির উপর নির্ভরশীল এবং পূর্ব ঘোষণা ছাড়াই পরিবর্তিত হতে পারে। সকল চিকিৎসা পরামর্শ আমাদের যোগ্য ডাক্তারদের ব্যক্তিগত রোগী মূল্যায়নের ভিত্তিতে প্রদান করা হয়।</p>",
                ],
                'seo_title' => ['en' => 'Terms & Conditions — Sitakund Modern Hospital Ltd.', 'bn' => 'শর্তাবলী — সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ'],
                'seo_description' => [
                    'en' => 'Read the terms and conditions for using the services and website of Sitakund Modern Hospital Ltd.',
                    'bn' => 'সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ এর সেবা ও ওয়েবসাইট ব্যবহারের শর্তাবলী পড়ুন।',
                ],
            ],
        ];
    }
}
