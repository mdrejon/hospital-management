<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class DoctorSeeder extends Seeder
{
    /**
     * Seed content sourced from the updated doctor images.
     */
    public function run(): void
    {
        // Disable foreign key checks, truncate to remove existing records, and re-enable
        Schema::disableForeignKeyConstraints();
        Doctor::truncate();
        Schema::enableForeignKeyConstraints();

        foreach ($this->doctors() as $doctor) {
            $slugName = is_array($doctor['name']) ? ($doctor['name']['en'] ?? reset($doctor['name'])) : $doctor['name'];
            
            Doctor::create(
                array_merge($this->normaliseLists($doctor), ['slug' => Str::slug($slugName)])
            );
        }
    }

    /**
     * Specialty/degrees/experience/awards each store a *list* of translatable values,
     * so a doctor can have several. The blocks below spell them out as a single
     * {locale => text} map for readability — wrap those into one-entry lists.
     */
    private function normaliseLists(array $doctor): array
    {
        foreach (Doctor::TRANSLATABLE_LISTS as $field) {
            if (isset($doctor[$field]) && is_array($doctor[$field]) && !array_is_list($doctor[$field])) {
                $doctor[$field] = [$doctor[$field]];
            }
        }

        return $doctor;
    }

    private function doctors(): array
    {
        return [
            [
                'name'       => ['en' => 'Dr. Md. Tanjil Kaysar (Anik)', 'bn' => 'ডা: মো: তানজিল কায়সার (অনিক)'],
                'role'       => ['en' => 'Cardiologist', 'bn' => 'হৃদরোগ বিশেষজ্ঞ'],
                'specialty'  => ['en' => 'Cardiology', 'bn' => 'কার্ডিওলজি'],
                'degrees'    => [
                    ['en' => 'MBBS', 'bn' => 'এমবিবিএস'],
                    ['en' => 'MD (Cardiology)', 'bn' => 'এমডি (কার্ডিওলজি)'],
                ],
                'experience' => [
                    ['en' => 'Bangladesh Medical University (Ex PG Hospital)', 'bn' => 'বাংলাদেশ মেডিক্যাল বিশ্ববিদ্যালয় (এক্স পিজি হসপিটাল)'],
                    ['en' => 'Apollo Imperial Hospital, Chattogram', 'bn' => 'অ্যাপোলো ইম্পেরিয়াল হসপিটাল, চট্টগ্রাম'],
                ],
                'bio'        => ['en' => '', 'bn' => ''],
                'skills'     => [
                    ['en' => 'Heart Health Checkup', 'bn' => 'হার্টের নিয়মিত চেকআপ'],
                    ['en' => 'High Blood Pressure & Heart Failure Treatment', 'bn' => 'উচ্চ রক্তচাপ, হৃদরোগ ও হার্ট ফেইলিউর চিকিৎসা'],
                    ['en' => 'ECG & Echocardiography', 'bn' => 'ইসিজি ও ইকোকার্ডিওগ্রাফি'],
                ],
                'schedule'   => [
                    ['day' => ['en' => 'Saturday & Wednesday', 'bn' => 'শনিবার ও বুধবার'], 'time' => ['en' => '5:00 PM - 7:00 PM', 'bn' => 'বিকেল ৫টা থেকে ৭টা']],
                ],
                'address'    => [
                    'en' => 'Sitakunda Modern Hospital Ltd., Amirabad (Sitakunda South Bypass) 07, Sitakunda Municipality, Sitakunda, Chattogram',
                    'bn' => 'সীতাকুণ্ড মডার্ন হাসপাতাল লিঃ, আমিরাবাদ (সীতাকুণ্ড দক্ষিণ বাইপাস) ০৭, সীতাকুণ্ড পৌরসভা, সীতাকুণ্ড, চট্টগ্রাম',
                ],
                'phone'      => [
                    'en' => '01849-727858, 01974-300821',
                    'bn' => '০১৮৪৯-৭২৭৮৫৮, ০১৯৭৪-৩০০৮২১',
                ],
                'is_featured' => true,
                'sort_order' => 1,
                'is_active'  => true,
            ],
            [
                'name'       => ['en' => 'Dr. Monir Uddin Rubel', 'bn' => 'ডা: মনির উদ্দীন রুবেল'],
                'role'       => ['en' => 'Medicine & Surgery Trained Physician', 'bn' => 'মেডিসিন ও সার্জারিতে প্রশিক্ষণপ্রাপ্ত চিকিৎসক'],
                'specialty'  => ['en' => 'Medicine', 'bn' => 'মেডিসিন'],
                'degrees'    => [
                    ['en' => 'MBBS', 'bn' => 'এমবিবিএস'],
                    ['en' => 'Medical Officer, BGC Trust Medical & College Hospital', 'bn' => 'মেডিকেল অফিসার, বিজিএমসি ট্রাস্ট মেডিকেল ও কলেজ হাসপাতাল'],
                    ['en' => 'PGT (Medicine), CMU, DMU', 'bn' => 'পিজিটি (মেডিসিন), সিএমইউ, ডিএমইউ'],
                ],
                'experience' => [],
                'bio'        => ['en' => '', 'bn' => ''],
                'skills'     => [
                    ['en' => 'All kinds of medicine related diseases', 'bn' => 'মেডিসিন বিষয়ক সকল রোগের চিকিৎসা'],
                    ['en' => 'Surgery Consultation', 'bn' => 'সার্জারি বিষয়ক পরামর্শ ও চিকিৎসা'],
                    ['en' => 'Fever, Cold, Cough, Asthma', 'bn' => 'জ্বর, সর্দি, কাশি, অ্যাজমা'],
                ],
                'schedule'   => [
                    ['day' => ['en' => 'Every Friday', 'bn' => 'প্রতি শুক্রবার'], 'time' => ['en' => 'Morning to afternoon', 'bn' => 'সকাল থেকে চেম্বারে রোগী দেখবেন']],
                ],
                'address'    => [
                    'en' => 'Medicare Lab, Sitakunda Bazar, Ali Market, Chattogram',
                    'bn' => 'মেডিকেয়ার ল্যাব, সীতাকুণ্ড বাজার, আলী মার্কেট, চট্টগ্রাম',
                ],
                'phone'      => [
                    'en' => '01711-307275',
                    'bn' => '01711-307275',
                ],
                'is_featured' => true,
                'sort_order' => 2,
                'is_active'  => true,
            ],
            [
                'name'       => ['en' => 'Dr. Muhammad Shahnewaz Parvez Sohel', 'bn' => 'ডা: মুহাম্মদ শাহনেওয়াজ পারভেজ সোহেল'],
                'role'       => ['en' => 'Specialist Doctor', 'bn' => 'বিশেষজ্ঞ চিকিৎসক'],
                'specialty'  => ['en' => 'Medicine & Diabetology', 'bn' => 'মেডিসিন ও ডায়াবেটোলজি'],
                'degrees'    => [
                    ['en' => 'MBBS', 'bn' => 'এমবিবিএস'],
                    ['en' => 'PGT (Medicine)', 'bn' => 'পিজিটি (মেডিসিন)'],
                    ['en' => 'PGT (Skin & Venereal Disease)', 'bn' => 'পিজিটি (চর্ম ও যৌন রোগ)'],
                    ['en' => 'CCD (Diabetology)', 'bn' => 'সিসিডি (ডায়াবেটোলজী)'],
                ],
                'experience' => [
                    ['en' => 'Chattogram Medical College Hospital', 'bn' => 'চট্টগ্রাম মেডিকেল কলেজ হাসপাতাল']
                ],
                'bio'        => ['en' => '', 'bn' => ''],
                'skills'     => [
                    ['en' => 'General Disease Treatment', 'bn' => 'সাধারণ রোগের চিকিৎসা'],
                    ['en' => 'Diabetes, Pressure, Thyroid', 'bn' => 'ডায়াবেটিস, প্রেসার, থাইরয়েড'],
                    ['en' => 'Skin, Hair & Venereal Disease Treatment', 'bn' => 'চর্ম, চুল ও যৌন রোগের চিকিৎসা'],
                    ['en' => 'Hormonal Problems', 'bn' => 'হরমোনের সমস্যা'],
                    ['en' => 'Digestion Problems', 'bn' => 'হজমজনিত সমস্যা'],
                    ['en' => 'Health Consultation', 'bn' => 'স্বাস্থ্য পরামর্শ'],
                ],
                'schedule'   => [
                    ['day' => ['en' => 'Every Monday & Thursday', 'bn' => 'প্রতি সোমবার ও বৃহস্পতিবার'], 'time' => ['en' => 'From 3:00 PM', 'bn' => 'বিকাল ৩টা থেকে']],
                    ['day' => ['en' => 'Saturday', 'bn' => 'শনিবার'], 'time' => ['en' => '4:00 PM - 8:00 PM', 'bn' => 'বিকাল ৪টা - ৮টা']],
                ],
                'address'    => [
                    'en' => 'Medicare Lab, Sitakunda Bazar, Ali Market, Chattogram',
                    'bn' => 'মেডিকেয়ার ল্যাব, সীতাকুন্ড বাজার, আলী মার্কেট, চট্টগ্রাম',
                ],
                'phone'      => [
                    'en' => '01711307275',
                    'bn' => '01711307275',
                ],
                'is_featured' => true,
                'sort_order' => 3,
                'is_active'  => true,
            ],
            [
                'name'       => ['en' => 'Soni Das', 'bn' => 'সনি দাস'],
                'role'       => ['en' => 'Experienced Eye Specialist', 'bn' => 'অভিজ্ঞ দৃষ্টি বিশেষজ্ঞ'],
                'specialty'  => ['en' => 'Optometry', 'bn' => 'অপটোমেট্রি'],
                'degrees'    => [
                    ['en' => 'B.Sc in Optometry (Chattogram Medical University)', 'bn' => 'বি.এস.সি ইন অপটোমেট্রি (চট্টগ্রাম মেডিকেল বিশ্ববিদ্যালয়)'],
                    ['en' => 'Optometrist (Faculty)', 'bn' => 'অপটোমেট্রিস্ট (ফ্যাকাল্টি)'],
                    ['en' => 'Trained OR.B.S (America)', 'bn' => 'ট্রেইনড অর.বি.এস (আমেরিকা)'],
                ],
                'experience' => [
                    ['en' => 'Institute of Community Ophthalmology, Pahartali Eye Hospital, Chattogram', 'bn' => 'ইন ইন্সটিটিউট অব কমিউনিটি অফথালমোলজি, পাহাড়তলী চক্ষু হাসপাতাল, চট্টগ্রাম'],
                ],
                'bio'        => ['en' => '', 'bn' => ''],
                'skills'     => [
                    ['en' => 'Eye Checkup', 'bn' => 'চোখের পরীক্ষা'],
                    ['en' => 'Spectacles Power determination', 'bn' => 'চশমার পাওয়ার নির্ণয়'],
                    ['en' => 'Contact Lens Consultation', 'bn' => 'কন্ট্যাক্ট লেন্স পরামর্শ'],
                ],
                'schedule'   => [
                    ['day' => ['en' => 'Every Saturday', 'bn' => 'প্রতি শনিবার'], 'time' => ['en' => '3:00 PM - 6:00 PM', 'bn' => 'বিকাল ৩টা থেকে সন্ধ্যা ৬টা পর্যন্ত']],
                ],
                'address'    => [
                    'en' => 'Medicare Lab & Faruk Medical Hall, Ali Market, Sitakunda Bazar, Chattogram',
                    'bn' => 'মেডিকেয়ার ল্যাব ও ফারুক মেডিকেল হল, আলী মার্কেট, সীতাকুণ্ড বাজার, চট্টগ্রাম',
                ],
                'phone'      => [
                    'en' => '01711-307275',
                    'bn' => '01711-307275',
                ],
                'is_featured' => true,
                'sort_order' => 4,
                'is_active'  => true,
            ],
            [
                'name'       => ['en' => 'Dr. Dhiman Chowdhury', 'bn' => 'ডা: ধীমান চৌধুরী'],
                'role'       => ['en' => 'Newborn, Child & Adolescent Disease Specialist', 'bn' => 'নবজাত শিশু ও কিশোর রোগ বিশেষজ্ঞ'],
                'specialty'  => ['en' => 'Pediatrics', 'bn' => 'শিশুরোগ'],
                'degrees'    => [
                    ['en' => 'MBBS, BCS (Health)', 'bn' => 'এমবিবিএস, বিসিএস (স্বাস্থ্য)'],
                    ['en' => 'FCPS (Newborn, Child and Adolescent Disease Specialist)', 'bn' => 'এফসিপিএস (নবজাত শিশু ও কিশোর রোগ বিশেষজ্ঞ)'],
                ],
                'experience' => [
                    ['en' => 'Chattogram Medical College Hospital', 'bn' => 'চট্টগ্রাম মেডিকেল কলেজ হাসপাতাল'],
                ],
                'bio'        => ['en' => '', 'bn' => ''],
                'skills'     => [
                    ['en' => 'Newborn Care & Treatment', 'bn' => 'নবজাত শিশুর যত্ন ও চিকিৎসা'],
                    ['en' => 'Child & Adolescent Diseases', 'bn' => 'শিশু ও কিশোর রোগের চিকিৎসা'],
                    ['en' => 'Asthma, Pneumonia Treatment', 'bn' => 'শ্বাসকষ্ট, নিউমোনিয়া, অ্যাজমা চিকিৎসা'],
                ],
                'schedule'   => [
                    ['day' => ['en' => 'Sun, Tue, Thu & Fri', 'bn' => 'রবিবার, মঙ্গলবার, বৃহস্পতিবার ও শুক্রবার'], 'time' => ['en' => 'From 3:00 PM', 'bn' => 'বিকাল ৩টা থেকে']],
                ],
                'address'    => [
                    'en' => 'Medicare Lab, Sitakunda Bazar, Ali Market, Chattogram',
                    'bn' => 'মেডিকেয়ার ল্যাব, সীতাকুণ্ড বাজার, আলী মার্কেট, চট্টগ্রাম',
                ],
                'phone'      => [
                    'en' => '01711-307275',
                    'bn' => '01711307275',
                ],
                'is_featured' => true,
                'sort_order' => 5,
                'is_active'  => true,
            ],
        ];
    }
}
