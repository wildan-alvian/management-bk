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
        Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $guidanceCounselor = Role::create(['name' => 'Guidance Counselor']);
        $student = Role::create(['name' => 'Student']);
        $studentParents = Role::create(['name' => 'Student Parents']);
    
        $admin->givePermissionTo([
            'view-user',
            'create-user',
            'edit-user',
            'delete-user',
            'view-student',
            'create-student',
            'edit-student',
            'delete-student',
            'view-student-parent',
            'create-student-parent',
            'edit-student-parent',
            'delete-student-parent',
            'view-counseling',
            'create-counseling',
            'edit-counseling',
            'delete-counseling',
        ]);

        $guidanceCounselor->givePermissionTo([
            'view-user',
            'view-student',
            'create-student',
            'edit-student',
            'delete-student',
            'view-student-parent',
            'create-student-parent',
            'edit-student-parent',
            'delete-student-parent',
            'view-counseling',
            'create-counseling',
            'edit-counseling',
            'delete-counseling',
        ]);

        $student->givePermissionTo([
            'view-user',
            'view-student',
            'view-student-parent',
            'view-counseling',
            'create-counseling',
            'edit-counseling',
            'delete-counseling',
        ]);

        $studentParents->givePermissionTo([
            'view-user',
            'view-student',
            'view-student-parent',
            'view-counseling',
            'create-counseling',
            'edit-counseling',
            'delete-counseling',
        ]);
    }
}
