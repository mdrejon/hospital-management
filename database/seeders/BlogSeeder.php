<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $categoryByName = fn (string $en) => BlogCategory::whereJsonContains('name->en', $en)->first()?->id;

        foreach ($this->posts($categoryByName) as $i => $post) {
            $slug = Str::slug($post['title']['en']);

            Blog::updateOrCreate(
                ['slug' => $slug],
                array_merge($post, [
                    'slug'         => $slug,
                    'author_name'  => 'Sitakund Modern Hospital',
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
                    'en' => "<p>Good health starts with small, consistent habits. Drink enough water every day, eat a balanced diet with plenty of vegetables, get at least 30 minutes of physical activity, sleep 7-8 hours a night, and schedule regular health checkups.</p><p>At Sitakund Modern Hospital Ltd., our specialist doctors are available every day for consultations to help you build a healthier routine.</p>",
                    'bn' => "<p>সুস্বাস্থ্যের শুরু হয় ছোট ছোট নিয়মিত অভ্যাস থেকে। প্রতিদিন পর্যাপ্ত পানি পান করুন, সুষম খাবার ও প্রচুর শাকসবজি খান, প্রতিদিন অন্তত ৩০ মিনিট শারীরিক পরিশ্রম করুন, রাতে ৭-৮ ঘন্টা ঘুমান এবং নিয়মিত স্বাস্থ্য পরীক্ষা করান।</p><p>সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ এ আমাদের বিশেষজ্ঞ ডাক্তারগণ প্রতিদিন পরামর্শের জন্য উপস্থিত থাকেন, যা আপনাকে একটি স্বাস্থ্যকর রুটিন তৈরি করতে সাহায্য করবে।</p>",
                ],
                'tags' => ['health tips', 'wellness'],
                'is_featured' => true,
            ],
            [
                'category_id' => $categoryByName('Maternal & Child Care'),
                'title'   => ['en' => 'A Guide to Antenatal Care During Pregnancy', 'bn' => 'গর্ভাবস্থায় প্রসবপূর্ব পরিচর্যার নির্দেশিকা'],
                'excerpt' => [
                    'en' => 'What every expecting mother should know about regular checkups and care during pregnancy.',
                    'bn' => 'গর্ভাবস্থায় নিয়মিত চেকআপ ও পরিচর্যা সম্পর্কে প্রত্যেক গর্ভবতী মায়ের যা জানা প্রয়োজন।',
                ],
                'content' => [
                    'en' => "<p>Regular antenatal checkups help detect and prevent complications early. Our Gynecology & Obstetrics department offers full antenatal care, normal delivery and caesarean section services with experienced surgeons.</p><p>Visit our Gynecology chamber from Friday to Wednesday, 11:00 AM to 5:00 PM, for a consultation.</p>",
                    'bn' => "<p>নিয়মিত প্রসবপূর্ব চেকআপ জটিলতা আগেভাগে শনাক্ত ও প্রতিরোধ করতে সাহায্য করে। আমাদের স্ত্রীরোগ ও ধাত্রীবিদ্যা বিভাগে অভিজ্ঞ সার্জনদের মাধ্যমে সম্পূর্ণ গর্ভকালীন সেবা, নরমাল ডেলিভারী ও সিজার সেবা প্রদান করা হয়।</p><p>পরামর্শের জন্য শুক্রবার থেকে বুধবার সকাল ১১টা থেকে বিকাল ৫টা পর্যন্ত আমাদের গাইনী চেম্বারে আসুন।</p>",
                ],
                'tags' => ['pregnancy', 'maternal care'],
                'is_featured' => true,
            ],
            [
                'category_id' => $categoryByName('Health Tips'),
                'title'   => ['en' => 'Understanding Diabetes: Prevention and Management', 'bn' => 'ডায়াবেটিস সম্পর্কে জানুন: প্রতিরোধ ও ব্যবস্থাপনা'],
                'excerpt' => [
                    'en' => 'Key facts about diabetes and how our Diabetic Center can help you manage it.',
                    'bn' => 'ডায়াবেটিস সম্পর্কে গুরুত্বপূর্ণ তথ্য এবং আমাদের ডায়াবেটিক সেন্টার কীভাবে সাহায্য করতে পারে।',
                ],
                'content' => [
                    'en' => "<p>Diabetes has become a common condition affecting people of all ages. Early detection through regular blood sugar checkups and lifestyle changes can prevent serious complications.</p><p>Our Diabetic Center offers monthly diabetes checkups by our medical technologists, along with consultations from certified diabetologists.</p>",
                    'bn' => "<p>ডায়াবেটিস এখন সব বয়সের মানুষের মধ্যে একটি সাধারণ সমস্যা হয়ে দাঁড়িয়েছে। নিয়মিত রক্তে সুগার পরীক্ষা ও জীবনযাত্রার পরিবর্তনের মাধ্যমে গুরুতর জটিলতা প্রতিরোধ করা সম্ভব।</p><p>আমাদের ডায়াবেটিক সেন্টারে মেডিকেল টেকনোলজিস্টদের মাধ্যমে মাসিক ডায়াবেটিস চেকআপ এবং সার্টিফাইড ডায়াবেটোলজিস্টের পরামর্শ সেবা প্রদান করা হয়।</p>",
                ],
                'tags' => ['diabetes', 'health tips'],
                'is_featured' => false,
            ],
            [
                'category_id' => $categoryByName('Hospital News'),
                'title'   => ['en' => 'Sitakund Modern Hospital Marks 12 Years of Community Service', 'bn' => 'সীতাকুণ্ড মডার্ণ হসপিটালের ১২ বছরের কমিউনিটি সেবা'],
                'excerpt' => [
                    'en' => 'A look back at over a decade of serving the people of Sitakund with honest, affordable healthcare.',
                    'bn' => 'সততা ও সাশ্রয়ী মূল্যে সীতাকুণ্ডবাসীর সেবায় এক দশকেরও বেশি সময়ের পথচলা নিয়ে একটি ফিরে দেখা।',
                ],
                'content' => [
                    'en' => "<p>Since opening in January 2013, Sitakund Modern Hospital Ltd. has provided indoor healthcare to over 24,000 patients and outdoor care to more than 1,87,200 patients, supported by a dedicated team of 64 staff working around the clock.</p><p>We remain committed to expanding our facilities, including a planned nursing college and a larger, modern hospital building, to better serve Sitakund and neighbouring upazilas.</p>",
                    'bn' => "<p>২০১৩ সালের জানুয়ারিতে যাত্রা শুরুর পর থেকে সীতাকুণ্ড মডার্ণ হসপিটাল লিঃ ২৪,২৯৩ জন রোগীকে ইনডোর স্বাস্থ্যসেবা এবং ১,৮৭,২০০ এরও বেশি রোগীকে আউটডোর সেবা প্রদান করেছে, যেখানে ৬৪ জন কর্মী ২৪ ঘন্টা নিরলসভাবে কাজ করে যাচ্ছেন।</p><p>আমরা সীতাকুণ্ড ও পার্শ্ববর্তী উপজেলার মানুষদের আরও ভালো সেবা দিতে একটি নার্সিং কলেজ ও একটি বড় পরিসরের আধুনিক হাসপাতাল ভবন নির্মাণের পরিকল্পনা নিয়ে এগিয়ে যাচ্ছি।</p>",
                ],
                'tags' => ['hospital news', 'community'],
                'is_featured' => false,
            ],
        ];
    }
}
