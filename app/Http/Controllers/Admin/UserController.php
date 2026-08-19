<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(): Response
    {
        $query = User::with('role')
            ->orderByDesc('id');

        if (! auth()->user()->role?->is_developer) {
            $query->whereHas('role', function ($q) {
                $q->where('is_developer', false);
            })->orWhereNull('role_id');
        }

        $users = $query->get();

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
        ]);
    }

    public function create(): Response
    {
        $rolesQuery = Role::where('is_active', true);
        if (! auth()->user()->role?->is_developer) {
            $rolesQuery->where('is_developer', false);
        }

        return Inertia::render('Admin/Users/Create', [
            'roles'   => $rolesQuery->get(['id', 'name', 'is_super_admin']),
            'doctors' => $this->doctorOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'      => 'required|string',
            'email'     => 'required|email|unique:users,email',
            'password'  => ['required', 'confirmed', Password::min(8)],
            'role_id'   => 'nullable|exists:roles,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'is_active' => 'boolean',
        ]);

        User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'role_id'   => $data['role_id'] ?? null,
            'doctor_id' => $data['doctor_id'] ?? null,
            'is_active' => $data['is_active'] ?? true,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user): Response
    {
        if ($user->role?->is_developer && ! auth()->user()->role?->is_developer) {
            abort(403, 'Unauthorized action.');
        }

        $rolesQuery = Role::where('is_active', true);
        if (! auth()->user()->role?->is_developer) {
            $rolesQuery->where('is_developer', false);
        }

        return Inertia::render('Admin/Users/Edit', [
            'user'    => $user->load('role'),
            'roles'   => $rolesQuery->get(['id', 'name', 'is_super_admin']),
            'doctors' => $this->doctorOptions(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        if ($user->role?->is_developer && ! auth()->user()->role?->is_developer) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'name'      => 'required|string',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'password'  => ['nullable', 'confirmed', Password::min(8)],
            'role_id'   => 'nullable|exists:roles,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'is_active' => 'boolean',
        ]);

        $update = [
            'name'      => $data['name'],
            'email'     => $data['email'],
            'role_id'   => $data['role_id'] ?? null,
            'doctor_id' => $data['doctor_id'] ?? null,
            'is_active' => $data['is_active'] ?? true,
        ];

        if (!empty($data['password'])) {
            $update['password'] = Hash::make($data['password']);
        }

        $user->update($update);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->role?->is_developer && ! auth()->user()->role?->is_developer) {
            abort(403, 'Unauthorized action.');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return back()->with('success', 'User deleted.');
    }

    public function toggleStatus(User $user): RedirectResponse
    {
        if ($user->role?->is_developer && ! auth()->user()->role?->is_developer) {
            abort(403, 'Unauthorized action.');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        $user->update(['is_active' => !$user->is_active]);

        return back()->with('success', 'User status updated.');
    }

    /**
     * Doctor options for the "Link to Doctor" picker. `name` is translatable, so
     * ordering by the raw JSON column would sort meaninglessly — resolve each name
     * via the magic getter first, then sort by that.
     */
    private function doctorOptions()
    {
        return Doctor::get(['id', 'name'])
            ->map(fn (Doctor $d) => ['id' => $d->id, 'name' => $d->name])
            ->sortBy('name')
            ->values();
    }
}
