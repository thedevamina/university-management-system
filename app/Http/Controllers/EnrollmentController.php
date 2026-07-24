<?php

namespace App\Http\Controllers;

use App\Services\EnrollmentService;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function __construct(protected EnrollmentService $enrollmentService)
    {
    }

    public function index()
    {
        $student = auth()->user()->studentProfile;

        $enrollments = $this->enrollmentService->myEnrollments($student->id);
        $availableCourses = $this->enrollmentService->availableCourses($student->id, $student->department_id);

        return view('student.enrollments.index', compact('enrollments', 'availableCourses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'semester' => 'required|string|max:50',
        ]);

        $student = auth()->user()->studentProfile;
        $this->enrollmentService->enroll($student->id, $request->only('course_id', 'semester'));

        return back()->with('success', 'Enrolled successfully.');
    }

    public function destroy(\App\Models\Enrollment $enrollment)
    {
        $student = auth()->user()->studentProfile;
        $this->enrollmentService->drop($enrollment, $student->id);

        return back()->with('success', 'Dropped from course.');
    }
}