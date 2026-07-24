<?php

namespace App\Services;

use App\Models\Exam;
use App\Repositories\ResultRepository;

class ResultService
{
    public function __construct(protected ResultRepository $resultRepository)
    {
    }

    public function rosterForExam(Exam $exam)
    {
        $students = $exam->course->students()->with('user')->get();
        $existingResults = $this->resultRepository->forExam($exam->id);

        return [$students, $existingResults];
    }

    public function saveMarks(Exam $exam, array $marks): void
    {
        foreach ($marks as $studentId => $value) {
            if ($value === null || $value === '') {
                continue;
            }
            $this->resultRepository->saveOne($exam->id, (int) $studentId, (float) $value);
        }
    }

    public function myResults(int $studentId)
    {
        return $this->resultRepository->forStudent($studentId);
    }
}