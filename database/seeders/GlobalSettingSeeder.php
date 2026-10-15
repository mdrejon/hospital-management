<?php

namespace Database\Seeders;

use App\Models\GlobalSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GlobalSettingSeeder extends Seeder
{
    /**
     * Seed content sourced from the Medicare Lab Diagnostic Center banner.
     */
    public function run(): void
    {
        // Remove existing database content for header, footer, and contact pages
        GlobalSetting::where('key', 'like', 'header_%')->delete();
        GlobalSetting::where('key', 'like', 'footer_%')->delete();
        GlobalSetting::where('key', 'like', 'contact_%')->delete();

        // ── Plain (non-translatable) settings — shared identity / contact info ──
        GlobalSetting::setMany([
            'header_site_name'      => 'Medicare Lab',
            'header_phone'          => '01711-307275',
            'header_email'          => '',

            'footer_phone_1'        => '01711-307275',
            'footer_phone_2'        => '',
            'footer_phone_3'        => '',
            'footer_email_1'        => '',
            'footer_address_line1'  => 'Ali Market, Sitakunda Bazar',
            'footer_address_line2'  => 'Chattogram',
            'footer_opening_time'   => null,
        ]);

        // ── Header ──
        $this->setTranslatedMany([
            'header_tagline'             => ['en' => 'Regular Medical Services by Specialist Doctors', 'bn' => 'বিশেষজ্ঞ চিকিৎসকদের নিয়মিত চিকিৎসাসেবা'],
            'header_hours'               => ['en' => 'Regular Medical Services', 'bn' => 'নিয়মিত চিকিৎসাসেবা'],
            'header_support_text'        => ['en' => 'We are committed to your healthy life', 'bn' => 'আপনার সুস্থ জীবনের জন্য আমরা প্রতিশ্রুতিবদ্ধ'],
            'header_sidebar_description' => [
                'en' => 'Medicare Lab Diagnostic Center provides modern lab facilities, experienced doctors, digital ECG, and reliable quality service for your healthy life.',
                'bn' => 'আপনার সুস্থ জীবনের জন্য মেডিকেয়ার ল্যাব ডায়াগনস্টিক সেন্টার দিচ্ছে আধুনিক ল্যাব সুবিধা, অভিজ্ঞ চিকিৎসক, ডিজিটাল ইসিজি এবং নির্ভরযোগ্য ও মানসম্পন্ন সেবা।',
            ],
            'header_book_btn_text'       => ['en' => 'Contact for Serial', 'bn' => 'সিরিয়ালের জন্য যোগাযোগ'],
            'header_address'             => [
                'en' => 'Ali Market, Sitakunda Bazar, Chattogram',
                'bn' => 'আলী মার্কেট, সীতাকুন্ড বাজার, চট্টগ্রাম',
            ],
        ]);

        // ── Footer ──
        $this->setTranslatedMany([
            'footer_brand_description' => [
                'en' => 'We are committed to your healthy life. Medicare Lab Diagnostic Center offers regular medical services by specialist doctors, modern lab facilities, and reliable quality care.',
                'bn' => 'আপনার সুস্থ জীবনের জন্য আমরা প্রতিশ্রুতিবদ্ধ। বিশেষজ্ঞ চিকিৎসকদের নিয়মিত চিকিৎসাসেবা, আধুনিক ল্যাব সুবিধা এবং নির্ভরযোগ্য ও মানসম্পন্ন সেবা নিয়ে মেডিকেয়ার ল্যাব ডায়াগনস্টিক সেন্টার আপনার পাশে।',
            ],
            'footer_newsletter_title'  => ['en' => 'Subscribe to our Newsletter', 'bn' => 'আমাদের নিউজলেটার সাবস্ক্রাইব করুন'],
            'footer_copyright_text'    => [
                'en' => '© Medicare Lab. All rights reserved.',
                'bn' => '© মেডিকেয়ার ল্যাব। সর্বস্বত্ব সংরক্ষিত।',
            ],
        ]);

        // ── About page / section (Updated slightly to match the new branding while keeping keys intact) ──
        GlobalSetting::set('about_exp_years', '8+');
        $this->setTranslatedMany([
            'about_hero_title'    => ['en' => 'About Us', 'bn' => 'আমাদের সম্পর্কে'],
            'about_seo_title'     => ['en' => 'About Medicare Lab', 'bn' => 'মেডিকেয়ার ল্যাব সম্পর্কে'],
            'about_seo_description' => [
                'en' => 'Learn about Medicare Lab Diagnostic Center serving Sitakund, Chattogram.',
                'bn' => 'সীতাকুণ্ড, চট্টগ্রামের মানুষকে সেবা প্রদানকারী একটি আধুনিক ডায়াগনস্টিক সেন্টার মেডিকেয়ার ল্যাব সম্পর্কে জানুন।',
            ],
            'about_title' => ['en' => 'Medicare Lab Diagnostic Center', 'bn' => 'মেডিকেয়ার ল্যাব ডায়াগনস্টিক সেন্টার'],
            'about_desc'  => [
                'en' => 'Medicare Lab Diagnostic Center is established to ensure the people of Sitakund have access to quality modern healthcare and reliable service.',
                'bn' => 'সীতাকুণ্ডবাসী যেন আধুনিক স্বাস্থ্যসেবা ও নির্ভরযোগ্য চিকিৎসা সেবা নিশ্চিত করতে পারে, সেই লক্ষ্যে মেডিকেয়ার ল্যাব ডায়াগনস্টিক সেন্টার প্রতিষ্ঠিত হয়েছে।',
            ],
            'about_exp_label'     => ['en' => 'Years Of Experience', 'bn' => 'বছরের অভিজ্ঞতা'],
            'about_hours_title'   => ['en' => 'Working Hours', 'bn' => 'কর্মঘন্টা'],
            'about_more_btn_text' => ['en' => 'Read More', 'bn' => 'আরও পড়ুন'],
            'about_mv_title'      => ['en' => 'Our Mission & Vision', 'bn' => 'আমাদের লক্ষ্য ও উদ্দেশ্য'],
            'about_mv_desc'       => [
                'en' => 'We are committed to providing the people of Sitakund with honest, sincere and reliable healthcare, prioritizing your healthy life.',
                'bn' => 'আমরা দৃঢ়তার সাথে সীতাকুণ্ডবাসীর নিকট অঙ্গীকারবদ্ধ, সম্পূর্ণ ন্যায়-নিষ্ঠার মধ্যদিয়ে আপনার সুস্থ জীবনের জন্য চিকিৎসা সেবা প্রদান করতে।',
            ],
            'ceo_badge_label' => ['en' => 'Chairman', 'bn' => 'চেয়ারম্যান'],
            'ceo_eyebrow'     => ['en' => "Chairman's Message", 'bn' => 'চেয়ারম্যানের বার্তা'],
            'ceo_title'       => ['en' => 'A.K.M. Shamsul Alam (Azad)', 'bn' => 'এ. কে. এম শামসুল আলম (আজাদ)'],
            'ceo_message'     => [
                'en' => 'Human civilization is a continuous journey, and modern medical science is an inseparable part of it. We have always stood beside the people of Sitakund. Your healthy life is our commitment.',
                'bn' => 'মানব সভ্যতা একটি চলমান প্রক্রিয়া, আর আধুনিক চিকিৎসা বিজ্ঞান এই সভ্যতার একটি অপরিহার্য অংশ। আমরা সর্বদা সীতাকুণ্ডবাসীর পাশে আছি। আপনার সুস্থ জীবনই আমাদের প্রতিশ্রুতি।',
            ],
            'ceo_focus_label' => ['en' => 'Our Focus', 'bn' => 'আমাদের অগ্রাধিকার'],
            'why_badge' => ['en' => 'Why Choose Us', 'bn' => 'কেন আমাদের বেছে নেবেন'],
            'why_title' => ['en' => 'Reliable & Quality Service', 'bn' => 'নির্ভরযোগ্য ও মানসম্পন্ন সেবা'],
            'why_desc'  => [
                'en' => 'Modern lab facilities, experienced doctors, digital ECG, and reliable quality service — all under one roof.',
                'bn' => 'আধুনিক ল্যাব সুবিধা, অভিজ্ঞ চিকিৎসক, ডিজিটাল ইসিজি এবং নির্ভরযোগ্য ও মানসম্পন্ন সেবা — সবকিছু এক ছাদের নিচে।',
            ],
            'why_badge_number' => ['en' => '10+', 'bn' => '১০+'],
            'why_badge_label'  => ['en' => 'Years Experienced', 'bn' => 'বছরের অভিজ্ঞতা'],
        ]);

        // ── History Timeline ──
        GlobalSetting::set('hist_timeline', [
            [
                'year' => '2018',
                'tag' => ['en' => 'Foundation', 'bn' => 'প্রতিষ্ঠা ও সূচনা'],
                'heading' => ['en' => 'Grand Opening — Medicare Lab Diagnostic Center Is Born', 'bn' => 'শুভ সূচনা — মেডিকেয়ার ল্যাব ডায়াগনস্টিক সেন্টারের যাত্রা শুরু'],
                'content' => ['en' => 'With a vision to redefine community healthcare, Medicare Lab opened its doors in Sitakund in 2018 with a dedicated team of specialist physicians.', 'bn' => 'সীতাকুণ্ডের সাধারণ মানুষের জন্য উন্নত ও নির্ভরযোগ্য স্বাস্থ্যসেবা নিশ্চিত করার প্রত্যয়ে ২০১৮ সালে অভিজ্ঞ বিশেষজ্ঞ চিকিৎসকদের সমন্বয়ে মেডিকেয়ার ল্যাব প্রতিষ্ঠিত হয়।'],
                'badges' => [
                    ['en' => 'Modern Diagnostics', 'bn' => 'আধুনিক ডায়াগনস্টিক'],
                    ['en' => '24/7 Emergency Desk', 'bn' => '২৪/৭ জরুরি সেবা'],
                    ['en' => 'Outpatient Care', 'bn' => 'বহির্বিভাগ সেবা'],
                ],
                'image' => null,
                'reversed' => false,
            ],
            [
                'year' => '2020',
                'tag' => ['en' => 'Diagnostics', 'bn' => 'উন্নত ডায়াগনস্টিক'],
                'heading' => ['en' => 'Advanced Diagnostic & Imaging Center', 'bn' => 'উন্নত ডায়াগনস্টিক ও ইমেজিং সেন্টার সম্প্রসারণ'],
                'content' => ['en' => 'In 2020, Medicare Lab unveiled an expanded diagnostic wing — bringing digital X-ray, ultrasonography, and a modern pathology laboratory together under one roof.', 'bn' => '২০২০ সালে মেডিকেয়ার ল্যাব তার ডায়াগনস্টিক বিভাগ সম্প্রসারণ করে এক ছাদের নিচে ডিজিটাল এক্স-রে, আল্ট্রাসনোগ্রাফি এবং অত্যাধুনিক প্যাথলজি ল্যাব চালু করে।'],
                'badges' => [
                    ['en' => 'Digital X-Ray', 'bn' => 'ডিজিটাল এক্স-রে'],
                    ['en' => 'Ultrasonography', 'bn' => 'আল্ট্রাসনোগ্রাফি'],
                    ['en' => 'Pathology Lab', 'bn' => 'প্যাথলজি ল্যাব'],
                ],
                'image' => null,
                'reversed' => true,
            ],
            [
                'year' => '2022',
                'tag' => ['en' => 'Specialized Care', 'bn' => 'বিশেষজ্ঞ চিকিৎসা সেবা'],
                'heading' => ['en' => 'Dedicated Consultant Chambers & Cardiac Wing', 'bn' => 'বিশেষজ্ঞ কনসালট্যান্ট চেম্বার ও ডিজিটাল কার্ডিয়াক সেবা'],
                'content' => ['en' => 'Specialized multi-departmental consultant chambers and digital ECG facilities opened in 2022, giving the community round-the-clock access to expert specialist care.', 'bn' => '২০২২ সালে বিভিন্ন বিভাগের বিশেষজ্ঞ চিকিৎসকদের চেম্বার ও ডিজিটাল ইসিজিসহ কার্ডিয়াক সেবা চালু করা হয়, যা এলাকার রোগীদের সার্বক্ষণিক বিশেষজ্ঞ সেবা প্রদান করে।'],
                'badges' => [
                    ['en' => 'Specialist Chambers', 'bn' => 'বিশেষজ্ঞ চেম্বার'],
                    ['en' => 'Digital ECG', 'bn' => 'ডিজিটাল ইসিজি'],
                    ['en' => '24/7 Patient Care', 'bn' => '২৪/৭ রোগী সেবা'],
                ],
                'image' => null,
                'reversed' => false,
            ],
            [
                'year' => '2024',
                'tag' => ['en' => 'Innovation', 'bn' => 'ডিজিটাল উদ্ভাবন'],
                'heading' => ['en' => 'Telemedicine & Digital Healthcare Launch', 'bn' => 'টেলিমেডিসিন ও ডিজিটাল স্বাস্থ্যসেবার শুভ উদ্বোধন'],
                'content' => ['en' => "Medicare Lab went digital in 2024 — online appointment booking, digital test report delivery, and smart patient management brought expert care into patients' homes.", 'bn' => '২০২৪ সালে মেডিকেয়ার ল্যাব ডিজিটাল সেবা চালু করে — অনলাইন সিরিয়াল বুকিং, দ্রুত ডিজিটাল রিপোর্ট ডেলিভারি এবং স্মার্ট পেশেন্ট ম্যানেজমেন্ট সেবা রোগীদের ঘরে পৌঁছে দেয়।'],
                'badges' => [
                    ['en' => 'Online Booking', 'bn' => 'অনলাইন বুকিং'],
                    ['en' => 'Digital Test Reports', 'bn' => 'ডিজিটাল টেস্ট রিপোর্ট'],
                    ['en' => 'E-Prescriptions', 'bn' => 'ই-প্রেসক্রিপশন'],
                ],
                'image' => null,
                'reversed' => true,
            ],
            [
                'year' => '2026',
                'tag' => ['en' => 'Present & Beyond', 'bn' => 'বর্তমান ও ভবিষ্যৎ রূপকল্প'],
                'heading' => ['en' => 'Award-Winning Care & Expansion Vision', 'bn' => 'অঙ্গীকারবদ্ধ স্বাস্থ্যসেবা ও আধুনিক হাসপাতাল রূপকল্প'],
                'content' => ['en' => 'Today Medicare Lab stands as Sitakund’s most trusted diagnostic healthcare provider — honoured for clinical excellence and actively expanding toward a modern hospital and nursing college.', 'bn' => 'বর্তমানে মেডিকেয়ার ল্যাব সীতাকুণ্ডের সর্বাধিক বিশ্বস্ত স্বাস্থ্যসেবা প্রতিষ্ঠান — নিজস্ব জমিতে আধুনিক পূর্ণাঙ্গ হাসপাতাল ও আন্তর্জাতিক মানের নার্সিং কলেজ প্রতিষ্ঠার লক্ষ্যে এগিয়ে চলেছে।'],
                'badges' => [
                    ['en' => 'Trusted Healthcare', 'bn' => 'বিশ্বস্ত স্বাস্থ্যসেবা'],
                    ['en' => '50+ Specialists', 'bn' => '৫০+ বিশেষজ্ঞ চিকিৎসক'],
                    ['en' => 'Nursing College Vision', 'bn' => 'নার্সিং কলেজ রূপকল্প'],
                ],
                'image' => null,
                'reversed' => false,
            ],
        ]);

        // ── Contact page ──
        $this->setTranslatedMany([
            'contact_hero_title'  => ['en' => 'Contact Us', 'bn' => 'যোগাযোগ করুন'],
            'contact_seo_title'   => ['en' => 'Contact Medicare Lab', 'bn' => 'মেডিকেয়ার ল্যাব - যোগাযোগ'],
            'contact_seo_description' => [
                'en' => 'Get in touch with Medicare Lab for serial booking and inquiries.',
                'bn' => 'সিরিয়াল বুকিং ও তথ্যের জন্য মেডিকেয়ার ল্যাবের সাথে যোগাযোগ করুন।',
            ],
            'contact_title' => ['en' => "Let's Get in Touch", 'bn' => 'আমাদের সাথে যোগাযোগ করুন'],
            'contact_desc'  => [
                'en' => 'For serial booking or any inquiries, reach out to us at Ali Market, Sitakunda Bazar, Chattogram.',
                'bn' => 'সিরিয়াল বুকিং বা যেকোনো তথ্যের জন্য আমাদের সাথে যোগাযোগ করুন: আলী মার্কেট, সীতাকুন্ড বাজার, চট্টগ্রাম।',
            ],
            'contact_talk_text'   => ['en' => "Let's talk with us", 'bn' => 'আমাদের সাথে কথা বলুন'],
            'contact_rating_text' => ['en' => 'Committed to your healthy life', 'bn' => 'আপনার সুস্থ জীবনের জন্য প্রতিশ্রুতিবদ্ধ'],
            'contact_form_title'    => ['en' => 'Send a Message', 'bn' => 'বার্তা পাঠান'],
            'contact_form_btn_text' => ['en' => 'Send Message', 'bn' => 'বার্তা পাঠান'],
        ]);
    }

    private function setTranslatedMany(array $items): void
    {
        foreach ($items as $key => $localized) {
            GlobalSetting::setTranslated($key, $localized);
        }
    }
}
