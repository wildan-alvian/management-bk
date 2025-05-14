<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'family_relation'
    ];

    /**
     * Get the user record for the parent.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the students associated with this parent.
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'student_parent_id');
    }
}
