<?php

namespace Database\Seeders;

use App\Models\ManagementMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ManagementMemberSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->members() as $i => $member) {
            $slug = Str::slug($member['name']);

            ManagementMember::updateOrCreate(
                ['slug' => $slug],
                array_merge($member, ['slug' => $slug, 'sort_order' => $i + 1, 'is_active' => true])
            );
        }
    }

    private function members(): array
    {
        return [
            [
                'name' => 'A.K.M. Shamsul Alam (Azad)',
                'role' => ['en' => 'Chairman', 'bn' => 'চেয়ারম্যান'],
            ],
        ];
    }
}
