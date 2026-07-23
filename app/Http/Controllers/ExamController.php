<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Course;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $faculty = auth()->user()->facultyProfile;

        $exams = Exam::whereHas('course', function ($q) use ($faculty) {
            $q->where('faculty_id', $faculty->id);
        })->with('course')->latest()->paginate(10);

        return view('faculty.exams.index', compact('exams'));
    }

    public function create()
    {
        $faculty = auth()->user()->facultyProfile;
        $courses = Course::where('faculty_id', $faculty->id)->get();

        return view('faculty.exams.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:quiz,midterm,final,assignment',
            'exam_date' => 'required|date',
            'total_marks' => 'required|integer|min:1|max:1000',
        ]);

        Exam::create($request->only('course_id','title','type','exam_date','total_marks'));

        return redirect()->route('faculty.exams.index')->with('success', 'Exam created successfully.');
    }

    public function edit(Exam $exam)
    {
        $faculty = auth()->user()->facultyProfile;
        $courses = Course::where('faculty_id', $faculty->id)->get();

        return view('faculty.exams.edit', compact('exam', 'courses'));
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:quiz,midterm,final,assignment',
            'exam_date' => 'required|date',
            'total_marks' => 'required|integer|min:1|max:1000',
        ]);

        $exam->update($request->only('title','type','exam_date','total_marks'));

        return redirect()->route('faculty.exams.index')->with('success', 'Exam updated.');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('faculty.exams.index')->with('success', 'Exam removed.');
    }
}