<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nisn',
        'nama_lengkap',
        'kelas',
        'email_siswa',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_siswa',
        'telepon_siswa',
        'hubungan_wali',
        'nama_wali',
        'telepon_wali',
        'email_wali',
        'alamat_wali',
    ];

    // Relasi ke Prestasi
    public function achievements()
    {
        return $this->hasMany(StudentAchievement::class);
    }

    public function misconducts()  // Mengganti violations menjadi misconducts
    {
        return $this->hasMany(StudentMisconduct::class);
    }
}
