<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'Super Admin', 
            'email' => 'mwildanalvian@gmail.com',
            'password' => Hash::make('SuperMBK2025'),
            'role' => 'Super Admin'
        ]);
        $superAdmin->assignRole('Super Admin');

        $admin = User::create([
            'name' => 'Admin1', 
            'email' => 'admin@gmail.com',
            'password' => Hash::make('AdmMBK2025'),
            'role' => 'Admin'
        ]);
        $admin->assignRole('Admin');

        $guidanceCounselor = User::create([
            'name' => 'puput', 
            'email' => 'puput@example.com',
            'password' => Hash::make('BKMBK2025'),
            'role' => 'Guidance Counselor'
        ]);
        $guidanceCounselor->assignRole('Guidance Counselor');

        $student = User::create([
            'name' => 'zaldy', 
            'email' => 'zadly@example.com',
            'password' => Hash::make('studentMBK2025'),
            'role' => 'Student'
        ]);
        $student->assignRole('Student');

        $studentParent = User::create([
            'name' => 'hariyanto', 
            'email' => 'har@example.com',
            'password' => Hash::make('studentparMBK2025'),
            'role' => 'Student Parents'
        ]);
        $studentParent->assignRole('Student Parents');
    }
}
