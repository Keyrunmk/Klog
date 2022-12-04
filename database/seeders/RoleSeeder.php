<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manager = new Role();
        $manager->name = "Page Manager";
        $manager->slug = "page-manager";
        $manager->save();

        $moderator = new Role();
        $moderator->name = "Page Moderator";
        $moderator->slug = "page-moderator";
        $moderator->save();

        $editor = new Role();
        $editor->name = "Page Editor";
        $editor->slug = "page-editor";
        $editor->save();
    }
}
