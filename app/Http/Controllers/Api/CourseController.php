<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;

class CourseController extends Controller
{
    // GET /api/courses
    public function index()
    {
        $courses = Course::with('department', 'faculty.user')->get();

        return response()->json([
            'data' => $courses->map(function ($course) {
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'code' => $course->code,
                    'credit_hours' => $course->credit_hours,
                    'department' => $course->department->name,
                    'faculty' => $course->faculty?->user?->name,
                ];
            }),
        ]);
    }

    // GET /api/courses/{course}
    public function show(Course $course)
    {
        return response()->json([
            'data' => [
                'id' => $course->id,
                'title' => $course->title,
                'code' => $course->code,
                'credit_hours' => $course->credit_hours,
                'department' => $course->department->name,
                'faculty' => $course->faculty?->user?->name,
            ],
        ]);
    }
}