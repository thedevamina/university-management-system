<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Services\FacultyService;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function __construct(protected FacultyService $facultyService)
    {
    }

    public function index()
    {
        $faculty = $this->facultyService->listFaculty();
        return view('admin.faculty.index', compact('faculty'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('admin.faculty.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'department_id' => 'required|exists:departments,id',
            'designation' => 'nullable|string|max:255',
            'employee_no' => 'required|string|unique:faculty_profiles,employee_no',
        ]);

        $this->facultyService->createFaculty($validated);

        return redirect()->route('admin.faculty.index')->with('success', 'Faculty member created successfully.');
    }

    public function edit(\App\Models\FacultyProfile $faculty)
    {
        $departments = Department::all();
        return view('admin.faculty.edit', compact('faculty', 'departments'));
    }

    public function update(Request $request, \App\Models\FacultyProfile $faculty)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'designation' => 'nullable|string|max:255',
            'employee_no' => 'required|string|unique:faculty_profiles,employee_no,' . $faculty->id,
        ]);

        $this->facultyService->updateFaculty($faculty, $validated);

        return redirect()->route('admin.faculty.index')->with('success', 'Faculty member updated.');
    }

    public function destroy(\App\Models\FacultyProfile $faculty)
    {
        $this->facultyService->deleteFaculty($faculty);
        return redirect()->route('admin.faculty.index')->with('success', 'Faculty member removed.');
    }
}