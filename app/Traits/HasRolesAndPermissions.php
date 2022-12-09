<?php

namespace App\Traits;

use App\Models\Role;

trait HasRolesAndPermissions
{
    public Role $roles;

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole($role): bool
    {
        if ($this->role) {
            return $this->role->slug === $role;
        }
        return false;
    }

    public function hasPermissionThroughRole($permission): bool
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }
        return false;
    }
}
