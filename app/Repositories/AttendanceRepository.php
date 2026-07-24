<?php

namespace App\Repositories;

use App\Models\Attendance;
use App\Models\Course;
use Illuminate\Support\Collection;

class AttendanceRepository
{
    public function coursesForFaculty(int $facultyId)
    {
        return Course::where('faculty_id', $facultyId)->get();
    }

    public function enrolledStudents(int $courseId)
    {
        return Course::findOrFail($courseId)->students()->with('user')->get();
    }

    public function forCourseAndDate(int $courseId, string $date): Collection
    {
        return Attendance::where('course_id', $courseId)
            ->where('date', $date)
            ->get()
            ->keyBy('student_id');
    }

    public function markOne(int $studentId, int $courseId, string $date, string $status): Attendance
    {
        return Attendance::updateOrCreate(
            ['student_id' => $studentId, 'course_id' => $courseId, 'date' => $date],
            ['status' => $status]
        );
    }
}