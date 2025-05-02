<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
      'student_id',
    'name',
    'current_term_mark',
    'previous_term_mark',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
