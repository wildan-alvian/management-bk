<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentMisconduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'name',
        'category',
        'date',
        'detail',
    ];

    public function edit($id)
{
    $misconduct = StudentMisconduct::findOrFail($id);
    return view('misconduct.edit', compact('misconduct'));
}
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}

