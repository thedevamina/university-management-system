<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        $student = auth()->user()->studentProfile;

        $enrollments = $student->enrollments()->with('course.department')->latest()->get();

        // Courses not yet enrolled, from student's own department
        $availableCourses = Course::where('department_id', $student->department_id)
            ->whereNotIn('id', $enrollments->pluck('course_id'))
            ->get();

        return view('student.enrollments.index', compact('enrollments', 'availableCourses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'semester' => 'required|string|max:50',
        ]);

        $student = auth()->user()->studentProfile;

        Enrollment::create([
            'student_id' => $student->id,
            'course_id' => $request->course_id,
            'semester' => $request->semester,
        ]);

        return back()->with('success', 'Enrolled successfully.');
    }

    public function destroy(Enrollment $enrollment)
    {
        // Ensure a student can only drop their own enrollment
        abort_if($enrollment->student_id !== auth()->user()->studentProfile->id, 403);

        $enrollment->delete();

        return back()->with('success', 'Dropped from course.');
    }
}