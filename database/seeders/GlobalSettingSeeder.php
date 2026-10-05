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
