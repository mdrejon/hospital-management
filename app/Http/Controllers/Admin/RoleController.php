<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RolePermission;
use App\Support\ModuleRegistry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class RoleController extends Controller
{
    public function index(): Response
    {
        $roles = Role::withCount('users')
            ->orderByDesc('is_super_admin')
            ->orderBy('name')
            ->get();

        return Inertia::render('Admin/Roles/Index', [
            'roles' => $roles,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Roles/Create', [
            'modules' => ModuleRegistry::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'           => 'required|string',
            'description'    => 'nullable|string',
            'is_super_admin' => 'boolean',
            'is_active'      => 'boolean',
            'permissions'    => 'nullable|array',
            'permissions.*.key'        => 'required|string',
            'permissions.*.can_view'   => 'boolean',
            'permissions.*.can_create' => 'boolean',
            'permissions.*.can_edit'   => 'boolean',
            'permissions.*.can_delete' => 'boolean',
        ]);

        $role = Role::create([
            'name'           => $data['name'],
            'slug'           => Str::slug($data['name']),
            'description'    => $data['description'] ?? null,
            'is_super_admin' => $data['is_super_admin'] ?? false,
            'is_active'      => $data['is_active'] ?? true,
        ]);

        $this->syncPermissions($role, $data['permissions'] ?? []);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }

    public function edit(Role $role): Response
    {
        $role->load('permissions');

        $existingPerms = $role->permissions->keyBy('module_key');

        $modules = array_map(function ($module) use ($existingPerms) {
            $existing = $existingPerms->get($module['key']);
            return array_merge($module, [
                'can_view'   => (bool) ($existing->can_view   ?? false),
                'can_create' => (bool) ($existing->can_create ?? false),
                'can_edit'   => (bool) ($existing->can_edit   ?? false),
                'can_delete' => (bool) ($existing->can_delete ?? false),
            ]);
        }, ModuleRegistry::all());

        return Inertia::render('Admin/Roles/Edit', [
            'role'    => $role,
            'modules' => $modules,
        ]);
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $data = $request->validate([
            'name'           => 'required|string',
            'description'    => 'nullable|string',
            'is_super_admin' => 'boolean',
            'is_active'      => 'boolean',
            'permissions'    => 'nullable|array',
            'permissions.*.key'        => 'required|string',
            'permissions.*.can_view'   => 'boolean',
            'permissions.*.can_create' => 'boolean',
            'permissions.*.can_edit'   => 'boolean',
            'permissions.*.can_delete' => 'boolean',
        ]);

        $role->update([
            'name'           => $data['name'],
            'slug'           => Str::slug($data['name']),
            'description'    => $data['description'] ?? null,
            'is_super_admin' => $data['is_super_admin'] ?? false,
            'is_active'      => $data['is_active'] ?? true,
        ]);

        $this->syncPermissions($role, $data['permissions'] ?? []);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        if ($role->users()->exists()) {
            return back()->with('error', 'Cannot delete a role that has users assigned. Reassign users first.');
        }

        $role->delete();

        return back()->with('success', 'Role deleted.');
    }

    private function syncPermissions(Role $role, array $permissions): void
    {
        foreach ($permissions as $perm) {
            if (empty($perm['key'])) continue;

            RolePermission::updateOrCreate(
                ['role_id' => $role->id, 'module_key' => $perm['key']],
                [
                    'can_view'   => (bool) ($perm['can_view']   ?? false),
                    'can_create' => (bool) ($perm['can_create'] ?? false),
                    'can_edit'   => (bool) ($perm['can_edit']   ?? false),
                    'can_delete' => (bool) ($perm['can_delete'] ?? false),
                ]
            );
        }
    }
}
