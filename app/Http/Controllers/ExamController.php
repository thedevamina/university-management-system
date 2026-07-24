<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Services\ExamService;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function __construct(protected ExamService $examService)
    {
    }

    public function index()
    {
        $faculty = auth()->user()->facultyProfile;
        $exams = $this->examService->listForFaculty($faculty->id);

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

        $this->examService->createExam($request->only('course_id','title','type','exam_date','total_marks'));

        return redirect()->route('faculty.exams.index')->with('success', 'Exam created successfully.');
    }

    public function edit(\App\Models\Exam $exam)
    {
        $faculty = auth()->user()->facultyProfile;
        $courses = Course::where('faculty_id', $faculty->id)->get();

        return view('faculty.exams.edit', compact('exam', 'courses'));
    }

    public function update(Request $request, \App\Models\Exam $exam)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:quiz,midterm,final,assignment',
            'exam_date' => 'required|date',
            'total_marks' => 'required|integer|min:1|max:1000',
        ]);

        $this->examService->updateExam($exam, $request->only('title','type','exam_date','total_marks'));

        return redirect()->route('faculty.exams.index')->with('success', 'Exam updated.');
    }

    public function destroy(\App\Models\Exam $exam)
    {
        $this->examService->deleteExam($exam);
        return redirect()->route('faculty.exams.index')->with('success', 'Exam removed.');
    }
}