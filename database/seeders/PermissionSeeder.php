<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'enter_dashboard',
            'create-role',
            'edit-role',
            'delete-role',
            'create-user',
            'show-user',
            'edit-user',
            'delete-user',
            'block-author',
            'show-articles',
            'create-article',
            'edit-any-article',
            'edit-own-article',
            'delete-any-article',
            'delete-own-article',
            'add-article-to-favorite',
            'create-request',
            'accept-request',
            'edit-data-request',
            'delete-request',
            'create-comment',
            'edit-comment',
            'delete-comment',
            'create-category',
            'edit-category',
            'delete-category',
        ];

        foreach ($permissions as $permission){
            Permission::create(['name' => $permission]);
        }
    }
}
