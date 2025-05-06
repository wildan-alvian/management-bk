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
            'view-role',
            'create-role',
            'edit-role',
            'delete-role',
            'view-user',
            'create-user',
            'edit-user',
            'delete-user',
            'view-student',
            'create-student',
            'edit-student',
            'delete-student',
            'view-counseling',
            'create-counseling',
            'edit-counseling',
            'delete-counseling',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
