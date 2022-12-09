<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manageUser = new Permission();
        $manageUser->name = 'Manage users';
        $manageUser->slug = 'manage-users';
        $manageUser->save();

        $deletePost = new Permission();
        $deletePost->name = "Delete Post";
        $deletePost->slug = "delete-post";
        $deletePost->save();

        $userPermission = new Permission();
        $userPermission->name = "User Access";
        $userPermission->slug = "user-access";
        $userPermission->save();
    }
}
