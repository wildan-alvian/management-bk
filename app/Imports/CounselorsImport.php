<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CounselorsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        DB::beginTransaction();try {
            foreach ($rows as $row) {
              
                $password = substr(str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&'), 0, 10);

                $user = User::firstOrCreate(
                    ['id_number' => $row['nip']],
                    [
                        'name' => $row['nama'],
                        'email' => $row['email'],
                        'password' => Hash::make($password),
                        'phone' => $row['no_telepon'] ?? '',
                        'address' => $row['alamat'] ?? '',
                        'role' => 'Guidance Counselor',
                    ]
                );
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
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
