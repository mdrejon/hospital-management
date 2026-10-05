<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\GlobalSetting;
use App\Models\Slider;
use App\Models\Blog;

// 1. Update Global Settings
$globalUpdates = [
    'footer_address_line1' => [
        'en' => 'Ali Market, Sitakunda Bazar',
        'bn' => 'আলী মার্কেট, সীতাকুন্ড বাজার'
    ],
    'footer_address_line2' => [
        'en' => 'Chattogram',
        'bn' => 'চট্টগ্রাম'
    ],
    'doc_home_title' => [
        'en' => 'We Have Specialist Doctors To Solve Your Problems',
        'bn' => 'আপনার সমস্যার সমাধানে আমাদের রয়েছে বিশেষজ্ঞ ডাক্তার'
    ],
    'doc_home_desc' => [
        'en' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit praesent aliquet. pretiumts',
        'bn' => 'আপনার সুস্বাস্থ্যের জন্য আমাদের বিশেষজ্ঞ চিকিৎসকরা সর্বদা প্রস্তুত। আমরা সর্বোচ্চ মানসম্পন্ন সেবা নিশ্চিত করি।'
    ],
    'pkg_title' => [
        'en' => 'We Maintain Cleanliness Rules Inside Our Hospital',
        'bn' => 'আমরা আমাদের হাসপাতালের ভিতরে পরিষ্কার-পরিচ্ছন্নতার নিয়ম মেনে চলি'
    ],
    'pkg_desc' => [
        'en' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit praesent aliquet. pretiumts',
        'bn' => 'রোগীদের সুরক্ষার জন্য আমাদের হাসপাতাল সর্বদা জীবাণুমুক্ত এবং পরিষ্কার রাখা হয়।'
    ],
    'svc_badge' => [
        'en' => 'Departments',
        'bn' => 'বিভাগসমূহ'
    ],
    'svc_title' => [
        'en' => 'Awesome Services',
        'bn' => 'আমাদের অসাধারণ সেবাসমূহ'
    ],
    'svc_desc' => [
        'en' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit praesent aliquet.',
        'bn' => 'রোগীর সুস্থতায় আমাদের আধুনিক সরঞ্জাম এবং দক্ষ চিকিৎসা দল সর্বদা নিয়োজিত।'
    ],
    'testi_title' => [
        'en' => 'Real Patients, Real Stories',
        'bn' => 'প্রকৃত রোগী, বাস্তব গল্প'
    ]
];

foreach ($globalUpdates as $key => $values) {
    GlobalSetting::setTranslated($key, $values);
}

// 2. Update Slider missing description
$slider = Slider::find(3);
if ($slider) {
    $slider->setTranslation('description', 'bn', 'আমরা সর্বদা যত্ন নিতে প্রস্তুত');
    $slider->save();
}

// 3. Update Blog missing meta keywords
$blogKeywords = [
    1 => 'প্রতিদিন, অভ্যাস, স্বাস্থ্যকর, জীবন, সহজ, ব্যবহারিক, সাহায্য, পরিবার, থাকা, সুস্থ, বছর, গোল',
    2 => 'গুরুত্ব, আল্ট্রাসনোগ্রাম, গর্ভাবস্থায়, নিয়মিত, আল্ট্রাসাউন্ড, ইমেজিং, অপরিহার্য, গর্ভবতী, মা, তাদের, শিশু',
    3 => 'বোঝা, ডায়াবেটিস, সঠিক, পরীক্ষা, বিষয়, তথ্য, সম্পর্কে, বায়োকেমিস্ট্রি, সাহায্য, পরিচালনা, পরিণত, সাধারণ',
    4 => 'মেডিকেয়ার, আধুনিক, ডায়াগনস্টিক, সীতাকুন্ড, প্রতিশ্রুতিবদ্ধ, প্রদান, নির্ভরযোগ্য, প্যাথলজি, ইমেজিং, বিশেষজ্ঞ, পরামর্শ, নিবেদিত'
];

foreach ($blogKeywords as $id => $bnKeywords) {
    $blog = Blog::find($id);
    if ($blog) {
        $blog->setTranslation('meta_keywords', 'bn', $bnKeywords);
        $blog->save();
    }
}

echo "Database translations updated successfully.\n";
