<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'department_id', 'roll_no', 'batch'])]
class StudentProfile extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function enrollments()
{
    return $this->hasMany(Enrollment::class, 'student_id');
}

public function courses()
{
    return $this->belongsToMany(Course::class, 'enrollments', 'student_id', 'course_id');
}
}