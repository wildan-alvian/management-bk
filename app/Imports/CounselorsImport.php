<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CounselorsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                // Ambil no telepon, jika kosong maka defaultkan ke '12345678'
                $phone = $row['no_telepon'] ?? '12345678';
                $password = $phone;

                $user = User::firstOrCreate(
                    ['id_number' => $row['nip']],
                    [
                        'name' => $row['nama'],
                        'email' => $row['email'],
                        'password' => Hash::make($password),
                        'phone' => $phone,
                        'address' => $row['alamat'] ?? '',
                        'role' => 'Guidance Counselor',
                    ]
                );

                // Pastikan hanya assign role jika belum memiliki role tersebut
                if (!$user->hasRole('Guidance Counselor')) {
                    $user->assignRole('Guidance Counselor');
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
