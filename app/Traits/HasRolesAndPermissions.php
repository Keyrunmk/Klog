<?php

namespace App\Traits;

use App\Models\Permission;

trait HasRolesAndPermissions
{
    public function roles()
    {
        return $this->belongsToMany(Role::class, "admins_roles");
    }

    public function hasRole(...$roles): bool
    {
        foreach ($roles as $role) {
            if ($this->roles->contains("slug", $role)) {
                return true;
            }
        }
        return false;
    }

    public function hasPermissionThroughRole($permission): bool
    {
        foreach ($permission->roles as $role){
            if ($this->roles->contains($role)) {
                return true;
            }
        }
        return false;
    }

    public function getAllPermissions(array $permissions)
    {
        return Permission::whereIn("slug", $permissions)->get();
    }

    public function givePermissionTo(...$permissions): object
    {
        $permissions = $this->getAllPermissions($permissions);

        if ($permissions === null) {
            return $this;
        }

        $this->permissions()->saveMany($permissions);
        return $this;
    }

    public function deletePermissions(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);

        $this->permissions()->detach($permissions);

        return $this;
    }
}