<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Spatie\Permission\Models\Role;

class AdminsImport implements ToModel
{
    public function model(array $row)
    {
        if ($row[0] === 'NIP') {
            return null;
        }

        if (User::where('email', $row[2])->exists()) {
            return null;
        }

        $user = new User([
            'id_number' => $row[0],
            'name' => $row[1],
            'email' => $row[2],
            'phone' => $row[3],
            'address' => $row[4],
            'password' => Hash::make('password123'), 
            'role' => 'Admin',
        ]);

        $user->save();
        $user->assignRole('Admin');

        return $user;
    }
}
