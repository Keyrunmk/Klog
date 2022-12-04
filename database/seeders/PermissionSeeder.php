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
        $editor = new Permission();
        $editor->name = "Create Editor";
        $editor->slug = "create-editor";
        $editor->save();

        $manageUser = new Permission();
        $manageUser->name = 'Manage users';
        $manageUser->slug = 'manage-users';
        $manageUser->save();

        $createTasks = new Permission();
        $createTasks->name = 'Create Tasks';
        $createTasks->slug = 'create-tasks';
        $createTasks->save();

        $deletePost = new Permission();
        $deletePost->name = "Delete Post";
        $deletePost->slug = "delete-post";
        $deletePost->save();

        $issueWawrning = new Permission();
        $issueWawrning->name = "Issue Warning";
        $issueWawrning->slug = "issue-warning";
        $issueWawrning->save();

        $issueBan = new Permission();
        $issueBan->name = "Issue Ban";
        $issueBan->slug = "issue-ban";
        $issueBan->save();

        $issueSuspension = new Permission();
        $issueSuspension->name = "Issue Suspension";
        $issueSuspension->slug = "issue-suspension";
        $issueSuspension->save();
    }
}
