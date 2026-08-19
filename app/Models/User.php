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

    public function agentProfile()
    {
        return $this->hasOne(AgentProfile::class);
    }

    public function isDoctor(): bool
    {
        return $this->role?->slug === 'doctor';
    }

    public function isOperator(): bool
    {
        return $this->role?->slug === 'operator';
    }

    public function isAgent(): bool
    {
        return $this->role?->slug === 'agent' || $this->agentProfile()->exists();
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

    /** Returns permissions keyed array for Inertia shared props */
    public function sharedPermissions(): array
    {
        if (!$this->role) return [];

        if (!$this->role->relationLoaded('permissions')) {
            $this->role->load('permissions');
        }

        if ($this->isSuperAdmin()) {
            $map = [];
            foreach (\App\Support\ModuleRegistry::all() as $module) {
                $isDeveloperOnly = !empty($module['developer_only']);
                
                if ($isDeveloperOnly) {
                    if ($this->role->is_developer) {
                        $map[$module['key']] = ['view' => true, 'create' => true, 'edit' => true, 'delete' => true];
                    } else {
                        // For non-developer super admins, check explicit permissions
                        $perm = $this->role->permissions->firstWhere('module_key', $module['key']);
                        $map[$module['key']] = [
                            'view'   => (bool) ($perm?->can_view),
                            'create' => (bool) ($perm?->can_create),
                            'edit'   => (bool) ($perm?->can_edit),
                            'delete' => (bool) ($perm?->can_delete),
                        ];
                    }
                } else {
                    $map[$module['key']] = ['view' => true, 'create' => true, 'edit' => true, 'delete' => true];
                }
            }
            return $map;
        }

        return $this->role->permissionsArray();
    }
}
