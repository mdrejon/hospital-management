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
        $query = Role::withCount('users')
            ->orderByDesc('is_super_admin')
            ->orderBy('name');

        if (! auth()->user()->role?->is_developer) {
            $query->where('is_developer', false);
        }

        $roles = $query->get();

        return Inertia::render('Admin/Roles/Index', [
            'roles' => $roles,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Roles/Create', [
            'modules' => $this->getAvailableModules(),
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
        if ($role->is_developer && ! auth()->user()->role?->is_developer) {
            abort(403, 'Unauthorized action.');
        }

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
        }, $this->getAvailableModules());

        return Inertia::render('Admin/Roles/Edit', [
            'role'    => $role,
            'modules' => $modules,
        ]);
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        if ($role->is_developer && ! auth()->user()->role?->is_developer) {
            abort(403, 'Unauthorized action.');
        }

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
        if ($role->is_developer && ! auth()->user()->role?->is_developer) {
            abort(403, 'Unauthorized action.');
        }

        if ($role->users()->exists()) {
            return back()->with('error', 'Cannot delete a role that has users assigned. Reassign users first.');
        }

        $role->delete();

        return back()->with('success', 'Role deleted.');
    }

    private function syncPermissions(Role $role, array $permissions): void
    {
        // Only allow syncing modules the current user can manage
        $allowedKeys = array_column($this->getAvailableModules(), 'key');

        foreach ($permissions as $perm) {
            if (empty($perm['key'])) continue;
            if (!in_array($perm['key'], $allowedKeys)) continue; // skip forbidden modules

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

    private function getAvailableModules(): array
    {
        $user = auth()->user();
        $isDeveloper = $user->role?->is_developer ?? false;
        $isSuperAdmin = $user->isSuperAdmin();
        $userPerms = $user->sharedPermissions(); // array of module_key => [view, create, ...]

        return array_values(array_filter(ModuleRegistry::all(), function ($module) use ($isDeveloper, $isSuperAdmin, $userPerms) {
            // If the module is strictly for developers, only developers can see it
            if (!empty($module['developer_only']) && !$isDeveloper) {
                return false;
            }

            // Super admins (including developers) can see all modules (except hidden developer ones handled above)
            if ($isSuperAdmin) {
                return true;
            }

            // Regular admins can only assign permissions for modules they are allowed to view themselves
            return isset($userPerms[$module['key']]) && !empty($userPerms[$module['key']]['view']);
        }));
    }
}
