<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        // Clean up old blogs
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        DB::table('blogs')->truncate();
        DB::table('blog_comments')->truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $categoryByName = fn(string $en) => BlogCategory::whereJsonContains('name->en', $en)->first()?->id;

        foreach ($this->posts($categoryByName) as $i => $post) {
            $slug = Str::slug($post['title']['en']);

            Blog::updateOrCreate(
                ['slug' => $slug],
                array_merge($post, [
                    'slug'         => $slug,
                    'author_name'  => 'Medicare Lab',
                    'status'       => 'published',
                    'published_at' => now()->subDays((count($this->posts($categoryByName)) - $i) * 5),
                    'sort_order'   => $i + 1,
                ])
            );
        }
    }

    private function posts(\Closure $categoryByName): array
    {
        return [
            [
                'category_id' => $categoryByName('Health Tips'),
                'title'   => ['en' => '5 Everyday Habits for a Healthier Life', 'bn' => 'সুস্থ জীবনের জন্য ৫টি দৈনন্দিন অভ্যাস'],
                'excerpt' => [
                    'en' => 'Simple, practical habits that can help you and your family stay healthy year-round.',
                    'bn' => 'সহজ কিছু অভ্যাস যা আপনার ও আপনার পরিবারের সারা বছর সুস্থ থাকতে সাহায্য করবে।',
                ],
                'content' => [
                    'en' => "<p>Good health starts with small, consistent habits. Drink enough water every day, eat a balanced diet with plenty of vegetables, get at least 30 minutes of physical activity, sleep 7-8 hours a night, and schedule regular health checkups.</p><p>At Medicare Lab Diagnostic Center, our specialist doctors are available every day for consultations to help you build a healthier routine and perform necessary routine checkups.</p>",
                    'bn' => "<p>সুস্বাস্থ্যের শুরু হয় ছোট ছোট নিয়মিত অভ্যাস থেকে। প্রতিদিন পর্যাপ্ত পানি পান করুন, সুষম খাবার ও প্রচুর শাকসবজি খান, প্রতিদিন অন্তত ৩০ মিনিট শারীরিক পরিশ্রম করুন, রাতে ৭-৮ ঘন্টা ঘুমান এবং নিয়মিত স্বাস্থ্য পরীক্ষা করান।</p><p>মেডিকেয়ার ল্যাবে আমাদের বিশেষজ্ঞ ডাক্তারগণ প্রতিদিন পরামর্শের জন্য উপস্থিত থাকেন, যা আপনাকে একটি স্বাস্থ্যকর রুটিন তৈরি করতে এবং প্রয়োজনীয় রুটিন চেকআপ করতে সাহায্য করবে।</p>",
                ],
                'tags' => ['health tips', 'wellness'],
                'is_featured' => true,
            ],
            [
                'category_id' => $categoryByName('Maternal & Child Care'),
                'title'   => ['en' => 'The Importance of Ultrasonogram During Pregnancy', 'bn' => 'গর্ভাবস্থায় আল্ট্রাসনোগ্রামের গুরুত্ব'],
                'excerpt' => [
                    'en' => 'Why regular ultrasound imaging is essential for expecting mothers and their baby\'s health.',
                    'bn' => 'গর্ভবতী মায়েদের এবং তাদের শিশুর স্বাস্থ্যের জন্য নিয়মিত আল্ট্রাসাউন্ড ইমেজিং কেন জরুরি।',
                ],
                'content' => [
                    'en' => "<p>Regular ultrasound checkups help doctors monitor the growth and development of the baby, as well as detect any potential complications early. It is a completely safe and painless procedure.</p><p>At Medicare Lab, we offer advanced digital Ultrasonogram services operated by experienced sonologists, ensuring accurate reports and better maternal care for expecting mothers.</p>",
                    'bn' => "<p>নিয়মিত আল্ট্রাসাউন্ড চেকআপ ডাক্তারদের শিশুর বৃদ্ধি ও বিকাশ পর্যবেক্ষণ করতে এবং যে কোনো সম্ভাব্য জটিলতা আগেভাগে শনাক্ত করতে সাহায্য করে। এটি একটি সম্পূর্ণ নিরাপদ ও ব্যথামুক্ত প্রক্রিয়া।</p><p>মেডিকেয়ার ল্যাবে আমরা অভিজ্ঞ সনোলজিস্টদের দ্বারা উন্নত ডিজিটাল আল্ট্রাসনোগ্রাম সেবা প্রদান করি, যা নির্ভুল রিপোর্ট এবং গর্ভবতী মায়েদের জন্য উন্নত মাতৃকালীন সেবা নিশ্চিত করে।</p>",
                ],
                'tags' => ['pregnancy', 'ultrasonogram', 'maternal care'],
                'is_featured' => true,
            ],
            [
                'category_id' => $categoryByName('Health Tips'),
                'title'   => ['en' => 'Understanding Diabetes: Accurate Lab Tests Matter', 'bn' => 'ডায়াবেটিস সম্পর্কে জানুন: সঠিক ল্যাব টেস্টের গুরুত্ব'],
                'excerpt' => [
                    'en' => 'Key facts about diabetes and how accurate biochemistry tests can help you manage it.',
                    'bn' => 'ডায়াবেটিস সম্পর্কে গুরুত্বপূর্ণ তথ্য এবং সঠিক বায়োকেমিস্ট্রি টেস্ট কীভাবে সাহায্য করতে পারে।',
                ],
                'content' => [
                    'en' => "<p>Diabetes has become a common condition affecting people of all ages. Early detection through regular blood sugar checkups and reliable biochemistry tests can prevent serious complications.</p><p>Medicare Lab offers precise and fast biochemistry analysis and hormone tests, ensuring your doctor gets the most accurate data to formulate your diabetes management plan.</p>",
                    'bn' => "<p>ডায়াবেটিস এখন সব বয়সের মানুষের মধ্যে একটি সাধারণ সমস্যা হয়ে দাঁড়িয়েছে। নিয়মিত রক্তে সুগার পরীক্ষা ও নির্ভরযোগ্য বায়োকেমিস্ট্রি টেস্টের মাধ্যমে গুরুতর জটিলতা প্রতিরোধ করা সম্ভব।</p><p>মেডিকেয়ার ল্যাব সুনির্দিষ্ট এবং দ্রুত বায়োকেমিস্ট্রি এনালাইসিস ও হরমোন টেস্ট প্রদান করে, যার ফলে আপনার চিকিৎসক ডায়াবেটিস নিয়ন্ত্রণের সঠিক পরিকল্পনা তৈরি করার জন্য নির্ভুল রিপোর্ট পান।</p>",
                ],
                'tags' => ['diabetes', 'health tips', 'pathology'],
                'is_featured' => false,
            ],
            [
                'category_id' => $categoryByName('Hospital News'),
                'title'   => ['en' => 'Medicare Lab: Modern Diagnostics in Sitakund', 'bn' => 'মেডিকেয়ার ল্যাব: সীতাকুণ্ডে আধুনিক ডায়াগনস্টিকস'],
                'excerpt' => [
                    'en' => 'Committed to delivering reliable pathology, imaging, and specialist consultations.',
                    'bn' => 'নির্ভরযোগ্য প্যাথলজি, ইমেজিং এবং বিশেষজ্ঞ পরামর্শ প্রদানে আমাদের প্রতিশ্রুতিবদ্ধতা।',
                ],
                'content' => [
                    'en' => "<p>Medicare Lab is dedicated to bringing state-of-the-art diagnostic services to the people of Sitakund. Our facility is equipped with modern Digital X-Ray, ECG, Echocardiography, and fully automated Biochemistry analyzers.</p><p>With our expert medical team, specialist doctor chambers, and convenient home service for sample collection, we continuously strive to provide the most reliable healthcare experience right in your neighborhood.</p>",
                    'bn' => "<p>মেডিকেয়ার ল্যাব সীতাকুণ্ডবাসীর জন্য অত্যাধুনিক ডায়াগনস্টিক সেবা নিয়ে আসতে প্রতিশ্রুতিবদ্ধ। আমাদের প্রতিষ্ঠানে আধুনিক ডিজিটাল এক্স-রে, ই.সি.জি, ইকোকার্ডিওগ্রাফি এবং সম্পূর্ণ স্বয়ংক্রিয় বায়োকেমিস্ট্রি অ্যানালাইজার রয়েছে।</p><p>আমাদের বিশেষজ্ঞ মেডিকেল টিম, বিশেষজ্ঞ ডাক্তারের চেম্বার এবং স্যাম্পল কালেকশনের জন্য সুবিধাজনক হোম সার্ভিসের মাধ্যমে, আমরা সব সময় আপনার হাতের নাগালেই সবচেয়ে নির্ভরযোগ্য স্বাস্থ্যসেবা প্রদান করতে সচেষ্ট।</p>",
                ],
                'tags' => ['news', 'community', 'diagnostics'],
                'is_featured' => false,
            ],
        ];
    }
}
