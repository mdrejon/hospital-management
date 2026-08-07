<?php

namespace Database\Seeders;

use App\Models\AgentProfile;
use App\Models\MedicalTest;
use App\Models\MedicalTestCategory;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MedicalTestAndAgentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Agent Role
        $agentRole = Role::firstOrCreate(
            ['slug' => 'agent'],
            [
                'name'           => 'Agent',
                'description'    => 'Booking doctor appointments and medical tests with commission management.',
                'is_super_admin' => false,
                'is_active'      => true,
            ]
        );

        $modules = [
            'dashboard'        => ['view' => true],
            'agent-portal'     => ['view' => true, 'create' => true, 'edit' => true],
            'medical-tests'    => ['view' => true, 'create' => true],
            'appointments'     => ['view' => true, 'create' => true],
        ];

        foreach ($modules as $moduleKey => $actions) {
            RolePermission::updateOrCreate(
                ['role_id' => $agentRole->id, 'module_key' => $moduleKey],
                [
                    'can_view'   => $actions['view'] ?? false,
                    'can_create' => $actions['create'] ?? false,
                    'can_edit'   => $actions['edit'] ?? false,
                    'can_delete' => $actions['delete'] ?? false,
                ]
            );
        }

        // Create a demo Agent User if not exists
        $demoAgentUser = User::firstOrCreate(
            ['email' => 'agent@modernhospital.com'],
            [
                'name'      => 'Demo Medical Agent',
                'password'  => Hash::make('12345678'),
                'role_id'   => $agentRole->id,
                'is_active' => true,
            ]
        );

        AgentProfile::firstOrCreate(
            ['user_id' => $demoAgentUser->id],
            [
                'agent_code'                 => 'AGT-1001',
                'phone'                      => '01711223344',
                'nid_number'                 => '19901234567890123',
                'address'                    => 'Sitakund Market, Chittagong',
                'city'                       => 'Chittagong',
                'commission_type'            => 'percentage',
                'doctor_commission_rate'     => 10.00,
                'test_commission_rate'       => 15.00,
                'wallet_balance'             => 1250.00,
                'total_earned_commission'    => 3500.00,
                'total_withdrawn_commission' => 2250.00,
                'payout_method'              => 'bkash',
                'payout_account_number'      => '01711223344',
                'payout_account_type'        => 'personal',
                'status'                     => AgentProfile::STATUS_ACTIVE,
                'approved_at'                => now(),
            ]
        );

        // 2. Create Medical Test Categories
        $categories = [
            [
                'name'        => ['en' => 'Pathology', 'bn' => 'প্যাথলজি'],
                'slug'        => 'pathology',
                'description' => ['en' => 'Blood, urine, and body fluid laboratory examinations', 'bn' => 'রক্ত, প্রস্রাব ও শারীরিক তরলের ল্যাব পরীক্ষা'],
                'icon'        => 'flask',
                'sort_order'  => 1,
            ],
            [
                'name'        => ['en' => 'Radiology & Imaging', 'bn' => 'রেডিওলজি ও ইমেজিং'],
                'slug'        => 'radiology-imaging',
                'description' => ['en' => 'X-Ray, Ultrasound, CT Scan, and MRI diagnostic services', 'bn' => 'এক্স-রে, আল্ট্রাসাউন্ড, সিটি স্ক্যান ও এমআরআই'],
                'icon'        => 'film',
                'sort_order'  => 2,
            ],
            [
                'name'        => ['en' => 'Biochemistry & Serology', 'bn' => 'বায়োকেমিস্ট্রি ও সেরোলজি'],
                'slug'        => 'biochemistry',
                'description' => ['en' => 'Chemical pathology, hormone tests, liver and kidney profile', 'bn' => 'রাসায়নিক প্যাথলজি, হরমোন, লিভার ও কিডনি প্রোফাইল'],
                'icon'        => 'activity',
                'sort_order'  => 3,
            ],
            [
                'name'        => ['en' => 'Cardiology Diagnostics', 'bn' => 'কার্ডিওলজি ডায়াগনস্টিকস'],
                'slug'        => 'cardiology',
                'description' => ['en' => 'ECG, Echocardiogram, and cardiac enzyme profiles', 'bn' => 'ইসিজি, ইকোকার্ডিওগ্রাম ও হার্ট প্রোফাইল'],
                'icon'        => 'heart',
                'sort_order'  => 4,
            ],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $model = MedicalTestCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
            $categoryModels[$cat['slug']] = $model;
        }

        // 3. Create Sample Medical Tests
        $tests = [
            [
                'category_slug'            => 'pathology',
                'code'                     => 'TEST-CBC-01',
                'name'                     => ['en' => 'Complete Blood Count (CBC) with ESR', 'bn' => 'কমপ্লিট ব্লাড কাউন্ট (সিবিসি)'],
                'description'              => ['en' => 'Measures red & white blood cells, platelets, and hemoglobin count.', 'bn' => 'রক্তের সার্বিক অবস্থার বিশদ পরীক্ষা।'],
                'price'                    => 400.00,
                'discount_type'            => 'percentage',
                'discount_amount'          => 10.00,
                'final_price'              => 360.00,
                'preparation_instructions' => ['en' => 'No special fasting is required.', 'bn' => 'বিশেষ কোনো প্রস্তুতির প্রয়োজন নেই।'],
                'estimated_delivery_time'  => 'Same Day (4 Hours)',
                'sort_order'               => 1,
            ],
            [
                'category_slug'            => 'biochemistry',
                'code'                     => 'TEST-LIPID-02',
                'name'                     => ['en' => 'Lipid Profile (Cholesterol, HDL, LDL, TG)', 'bn' => 'লিপিড প্রোফাইল (কোলেস্টেরল)'],
                'description'              => ['en' => 'Evaluates heart disease risk and blood lipid levels.', 'bn' => 'রক্তে চর্বি এবং হৃদরোগের ঝুঁকি পরিমাপ।'],
                'price'                    => 900.00,
                'discount_type'            => 'fixed',
                'discount_amount'          => 100.00,
                'final_price'              => 800.00,
                'preparation_instructions' => ['en' => '10-12 hours overnight fasting required.', 'bn' => '১০-১২ ঘণ্টা খালি পেটে থাকতে হবে।'],
                'estimated_delivery_time'  => '24 Hours',
                'sort_order'               => 2,
            ],
            [
                'category_slug'            => 'biochemistry',
                'code'                     => 'TEST-FBS-03',
                'name'                     => ['en' => 'Fasting Blood Sugar (FBS) & HbA1c', 'bn' => 'ব্লাড সুগার ও এইচবিএ১সি (ডায়াবেটিস)'],
                'description'              => ['en' => 'Measures average blood glucose over the past 3 months.', 'bn' => 'ডায়াবেটিস নিয়ন্ত্রণ ও রক্তের গ্লুকোজ পর্যবেক্ষণ।'],
                'price'                    => 1100.00,
                'discount_type'            => 'percentage',
                'discount_amount'          => 15.00,
                'final_price'              => 935.00,
                'preparation_instructions' => ['en' => '8-10 hours fasting required.', 'bn' => '৮-১০ ঘণ্টা খালি পেটে থাকতে হবে।'],
                'estimated_delivery_time'  => 'Same Day',
                'sort_order'               => 3,
            ],
            [
                'category_slug'            => 'radiology-imaging',
                'code'                     => 'TEST-USG-04',
                'name'                     => ['en' => 'USG of Whole Abdomen with PVR', 'bn' => 'ইউএসজি হোল অ্যাবডোমেন'],
                'description'              => ['en' => 'Ultrasound imaging of liver, gallbladder, kidneys, and spleen.', 'bn' => 'পেটের অভ্যন্তরীণ অঙ্গপ্রত্যঙ্গের আল্ট্রাসনোগ্রাম।'],
                'price'                    => 1500.00,
                'discount_type'            => 'none',
                'discount_amount'          => 0.00,
                'final_price'              => 1500.00,
                'preparation_instructions' => ['en' => 'Fasting 6 hours, full bladder required.', 'bn' => '৬ ঘণ্টা না খেয়ে ও প্রস্রাবের বেগ থাকতে হবে।'],
                'estimated_delivery_time'  => 'Immediate (1 Hour)',
                'sort_order'               => 4,
            ],
            [
                'category_slug'            => 'radiology-imaging',
                'code'                     => 'TEST-XRAY-05',
                'name'                     => ['en' => 'Digital Chest X-Ray (P/A View)', 'bn' => 'ডিজিটাল চেস্ট এক্স-রে (পি/এ)'],
                'description'              => ['en' => 'High resolution digital radiography of lungs and thoracic cage.', 'bn' => 'বুকের ডিজিটাল এক্স-রে পরীক্ষা।'],
                'price'                    => 600.00,
                'discount_type'            => 'percentage',
                'discount_amount'          => 10.00,
                'final_price'              => 540.00,
                'preparation_instructions' => ['en' => 'Remove metallic jewelry and accessories.', 'bn' => 'ধাতব অলঙ্কার বা জিনিসপত্র খুলে রাখুন।'],
                'estimated_delivery_time'  => '30 Minutes',
                'sort_order'               => 5,
            ],
            [
                'category_slug'            => 'cardiology',
                'code'                     => 'TEST-ECG-06',
                'name'                     => ['en' => '12-Lead Electrocardiogram (ECG)', 'bn' => '১২-লিড ইসিজি (ইলেক্ট্রোকার্ডিওগ্রাম)'],
                'description'              => ['en' => 'Records heart electrical activity with computer analysis.', 'bn' => 'হৃদযন্ত্রের বৈদ্যুতিক কার্যকারিতা পরীক্ষা।'],
                'price'                    => 350.00,
                'discount_type'            => 'none',
                'discount_amount'          => 0.00,
                'final_price'              => 350.00,
                'preparation_instructions' => ['en' => 'Rest for 10 minutes before the test.', 'bn' => 'পরীক্ষার পূর্বে ১০ মিনিট বিশ্রাম নিন।'],
                'estimated_delivery_time'  => '15 Minutes',
                'sort_order'               => 6,
            ],
        ];

        foreach ($tests as $testData) {
            $catSlug = $testData['category_slug'];
            unset($testData['category_slug']);
            $testData['category_id'] = $categoryModels[$catSlug]->id ?? null;
            $testData['is_active'] = true;

            MedicalTest::updateOrCreate(['code' => $testData['code']], $testData);
        }
    }
}
