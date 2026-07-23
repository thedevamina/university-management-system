<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\FacultyProfile;
use App\Services\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct(protected CourseService $courseService)
    {
    }

    public function index()
    {
        $courses = $this->courseService->listCourses();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $departments = Department::all();
        $facultyList = FacultyProfile::with('user')->get();
        return view('admin.courses.create', compact('departments', 'facultyList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'faculty_id' => 'nullable|exists:faculty_profiles,id',
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:courses,code',
            'credit_hours' => 'required|integer|min:1|max:6',
        ]);

        $this->courseService->createCourse($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    public function edit(\App\Models\Course $course)
    {
        $departments = Department::all();
        $facultyList = FacultyProfile::with('user')->get();
        return view('admin.courses.edit', compact('course', 'departments', 'facultyList'));
    }

    public function update(Request $request, \App\Models\Course $course)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'faculty_id' => 'nullable|exists:faculty_profiles,id',
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:courses,code,' . $course->id,
            'credit_hours' => 'required|integer|min:1|max:6',
        ]);

        $this->courseService->updateCourse($course, $validated);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated.');
    }

    public function destroy(\App\Models\Course $course)
    {
        $this->courseService->deleteCourse($course);
        return redirect()->route('admin.courses.index')->with('success', 'Course removed.');
    }
}