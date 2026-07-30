<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'role_id',
        'doctor_id',
        'name',
        'email',
        'password',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_active'         => 'boolean',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function isDoctor(): bool
    {
        return $this->role?->slug === 'doctor';
    }

    public function isOperator(): bool
    {
        return $this->role?->slug === 'operator';
    }

    /** True only if the user has an explicit super-admin role. A missing role grants nothing. */
    public function isSuperAdmin(): bool
    {
        return (bool) $this->role?->is_super_admin;
    }

    public function hasPermission(string $module, string $action = 'view'): bool
    {
        if ($this->isSuperAdmin()) return true;

        if (!$this->role) return false;

        // Eager-load permissions if not already loaded
        if (!$this->role->relationLoaded('permissions')) {
            $this->role->load('permissions');
        }

        return $this->role->hasPermission($module, $action);
    }

    /** Returns permissions keyed array for Inertia shared props; null = super admin */
    public function sharedPermissions(): ?array
    {
        if ($this->isSuperAdmin()) return null;

        if (!$this->role) return [];

        if (!$this->role->relationLoaded('permissions')) {
            $this->role->load('permissions');
        }

        return $this->role->permissionsArray();
    }
}
