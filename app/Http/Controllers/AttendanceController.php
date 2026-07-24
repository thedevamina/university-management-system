<?php

namespace App\Http\Controllers;

use App\Services\AttendanceService;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function __construct(protected AttendanceService $attendanceService)
    {
    }

    public function create(Request $request)
    {
        $faculty = auth()->user()->facultyProfile;
        $courses = $this->attendanceService->coursesForFaculty($faculty->id);

        $selectedCourseId = $request->query('course_id');
        $date = $request->query('date', now()->format('Y-m-d'));

        [$students, $existingAttendance] = $this->attendanceService->loadRoster(
            $selectedCourseId ? (int) $selectedCourseId : null,
            $date
        );

        return view('faculty.attendance.create', compact('courses', 'selectedCourseId', 'date', 'students', 'existingAttendance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,absent,leave',
        ]);

        $this->attendanceService->saveAttendance((int) $request->course_id, $request->date, $request->attendance);

        return redirect()
            ->route('faculty.attendance.create', ['course_id' => $request->course_id, 'date' => $request->date])
            ->with('success', 'Attendance saved successfully.');
    }
}