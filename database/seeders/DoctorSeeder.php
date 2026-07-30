<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DoctorSeeder extends Seeder
{
    /**
     * Seed content sourced from the Sitakund Modern Hospital Ltd. print brochure.
     */
    public function run(): void
    {
        foreach ($this->doctors() as $doctor) {
            Doctor::updateOrCreate(
                ['slug' => Str::slug($doctor['name'])],
                array_merge($this->normaliseLists($doctor), ['slug' => Str::slug($doctor['name'])])
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
                'name'       => 'Dr. Afroza Talukder',
                'role'       => [
                    'en' => 'Gynecology & Obstetrics Surgeon',
                    'bn' => 'স্ত্রীরোগ ও ধাত্রীবিদ্যায় অভিজ্ঞ সার্জন',
                ],
                'specialty'  => [
                    'en' => 'Gynecology & Obstetrics',
                    'bn' => 'স্ত্রীরোগ ও ধাত্রীবিদ্যা',
                ],
                'degrees'    => [
                    'en' => 'MBBS, PGT (Obs & Gynae)',
                    'bn' => 'এম.বি.বি.এস, পিজিটি (অবস্ এন্ড গাইনী)',
                ],
                'experience' => [
                    'en' => 'Ex-Medical Officer, Sarat Abida General Hospital, Saudi Arabia. Ex-Resident Doctor, Zahurul Islam Medical College Hospital, Bajitpur, Kishoreganj. BMDC Reg. No. A-28214',
                    'bn' => 'এক্স মেডিকেল অফিসার, সারাত আবিদা জেনারেল হাসপাতাল, সৌদি আরব। এক্স রেসিডেন্ট ডক্টর, জহুরুল ইসলাম মেডিকেল কলেজ হাসপাতাল, বাজিতপুর, কিশোরগঞ্জ। বিএমডিসি রেজি: নং- এ ২৮২১৪',
                ],
                'bio'        => [
                    'en' => 'Treatment of all gynecological diseases, antenatal care for pregnant women, irregular menstruation, lower abdominal pain, normal delivery, caesarean section, and infertility treatment & surgical care.',
                    'bn' => 'সকল প্রকার গাইনী রোগের চিকিৎসা, গর্ভবতী নারীদের গর্ভকালীন চিকিৎসা, অনিয়মিত ঋতুস্রাব, তলপেটে ব্যাথা, নরমাল ডেলিভারী, সিজার, বন্ধ্যাত্বের চিকিৎসা ও অপারেশন সেবা।',
                ],
                'skills'     => [
                    ['en' => 'Normal Delivery', 'bn' => 'নরমাল ডেলিভারী'],
                    ['en' => 'Caesarean Section', 'bn' => 'সিজার'],
                    ['en' => 'Infertility Treatment', 'bn' => 'বন্ধ্যাত্বের চিকিৎসা'],
                ],
                'schedule'   => [
                    ['day' => 'Friday - Wednesday', 'time' => '11:00 AM - 5:00 PM'],
                ],
                'address'    => 'Amirabad (Sitakund South Bypass) 07, Sitakund Municipality, Sitakund, Chattogram',
                'phone'      => '01849-727858',
                'email'      => 'sitakundmodernhospital@gmail.com',
                'is_featured' => true,
                'sort_order' => 1,
                'is_active'  => true,
            ],
            [
                'name'       => 'Dr. Bijoy Talukder',
                'role'       => [
                    'en' => 'Neonatal & Pediatric Specialist',
                    'bn' => 'নবজাতক ও শিশুরোগ বিশেষজ্ঞ',
                ],
                'specialty'  => [
                    'en' => 'Neonatal & Pediatrics',
                    'bn' => 'নবজাতক ও শিশুরোগ',
                ],
                'degrees'    => [
                    'en' => 'MBBS, MD (Child Health), Bangabandhu Sheikh Mujib Medical University',
                    'bn' => 'এম.বি.বি.এস, এম.ডি (শিশু স্বাস্থ্য), বঙ্গবন্ধু শেখ মুজিব মেডিকেল বিশ্ববিদ্যালয়',
                ],
                'experience' => [
                    'en' => 'Consultant (NICU & PICU), Medical Centre Hospital, Chattogram. Ex-Consultant, Chattogram Mother & Child General Hospital, Chattogram. BMDC Reg. No. A-57188',
                    'bn' => 'কনসালটেন্ট (এন.আই.সি.ইউ এবং পি.আই.সি.ইউ), মেডিকেল সেন্টার হাসপাতাল, চট্টগ্রাম। চট্টগ্রাম মা ও শিশু জেনারেল হাসপাতাল, চট্টগ্রাম (এক্স)। বিএমডিসি রেজি: নং- এ-৫৭১৮৮',
                ],
                'bio'        => [
                    'en' => 'Fever & convulsion, loss of appetite, cold & cough, sore throat & tonsillitis, breathing difficulty, indigestion, vomiting, diarrhea, urinary problems, abdominal pain, measles & chicken pox, pneumonia, allergy and scabies.',
                    'bn' => 'জ্বর ও খিঁচুনী, খাবারে অনিহা, সর্দি ও কাশি, গলা ব্যাথা ও টনসিল, শ্বাসকষ্ট, বদহজম, বমি, ডায়রিয়া, প্রস্রাবে সমস্যা, পেটে ব্যাথা, হাম চিকেন পক্স, নিউমোনিয়া, এলার্জি ও খোসপাঁচড়া।',
                ],
                'skills'     => [
                    ['en' => 'NICU & PICU Care', 'bn' => 'এন.আই.সি.ইউ ও পি.আই.সি.ইউ'],
                    ['en' => 'Newborn Care', 'bn' => 'নবজাতকের যত্ন'],
                ],
                'schedule'   => [
                    ['day' => 'Daily (Closed on Thursday)', 'time' => '4:00 PM - 6:00 PM'],
                ],
                'address'    => 'Amirabad (Sitakund South Bypass) 07, Sitakund Municipality, Sitakund, Chattogram',
                'phone'      => '01849-727858',
                'email'      => 'sitakundmodernhospital@gmail.com',
                'is_featured' => true,
                'sort_order' => 2,
                'is_active'  => true,
            ],
            [
                'name'       => 'Dr. Mohammad Omor Faruk Tuhin',
                'role'       => [
                    'en' => 'General Laparoscopic & Colorectal Surgeon',
                    'bn' => 'জেনারেল ল্যাপারোস্কপিক ও কলোরেক্টাল সার্জন',
                ],
                'specialty'  => [
                    'en' => 'Laparoscopic & Colorectal Surgery',
                    'bn' => 'ল্যাপারোস্কপিক ও কলোরেক্টাল সার্জারী',
                ],
                'degrees'    => [
                    'en' => 'MBBS, BCS (Health), FCPS (Surgery)',
                    'bn' => 'এমবিবিএস, বিসিএস (স্বাস্থ্য), এফসিপিএস (সার্জারী)',
                ],
                'experience' => [
                    'en' => 'Assistant Professor, Chattogram Medical College Hospital.',
                    'bn' => 'সহকারী অধ্যাপক, চট্টগ্রাম মেডিকেল কলেজ হাসপাতাল।',
                ],
                'bio'        => [
                    'en' => 'Laparoscopic gallbladder stone removal, appendicitis, hernia, stomach perforation, colorectal surgery for intestinal obstruction, intestinal tumor/cancer surgery, laser surgery for piles, fistula/anal fissure/hemorrhoid surgery, breast tumor/cancer and other surgical care.',
                    'bn' => 'ল্যাপারোস্কপিক মেশিনের মাধ্যমে পিত্তথলির পাথর অপারেশন, অ্যাপেন্ডিসাইটিস, হার্নিয়া, পাকস্থলীর ছিদ্র, কোলোরেক্টাল সার্জারী, ক্ষুদ্রান্ত/বৃহদান্তের প্রতিবন্ধকতার চিকিৎসা, ক্ষুদ্রান্ত/বৃহদন্ত্রের টিউমার বা ক্যান্সার অপারেশন, লেজার অপারেশন-পাইলস, ফিস্টুলা/এনাল ফিশার/হেমোরয়েড অপারেশন, স্তনের টিউমার/ক্যান্সারসহ অন্যান্য রোগের শল্য চিকিৎসা।',
                ],
                'skills'     => [
                    ['en' => 'Laparoscopic Surgery', 'bn' => 'ল্যাপারোস্কপিক সার্জারী'],
                    ['en' => 'Colorectal Surgery', 'bn' => 'কোলোরেক্টাল সার্জারী'],
                ],
                'schedule'   => [
                    ['day' => 'Monday & Thursday', 'time' => '3:00 PM - 5:00 PM'],
                ],
                'address'    => 'Amirabad (Sitakund South Bypass) 07, Sitakund Municipality, Sitakund, Chattogram',
                'phone'      => '01849-727858',
                'email'      => 'sitakundmodernhospital@gmail.com',
                'is_featured' => false,
                'sort_order' => 3,
                'is_active'  => true,
            ],
            [
                'name'       => 'Dr. Md. S.S. Talukder',
                'role'       => [
                    'en' => 'Orthopedic Surgeon & Disability Specialist',
                    'bn' => 'অর্থোপেডিক সার্জন ও বিকলাঙ্গ রোগে অভিজ্ঞ',
                ],
                'specialty'  => [
                    'en' => 'Orthopedics',
                    'bn' => 'অর্থোপেডিক্স',
                ],
                'degrees'    => [
                    'en' => 'MBBS (RU), PGT (Ortho), MS (Orthopedics) Course, Bangabandhu Sheikh Mujib Medical University',
                    'bn' => 'এমবিবিএস (আরইউ), পিজিটি (অর্থো), এমএস (অর্থোপেডিক্স) কোর্স, বঙ্গবন্ধু শেখ মুজিব মেডিকেল বিশ্ববিদ্যালয়',
                ],
                'experience' => [
                    'en' => 'BMDC Reg. No. A-96352',
                    'bn' => 'বিএমডিসি রেজি: নং এ-৯৬৩৫২',
                ],
                'bio'        => [
                    'en' => 'Fracture (bone joint break), trauma (accident) management, total hip replacement, total knee replacement, ligament repair/reconstruction, spine injury treatment, paralysis treatment, and nerve related disease treatment.',
                    'bn' => 'ফ্র্যাকচার (হাড় জোড় ভাঙ্গা), ট্রমা (এক্সিডেন্ট)-ম্যানেজমেন্ট, টোটাল হিপ রিপ্লেসমেন্ট, টোটাল নী (হাঁটু) রিপ্লেসমেন্ট, লিগামেন্ট (রগ) রিপেয়ার/রিকনস্ট্রাকশন, স্পাইন ইনজুরীর চিকিৎসা, পঙ্গু ও পক্ষাঘাত চিকিৎসা, নার্ভ ও স্নায়ু রোগের চিকিৎসা।',
                ],
                'skills'     => [
                    ['en' => 'Total Hip Replacement', 'bn' => 'টোটাল হিপ রিপ্লেসমেন্ট'],
                    ['en' => 'Total Knee Replacement', 'bn' => 'টোটাল নী রিপ্লেসমেন্ট'],
                ],
                'schedule'   => [
                    ['day' => 'Every Saturday & Tuesday', 'time' => '3:00 PM - 6:00 PM'],
                ],
                'address'    => 'Amirabad (Sitakund South Bypass) 07, Sitakund Municipality, Sitakund, Chattogram',
                'phone'      => '01849-727858',
                'email'      => 'sitakundmodernhospital@gmail.com',
                'is_featured' => false,
                'sort_order' => 4,
                'is_active'  => true,
            ],
            [
                'name'       => 'Dr. Shuvo Das Gupta',
                'role'       => [
                    'en' => 'Medicine Specialist',
                    'bn' => 'মেডিসিন বিশেষজ্ঞ',
                ],
                'specialty'  => [
                    'en' => 'Medicine',
                    'bn' => 'মেডিসিন',
                ],
                'degrees'    => [
                    'en' => 'MBBS; CCD (BIRDEM), PGT (Medicine), PGT (Surgery), Chattogram Medical College Hospital',
                    'bn' => 'এমবিবিএস; সি.সি.ডি (বারডেম), পি.জি.টি (মেডিসিন), পি.জি.টি (সার্জারি), চট্টগ্রাম মেডিকেল কলেজ হাসপাতাল',
                ],
                'experience' => [
                    'en' => 'BMDC Reg. No. A-116475',
                    'bn' => 'বি.এম.ডি.সি. রেজি: এ-১১৬৪৭৫',
                ],
                'bio'        => [
                    'en' => 'Medicine, dermatology, pediatric diseases, bone fractures, arthritis pain, asthma, diabetes and heart disease.',
                    'bn' => 'মেডিসিন, চর্মরোগ, শিশুরোগ, হাড়ভাঙ্গা জোড়া, বাত ব্যাথা, এ্যাজমা, ডায়াবেটিস ও হৃদরোগে অভিজ্ঞ।',
                ],
                'skills'     => [
                    ['en' => 'Diabetes Management', 'bn' => 'ডায়াবেটিস ব্যবস্থাপনা'],
                    ['en' => 'General Medicine', 'bn' => 'জেনারেল মেডিসিন'],
                ],
                'schedule'   => [
                    ['day' => 'Wednesday - Sunday', 'time' => '9:00 AM - 2:00 PM & 4:00 PM - 9:00 PM'],
                    ['day' => 'Emergency', 'time' => 'Available 24/7'],
                ],
                'address'    => 'Amirabad (Sitakund South Bypass) 07, Sitakund Municipality, Sitakund, Chattogram',
                'phone'      => '01849-727858',
                'email'      => 'sitakundmodernhospital@gmail.com',
                'is_featured' => false,
                'sort_order' => 5,
                'is_active'  => true,
            ],
            [
                'name'       => 'Dr. Md. Jobayer Hossen Tarek',
                'role'       => [
                    'en' => 'Medicine Specialist',
                    'bn' => 'মেডিসিন বিশেষজ্ঞ',
                ],
                'specialty'  => [
                    'en' => 'Medicine',
                    'bn' => 'মেডিসিন',
                ],
                'degrees'    => [
                    'en' => 'MBBS, BCS (Health), MD (Medicine), Bangladesh Medical University (Ex-PG Hospital), Dhaka. Certified Diabetologist (BIRDEM)',
                    'bn' => 'এমবিবিএস, বিসিএস (স্বাস্থ্য), এমডি (মেডিসিন), বাংলাদেশ মেডিকেল বিশ্ববিদ্যালয় (এক্স-পিজি হাসপাতাল), ঢাকা। সার্টিফাইড ডায়াবেটোলজিস্ট (বারডেম)',
                ],
                'experience' => [
                    'en' => 'BMDC Reg. No. A-67602',
                    'bn' => 'বি এম ডি সি রেজি. নং- এ-৬৭৬০২',
                ],
                'bio'        => [
                    'en' => 'General medicine and certified diabetes care.',
                    'bn' => 'জেনারেল মেডিসিন ও সার্টিফাইড ডায়াবেটিস চিকিৎসা।',
                ],
                'skills'     => [
                    ['en' => 'Diabetology', 'bn' => 'ডায়াবেটোলজি'],
                ],
                'schedule'   => [
                    ['day' => 'Every Friday', 'time' => '10:00 AM - 1:00 PM'],
                ],
                'address'    => 'Amirabad (Sitakund South Bypass) 07, Sitakund Municipality, Sitakund, Chattogram',
                'phone'      => '01849-727858',
                'email'      => 'sitakundmodernhospital@gmail.com',
                'is_featured' => false,
                'sort_order' => 6,
                'is_active'  => true,
            ],
        ];
    }
}
