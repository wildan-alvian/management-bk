<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Counseling extends Model
{
    use HasFactory;

    protected $fillable = [
        'scheduled_at',
        'submitted_by',
        'counseling_type',
        'title',
        'status',
    ];
    protected $casts = [
        'scheduled_at' => 'datetime',
    ];
}
