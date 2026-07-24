<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Enrollment;
use App\Repositories\EnrollmentRepository;

class EnrollmentService
{
    public function __construct(protected EnrollmentRepository $enrollmentRepository)
    {
    }

    public function myEnrollments(int $studentId)
    {
        return $this->enrollmentRepository->getForStudent($studentId);
    }

    public function availableCourses(int $studentId, int $departmentId)
    {
        $enrolledIds = $this->enrollmentRepository->enrolledCourseIds($studentId);

        return Course::where('department_id', $departmentId)
            ->whereNotIn('id', $enrolledIds)
            ->get();
    }

    public function enroll(int $studentId, array $data): Enrollment
    {
        return $this->enrollmentRepository->create([
            'student_id' => $studentId,
            'course_id' => $data['course_id'],
            'semester' => $data['semester'],
        ]);
    }

    public function drop(Enrollment $enrollment, int $currentStudentId): void
    {
        abort_if($enrollment->student_id !== $currentStudentId, 403);
        $this->enrollmentRepository->delete($enrollment);
    }
}