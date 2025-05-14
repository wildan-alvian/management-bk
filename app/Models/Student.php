<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_parent_id',
        'nisn',
        'class',
        'gender',
        'birthdate',
        'birthplace'
    ];

    /**
     * Get the user that owns the student profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the student's parent relationship.
     */
    public function studentParent()
    {
        return $this->belongsTo(StudentParent::class, 'student_parent_id');
    }

    /**
     * Get the student's achievements.
     */
    public function achievements()
    {
        return $this->hasMany(StudentAchievement::class);
    }

    /**
     * Get the student's misconducts.
     */
    public function misconducts()
    {
        return $this->hasMany(StudentMisconduct::class);
    }

    /**
     * Get the student's counseling sessions.
     */
    public function counselings()
    {
        return $this->hasMany(Counseling::class);
    }
}
