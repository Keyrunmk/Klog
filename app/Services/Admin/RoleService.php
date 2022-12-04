<?php

namespace App\Services\Admin;

use App\Models\Role;

class RoleService
{
    public $roles = [];

    public function __construct()
    {
        $this->roles = Role::all();
    }
}