<?php

namespace App\Repositories;

use App\Models\Result;

class ResultRepository
{
    public function forExam(int $examId)
    {
        return Result::where('exam_id', $examId)->get()->keyBy('student_id');
    }

    public function forStudent(int $studentId)
    {
        return Result::where('student_id', $studentId)->with('exam.course')->latest()->get();
    }

    public function saveOne(int $examId, int $studentId, float $marks): Result
    {
        return Result::updateOrCreate(
            ['exam_id' => $examId, 'student_id' => $studentId],
            ['marks_obtained' => $marks]
        );
    }
}