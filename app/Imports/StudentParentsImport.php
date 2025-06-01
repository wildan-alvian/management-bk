<?php

namespace App\Imports;

use App\Models\User;
use App\Models\StudentParent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentParentsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
              
                if (empty($row['nik']) || empty($row['nama']) || empty($row['email']) || empty($row['hubungan'])) {
                    continue;
                }
               
                $password = substr(str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&'), 0, 10);

                $user = User::firstOrCreate(
                    ['id_number' => $row['nik']],
                    [
                        'name' => $row['nama'],
                        'email' => $row['email'],
                        'password' => Hash::make($password),
                        'phone' => $row['no_telepon'] ?? '',
                        'address' => $row['alamat'] ?? '',
                        'role' => 'Student Parents',
                    ]
                );
                $user->assignRole('Student Parents');

                $user->studentParent()->firstOrCreate(['user_id' => $user->id],[
                    'family_relation' => $row['hubungan'],
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}

