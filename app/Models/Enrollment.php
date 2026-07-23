<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['student_id', 'course_id', 'semester', 'status'])]
class Enrollment extends Model
{
    public function student()
    {
        return $this->belongsTo(StudentProfile::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}