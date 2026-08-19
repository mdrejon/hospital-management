<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DeveloperRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create the Developer role
        $developerRole = Role::updateOrCreate(
            ['slug' => 'developer'],
            [
                'name' => 'Developer',
                'description' => 'System Developer (Hidden from normal admins)',
                'is_super_admin' => true,
                'is_developer' => true,
                'is_active' => true,
            ]
        );

        // 2. Create the Developer user
        User::updateOrCreate(
            ['email' => 'developer@developer.com'],
            [
                'name' => 'System Developer',
                'password' => Hash::make('Developer'),
                'role_id' => $developerRole->id,
                'is_active' => true,
            ]
        );
    }
}
