<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['department_id', 'faculty_id', 'title', 'code', 'credit_hours'])]
class Course extends Model
{
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function faculty()
    {
       return $this->belongsTo(FacultyProfile::class, 'faculty_id');
       }
       public function students()
{
    return $this->belongsToMany(StudentProfile::class, 'enrollments', 'course_id', 'student_id');
}
}