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
        // Lewati baris header (biasanya kolom pertama berisi teks "NIP")
        if ($row[0] === 'NIP' || empty($row[2])) {
            return null;
        }

        // Cegah duplikasi email
        if (User::where('email', $row[2])->exists()) {
            return null;
        }

        // Gunakan nomor telepon sebagai password default
        $defaultPassword = !empty($row[3]) ? $row[3] : '123456'; // fallback jika no. telepon kosong

        $user = new User([
            'id_number' => $row[0],
            'name' => $row[1],
            'email' => $row[2],
            'phone' => $row[3],
            'address' => $row[4],
            'password' => Hash::make($defaultPassword),
            'role' => 'Admin',
        ]);

        $user->save();

        // Pastikan role "Admin" sudah ada sebelum assign
        if (Role::where('name', 'Admin')->exists()) {
            $user->assignRole('Admin');
        }

        return $user;
    }
}
