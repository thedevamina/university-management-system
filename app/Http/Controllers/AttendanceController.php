<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // Faculty selects a course + date to mark attendance
    public function create(Request $request)
    {
        $faculty = auth()->user()->facultyProfile;

        $courses = Course::where('faculty_id', $faculty->id)->get();

        $selectedCourseId = $request->query('course_id');
        $date = $request->query('date', now()->format('Y-m-d'));

        $students = collect();
        $existingAttendance = collect();

        if ($selectedCourseId) {
            $course = Course::findOrFail($selectedCourseId);

            // Only students enrolled in this course
            $students = $course->students()->with('user')->get();

            // Existing attendance for this course+date, keyed by student_id
            $existingAttendance = Attendance::where('course_id', $selectedCourseId)
                ->where('date', $date)
                ->get()
                ->keyBy('student_id');
        }

        return view('faculty.attendance.create', compact('courses', 'selectedCourseId', 'date', 'students', 'existingAttendance'));
    }

    // Save attendance for all students at once
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,absent,leave',
        ]);

        foreach ($request->attendance as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'course_id' => $request->course_id,
                    'date' => $request->date,
                ],
                ['status' => $status]
            );
        }

        return redirect()
            ->route('faculty.attendance.create', ['course_id' => $request->course_id, 'date' => $request->date])
            ->with('success', 'Attendance saved successfully.');
    }
}