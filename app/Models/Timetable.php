<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['course_id', 'faculty_id', 'day', 'start_time', 'end_time', 'room'])]
class Timetable extends Model
{
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function faculty()
    {
        return $this->belongsTo(FacultyProfile::class, 'faculty_id');
    }
}