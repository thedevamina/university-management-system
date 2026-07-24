<?php

namespace App\Repositories;

use App\Models\Enrollment;

class EnrollmentRepository
{
    public function getForStudent(int $studentId)
    {
        return Enrollment::where('student_id', $studentId)
            ->with('course.department')
            ->latest()
            ->get();
    }

    public function create(array $data): Enrollment
    {
        return Enrollment::create($data);
    }

    public function delete(Enrollment $enrollment): void
    {
        $enrollment->delete();
    }

    public function enrolledCourseIds(int $studentId): array
    {
        return Enrollment::where('student_id', $studentId)->pluck('course_id')->toArray();
    }
}