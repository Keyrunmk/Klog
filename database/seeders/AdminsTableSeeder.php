<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Admin();
        $admin->first_name = "Kiran";
        $admin->last_name = "Moktan";
        $admin->username = "kiranmk";
        $admin->email = "admin@admin.com";
        $admin->password = Hash::make("password");
        $admin->save();

        $permission = new Permission();
        $permission->name = "Page Admin";
        $permission->slug = "page-admin";
        $permission->save();

        $role = new Role();
        $role->name = "Page Admin";
        $role->slug = "page-admin";
        $role->save();

        $role->permissions()->save($permission);

        $admin->roles()->save($role);
    }
}
