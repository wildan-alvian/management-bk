<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'name',
        'category',
        'date',
        'detail',
        'file',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}

