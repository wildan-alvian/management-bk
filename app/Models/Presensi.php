<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';

    protected $fillable = [
        'user_id',
        'tanggal_waktu',
        'status',
        'lampiran',
        'deskripsi',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}