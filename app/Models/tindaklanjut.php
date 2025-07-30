<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tindaklanjut extends Model
{
    use HasFactory;

    protected $table = 'tindaklanjuts'; // Sesuai migration

    protected $fillable = [
        'counseling_id',
        'description',
        'tanggal',
    ];

    public function counseling()
    {
        return $this->belongsTo(Counseling::class);
    }
}
