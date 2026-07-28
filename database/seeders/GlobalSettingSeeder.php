<?php

namespace Database\Seeders;

use App\Models\GlobalSetting;
use Illuminate\Database\Seeder;

class GlobalSettingSeeder extends Seeder
{
    /**
     * Seed content sourced from the Sitakund Modern Hospital Ltd. print brochure.
     */
    public function run(): void
    {
        // ── Plain (non-translatable) settings — shared identity / contact info ──
        GlobalSetting::setMany([
            'header_site_name'      => 'Sitakund Modern Hospital Ltd.',
            'header_phone'          => '01849-727858',
            'header_email'          => 'sitakundmodernhospital@gmail.com',

            'footer_phone_1'        => '01849-727858',
            'footer_phone_2'        => '01974-300824',
            'footer_phone_3'        => '01814-158783',
            'footer_email_1'        => 'sitakundmodernhospital@gmail.com',
            'footer_address_line1'  => 'Amirabad (Sitakund South Bypass) 07',
            'footer_address_line2'  => 'Sitakund Municipality, Sitakund, Chattogram',
            'footer_opening_time'   => null,
        ]);

        // ── Header ──
        $this->setTranslatedMany([
            'header_tagline'             => ['en' => 'Human Life, Humane Care', 'bn' => 'মানব জীবন মানবিক হউক'],
            'header_hours'               => ['en' => 'Open 24 Hours, Everyday', 'bn' => '২৪ ঘন্টা সেবা প্রদান করা হয়'],
            'header_support_text'        => ['en' => 'Emergency & Ambulance Support', 'bn' => 'জরুরী বিভাগ ও এম্বুলেন্স সাপোর্ট'],
            'header_sidebar_description' => [
                'en' => 'A modern hospital and diagnostic center in Sitakund, Chattogram, providing 24-hour emergency, pharmacy, ambulance and specialist doctor services.',
                'bn' => 'সীতাকুণ্ড, চট্টগ্রামের একটি আধুনিক হাসপাতাল ও ডায়াগনস্টিক সেন্টার, যেখানে ২৪ ঘন্টা জরুরী বিভাগ, ফার্মেসী, এম্বুলেন্স ও বিশেষজ্ঞ ডাক্তারের সেবা পাওয়া যায়।',
            ],
            'header_book_btn_text'       => ['en' => 'Book Appointment', 'bn' => 'অ্যাপয়েন্টমেন্ট নিন'],
            'header_address'             => [
                'en' => 'Amirabad (Sitakund South Bypass) 07, Sitakund Municipality, Sitakund, Chattogram',
                'bn' => 'আমিরাবাদ (সীতাকুণ্ড দক্ষিণ বাইপাস) ০৭, সীতাকুণ্ড পৌরসভা, সীতাকুণ্ড, চট্টগ্রাম',
            ],
        ]);

        // ── Footer ──
        $this->setTranslatedMany([
            'footer_brand_description' => [
                'en' => 'Sitakund Modern Hospital Ltd. has been serving the people of Sitakund since 2013 with a fully equipped hospital and diagnostic center, guided by the motto "Human Life, Humane Care".',
                'bn' => '"মানব জীবন মানবিক হউক" এই স্লোগানকে বুকে ধারণ করে সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ ২০১৩ সাল থেকে সীতাকুণ্ডবাসীকে একটি সুসজ্জিত হাসপাতাল ও ডায়াগনস্টিক সেন্টারের মাধ্যমে সেবা দিয়ে আসছে।',
            ],
            'footer_newsletter_title'  => ['en' => 'Subscribe to our Newsletter', 'bn' => 'আমাদের নিউজলেটার সাবস্ক্রাইব করুন'],
            'footer_copyright_text'    => [
                'en' => '© Sitakund Modern Hospital Ltd. All rights reserved.',
                'bn' => '© সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ। সর্বস্বত্ব সংরক্ষিত।',
            ],
        ]);

        // ── About page / section ──
        $this->setTranslatedMany([
            'about_hero_title'    => ['en' => 'About Us', 'bn' => 'আমাদের সম্পর্কে'],
            'about_seo_title'     => ['en' => 'About Sitakund Modern Hospital Ltd.', 'bn' => 'সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ সম্পর্কে'],
            'about_seo_description' => [
                'en' => 'Learn about Sitakund Modern Hospital Ltd., a modern hospital and diagnostic center serving Sitakund, Chattogram since 2013.',
                'bn' => '২০১৩ সাল থেকে সীতাকুণ্ড, চট্টগ্রামের মানুষকে সেবা প্রদানকারী একটি আধুনিক হাসপাতাল ও ডায়াগনস্টিক সেন্টার সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ সম্পর্কে জানুন।',
            ],
            'about_title' => ['en' => 'Sitakund Modern Hospital Ltd.', 'bn' => 'সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ'],
            'about_desc'  => [
                'en' => 'Located at the gateway to Chattogram, the commercial capital of Bangladesh, Sitakund is one of the country\'s oldest and most important upazilas, home to nearly 3,35,178 people but served by only one government upazila health complex with 50 beds. Recognizing this severe shortage, in January 2013 we established a modern hospital and diagnostic center — "Sitakund Modern Hospital Ltd." — to ensure the people of Sitakund have access to quality modern healthcare, 24 hours a day.',
                'bn' => 'বাংলাদেশের বাণিজ্যিক রাজধানী চট্টগ্রাম শহরের প্রবেশদ্বার, ঐতিহাসিক স্থাপনা ও প্রাকৃতিক সৌন্দর্যে সমৃদ্ধ সীতাকুণ্ড বাংলাদেশের অন্যতম গুরুত্বপূর্ণ ও প্রাচীনতম উপজেলা। বর্তমানে সীতাকুণ্ডের জনসংখ্যা ৩,৩৫,১৭৮ জন হলেও এখানে মাত্র ৫০ শয্যার একটি সরকারি উপজেলা স্বাস্থ্য কমপ্লেক্স রয়েছে, যা এই বিশাল জনসংখ্যার জন্য খুবই অপ্রতুল। এই সংকট বিবেচনা করে ২০১৩ সালের জানুয়ারিতে আমরা গড়ে তুলি একটি আধুনিক মানের হাসপাতাল ও ডায়াগনস্টিক সেন্টার "সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ", যাতে সীতাকুণ্ডবাসী ২৪ ঘন্টা আধুনিক স্বাস্থ্যসেবা নিশ্চিত করতে পারে।',
            ],
            'about_hours_title'   => ['en' => 'Working Hours', 'bn' => 'কর্মঘন্টা'],
            'about_more_btn_text' => ['en' => 'Read More', 'bn' => 'আরও পড়ুন'],
            'about_mv_title'      => ['en' => 'Our Mission & Vision', 'bn' => 'আমাদের লক্ষ্য ও উদ্দেশ্য'],
            'about_mv_desc'       => [
                'en' => 'We are committed to providing the people of Sitakund with honest, sincere and affordable healthcare, 24 hours a day, every day.',
                'bn' => 'আমরা দৃঢ়তার সাথে সীতাকুণ্ডবাসীর নিকট অঙ্গীকারবদ্ধ, সম্পূর্ণ ন্যায়-নিষ্ঠার মধ্যদিয়ে ২৪ ঘন্টা চিকিৎসা সেবা প্রদান করার জন্য।',
            ],
            'ceo_badge_label' => ['en' => 'Chairman', 'bn' => 'চেয়ারম্যান'],
            'ceo_eyebrow'     => ['en' => "Chairman's Message", 'bn' => 'চেয়ারম্যানের বার্তা'],
            'ceo_title'       => ['en' => 'A.K.M. Shamsul Alam (Azad)', 'bn' => 'এ. কে. এম শামসুল আলম (আজাদ)'],
            'ceo_message'     => [
                'en' => 'Human civilization is a continuous journey, and modern medical science is an inseparable part of it. Over our 12-year journey, we have always stood beside the people of Sitakund and continuously worked to correct our shortcomings. "Sitakund Modern Hospital Ltd." is now a registered joint-stock company, and we are moving forward to build our own modern hospital, diagnostic center and nursing college on our own land. Death is inevitable, but before that, we want to build a society where your loved ones can lead a secure life through purposeful education. "Human Life, Humane Care."',
                'bn' => 'মানব সভ্যতা একটি চলমান প্রক্রিয়া, আর আধুনিক চিকিৎসা বিজ্ঞান এই সভ্যতার একটি অপরিহার্য অংশ। আমরা আমাদের দীর্ঘ ১২ বছরের পথ চলায় সীতাকুণ্ড বাসীকে সর্বদা সাথে পেয়েছি এবং ভুল-ত্রুটি সংশোধন করে সামনে এগিয়ে যাওয়ার চেষ্টা করেছি। বর্তমানে "সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ" একটি জয়েন্টস্টক কোম্পানীর নিবন্ধিত লিমিটেড কোম্পানী, এবং আমরা নিজস্ব জায়গায় নিজস্ব ভবনে একটি আধুনিক হাসপাতাল, ডায়াগনস্টিক সেন্টার ও নার্সিং কলেজ গড়ে তোলার উদ্যোগ নিয়েছি। মৃত্যু অনিবার্য, তবুও আমরা এমন একটি সমাজ চাই যেখানে আপনার সন্তান একটি কর্মমুখী শিক্ষা নিয়ে নিরাপদ জীবন গড়ে তুলতে পারে। "মানব জীবন মানবিক হউক।"',
            ],
            'ceo_focus_label' => ['en' => 'Our Focus', 'bn' => 'আমাদের অগ্রাধিকার'],
            'why_badge' => ['en' => 'Why Choose Us', 'bn' => 'কেন আমাদের বেছে নেবেন'],
            'why_title' => ['en' => 'Trusted Healthcare Since 2013', 'bn' => '২০১৩ সাল থেকে বিশ্বস্ত স্বাস্থ্যসেবা'],
            'why_desc'  => [
                'en' => 'Digital 4-D color ultrasonography, ECHO, pathology, 24-hour digital X-ray & ECG, biochemistry, microbiology, serology and a diabetic center — all under one roof.',
                'bn' => 'ডিজিটাল ৪-ডি কালার আল্ট্রাসোনোগ্রাফী, ইকো, প্যাথলজি, ২৪ ঘন্টা ডিজিটাল এক্স-রে ও ই.সি.জি, বায়োকেমিস্ট্রি, মাইক্রোবায়োলজী, সেরোলজী ও ডায়াবেটিক সেন্টার — সবকিছু এক ছাদের নিচে।',
            ],
        ]);

        // ── Contact page ──
        $this->setTranslatedMany([
            'contact_hero_title'  => ['en' => 'Contact Us', 'bn' => 'যোগাযোগ করুন'],
            'contact_seo_title'   => ['en' => 'Contact Sitakund Modern Hospital Ltd.', 'bn' => 'সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ - যোগাযোগ'],
            'contact_seo_description' => [
                'en' => 'Get in touch with Sitakund Modern Hospital Ltd. for appointments, emergency care and general inquiries.',
                'bn' => 'অ্যাপয়েন্টমেন্ট, জরুরী সেবা ও সাধারণ তথ্যের জন্য সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ এর সাথে যোগাযোগ করুন।',
            ],
            'contact_title' => ['en' => "Let's Get in Touch", 'bn' => 'আমাদের সাথে যোগাযোগ করুন'],
            'contact_desc'  => [
                'en' => 'For appointments, emergency support or any inquiries, reach out to us any time — our team is available 24 hours a day.',
                'bn' => 'অ্যাপয়েন্টমেন্ট, জরুরী সেবা বা যেকোনো তথ্যের জন্য আমাদের সাথে যেকোনো সময় যোগাযোগ করুন — আমাদের টিম ২৪ ঘন্টা প্রস্তুত।',
            ],
            'contact_talk_text'   => ['en' => "Let's talk with us", 'bn' => 'আমাদের সাথে কথা বলুন'],
            'contact_rating_text' => ['en' => 'Trusted by our patients', 'bn' => 'আমাদের রোগীদের আস্থার প্রতিষ্ঠান'],
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
