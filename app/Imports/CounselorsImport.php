<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CounselorsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        
        if (User::where('email', $row['email'])->exists()) {
            return null;
        }

        
        $password = substr(str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&'), 0, 10);

        $user = new User([
            'name'      => $row['nama'],
            'email'     => $row['email'],
            'id_number' => $row['nip'],
            'phone'     => $row['no_telepon'],
            'address'   => $row['alamat'],
            'password'  => Hash::make($password),
            'role'      => 'Guidance Counselor',
        ]);

        $user->save();
        $user->assignRole('Guidance Counselor');

      
        Mail::to($user->email)->send(new TestMail(
            'Pembuatan akun CounselLink baru',
            'email.user.create',
            [
                'name' => $user->name,
                'password' => $password,
                'url' => env('APP_URL')
            ]
        ));

        return $user;
    }
}
