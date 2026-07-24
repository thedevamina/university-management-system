<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Services\ResultService;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function __construct(protected ResultService $resultService)
    {
    }

    public function create(Exam $exam)
    {
        [$students, $existingResults] = $this->resultService->rosterForExam($exam);

        return view('faculty.results.create', compact('exam', 'students', 'existingResults'));
    }

    public function store(Request $request, Exam $exam)
    {
        $request->validate([
            'marks' => 'required|array',
            'marks.*' => 'nullable|numeric|min:0|max:' . $exam->total_marks,
        ]);

        $this->resultService->saveMarks($exam, $request->marks);

        return redirect()->route('faculty.results.create', $exam)->with('success', 'Results saved successfully.');
    }

    public function myResults()
    {
        $student = auth()->user()->studentProfile;
        $results = $this->resultService->myResults($student->id);

        return view('student.results.index', compact('results'));
    }
}