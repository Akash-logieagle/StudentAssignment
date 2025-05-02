<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'class',
        'performance',
        'attendance',
        'contact',
        'status',
        'student_id',
        'date_of_birth',
        'gender',
        'enrollment_date',
        'address',
    ];

    public function parent()
    {
        return $this->hasOne(ParentModel::class);
    }

    public function subjects()
{
    return $this->hasMany(Subject::class);
}
}
