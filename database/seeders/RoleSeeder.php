<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = Role::firstOrCreate(
            ['slug' => 'super-admin'],
            [
                'name'           => 'Super Admin',
                'description'    => 'Full access to all modules.',
                'is_super_admin' => true,
                'is_active'      => true,
            ]
        );

        // Assign all existing users without a role to Super Admin
        \App\Models\User::whereNull('role_id')->update(['role_id' => $superAdmin->id]);

        $doctor = Role::firstOrCreate(
            ['slug' => 'doctor'],
            [
                'name'           => 'Doctor',
                'description'    => 'Access to their own appointment schedule and patient queue.',
                'is_super_admin' => false,
                'is_active'      => true,
            ]
        );
        $this->setPermissions($doctor, [
            'dashboard'        => ['view' => true],
            'doctor-dashboard' => ['view' => true, 'edit' => true],
        ]);

        $operator = Role::firstOrCreate(
            ['slug' => 'operator'],
            [
                'name'           => 'Operator',
                'description'    => 'Books appointments on behalf of patients and manages the daily queue.',
                'is_super_admin' => false,
                'is_active'      => true,
            ]
        );
        $this->setPermissions($operator, [
            'dashboard'          => ['view' => true],
            'operator-dashboard' => ['view' => true, 'create' => true, 'edit' => true],
            'appointments'       => ['view' => true, 'create' => true, 'edit' => true],
            'patients'           => ['view' => true],
        ]);

        $this->command->info('Super Admin, Doctor and Operator roles are ready.');
    }

    private function setPermissions(Role $role, array $modules): void
    {
        foreach ($modules as $moduleKey => $actions) {
            RolePermission::updateOrCreate(
                ['role_id' => $role->id, 'module_key' => $moduleKey],
                [
                    'can_view'   => $actions['view'] ?? false,
                    'can_create' => $actions['create'] ?? false,
                    'can_edit'   => $actions['edit'] ?? false,
                    'can_delete' => $actions['delete'] ?? false,
                ]
            );
        }
    }
}
