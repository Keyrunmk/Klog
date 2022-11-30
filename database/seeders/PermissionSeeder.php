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

        $createManager = new Permission();
        $createManager->name = "Create Manager";
        $createManager->slug = "create-manager";
        $createManager->save();

        $createModerator = new Permission();
        $createModerator->name = "Create Moderator";
        $createModerator->slug = "create-moderator";
        $createModerator->save();

        $createEditor = new Permission();
        $createEditor->name = "Create Editor";
        $createEditor->slug = "create-editor";
        $createEditor->save();

        $createTasks = new Permission();
        $createTasks->name = 'Create Tasks';
        $createTasks->slug = 'create-tasks';
        $createTasks->save();

        $deletePost = new Permission();
        $deletePost->name = "Delete Post";
        $deletePost->slug = "delete-post";
    }
}
