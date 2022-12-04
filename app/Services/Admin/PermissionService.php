<?php

namespace App\Services\Admin;

use App\Models\Permission;

class PermissionService
{
    public $permissions = [];

    public function __construct()
    {
        $this->permissions = Permission::all();
    }
}