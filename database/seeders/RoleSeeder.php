<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'Admin']);
        $admin->givePermissionTo([
            'enter_dashboard',
            'create-role',
            'edit-role',
            'delete-role',
            'show-user',
            'create-user',
            'edit-user',
            'delete-user',
            'show-articles',
            'create-article',
            'edit-any-article',
            'delete-any-article',
            'accept-request',
            'delete-request',
            'create-category',
            'edit-category',
            'delete-category',
        ]);

        $member = Role::create(['name' => 'Member']);
        $member->givePermissionTo([
            'show-user',
            'show-articles',
            'add-article-to-favorite',
            'create-request',
            'edit-data-request',
            'delete-request',
            'create-comment',
            'edit-comment',
            'delete-comment',
            'block-author',
        ]);

        $author = Role::create(['name' => 'Author']);
        $author->givePermissionTo([
            'show-user',
            'show-articles',
            'add-article-to-favorite',
            'create-article',
            'edit-own-article',
            'delete-own-article',
            'create-comment',
            'edit-comment',
            'delete-comment',
            'block-author',
        ]);
    }
}
