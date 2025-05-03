<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruBk extends Model
{
    use HasFactory;

    
    protected $table = 'gurubks';

    
    protected $fillable = [
        'nip',
        'nama',
        'email',
        'no_telepon',
        'alamat',
    ];
}

