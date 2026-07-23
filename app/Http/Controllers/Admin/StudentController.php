<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Services\StudentService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct(protected StudentService $studentService)
    {
    }

    public function index()
    {
        $students = $this->studentService->listStudents();
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('admin.students.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'department_id' => 'required|exists:departments,id',
            'batch' => 'required|string|max:50',
        ]);

        $this->studentService->createStudent($validated);

        return redirect()->route('admin.students.index')->with('success', 'Student created successfully.');
    }

    public function edit(\App\Models\StudentProfile $student)
    {
        $departments = Department::all();
        return view('admin.students.edit', compact('student', 'departments'));
    }

    public function update(Request $request, \App\Models\StudentProfile $student)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'batch' => 'required|string|max:50',
        ]);

        $this->studentService->updateStudent($student, $validated);

        return redirect()->route('admin.students.index')->with('success', 'Student updated.');
    }

    public function destroy(\App\Models\StudentProfile $student)
    {
        $this->studentService->deleteStudent($student);
        return redirect()->route('admin.students.index')->with('success', 'Student removed.');
    }
}