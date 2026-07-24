<?php

namespace App\Services;

use App\Repositories\AttendanceRepository;

class AttendanceService
{
    public function __construct(protected AttendanceRepository $attendanceRepository)
    {
    }

    public function coursesForFaculty(int $facultyId)
    {
        return $this->attendanceRepository->coursesForFaculty($facultyId);
    }

    public function loadRoster(?int $courseId, string $date)
    {
        if (!$courseId) {
            return [collect(), collect()];
        }

        $students = $this->attendanceRepository->enrolledStudents($courseId);
        $existing = $this->attendanceRepository->forCourseAndDate($courseId, $date);

        return [$students, $existing];
    }

    public function saveAttendance(int $courseId, string $date, array $attendance): void
    {
        foreach ($attendance as $studentId => $status) {
            $this->attendanceRepository->markOne((int) $studentId, $courseId, $date, $status);
        }
    }
}