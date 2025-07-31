<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Tindaklanjut;

class Counseling extends Model
{
    use HasFactory;

    protected $fillable = [
        'scheduled_at',
        'submitted_by',
        'submitted_by_id',
        'counseling_type',
        'title',
        'status',
        'notes',
        'description'
    ];
    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function submittedByUser()
    {
        return $this->belongsTo(User::class, 'submitted_by_id');
    }

        public function TindakLanjuts()
    {
        return $this->hasMany(TindakLanjut::class);
    }

}
