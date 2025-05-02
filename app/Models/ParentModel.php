<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    protected $table = 'parents';

    protected $fillable = [
        'student_id',
        'name',
        'relationship',
        'email',
        'phone_number',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
