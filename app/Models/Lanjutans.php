<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lanjutan extends Model
{
    use HasFactory;

    protected $fillable = ['misconduct_id', 'note', 'file'];

    public function misconduct()
    {
        return $this->belongsTo(StudentMisconduct::class);
    }
}
