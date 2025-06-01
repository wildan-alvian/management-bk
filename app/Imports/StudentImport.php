<?php

namespace App\Imports;

use App\Models\User;
use App\Models\StudentParent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                $password = substr(str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&'), 0, 10);

                $wali = User::firstOrCreate(
                    ['id_number' => $row['nik_wali']],
                    [
                        'name' => $row['nama_wali'],
                        'email' => $row['email_wali'],
                        'password' => Hash::make($row['no_telepon_wali']),
                        'phone' => $row['no_telepon_wali'] ?? '',
                        'address' => $row['alamat_wali'] ?? '',
                        'role' => 'Student Parents',
                    ]
                );
                $wali->assignRole('Student Parents');

                $wali->studentParent()->firstOrCreate(['user_id' => $wali->id],[
                    'family_relation' => $row['hubungan'],
                ]);

                $student = User::firstOrCreate(
                    ['id_number' => $row['nisn']],
                    [
                        'name' => $row['nama'],
                        'email' => $row['email'],
                        'password' => Hash::make($row['no_telepon']),
                        'phone' => $row['no_telepon'] ?? '',
                        'address' => $row['alamat'] ?? '',
                        'role' => 'Student',
                    ]
                );
                $student->assignRole('Student');

                $student->student()->firstOrCreate(['user_id' => $student->id],[
                    'student_parent_id' => $wali->studentParent->id,
                    'nisn' => $row['nisn'],
                    'class' => $row['kelas'],
                    'gender' => $row['jenis_kelamin'],
                    'birthdate' => $row['tanggal_lahir'],
                    'birthplace' => $row['tempat_lahir'],
                ]);

            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}

