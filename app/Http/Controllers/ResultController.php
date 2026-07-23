<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Result;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    // Faculty: pick an exam, enter marks for all enrolled students
    public function create(Exam $exam)
    {
        $students = $exam->course->students()->with('user')->get();

        $existingResults = Result::where('exam_id', $exam->id)->get()->keyBy('student_id');

        return view('faculty.results.create', compact('exam', 'students', 'existingResults'));
    }

    public function store(Request $request, Exam $exam)
    {
        $request->validate([
            'marks' => 'required|array',
            'marks.*' => 'nullable|numeric|min:0|max:' . $exam->total_marks,
        ]);

        foreach ($request->marks as $studentId => $marks) {
            if ($marks === null || $marks === '') {
                continue;
            }

            Result::updateOrCreate(
                ['exam_id' => $exam->id, 'student_id' => $studentId],
                ['marks_obtained' => $marks]
            );
        }

        return redirect()->route('faculty.results.create', $exam)->with('success', 'Results saved successfully.');
    }

    // Student: view their own results
    public function myResults()
    {
        $student = auth()->user()->studentProfile;

        $results = Result::where('student_id', $student->id)
            ->with('exam.course')
            ->latest()
            ->get();

        return view('student.results.index', compact('results'));
    }
}