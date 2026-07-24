<?php

namespace App\Services;

use App\Models\Exam;
use App\Repositories\ExamRepository;

class ExamService
{
    public function __construct(protected ExamRepository $examRepository)
    {
    }

    public function listForFaculty(int $facultyId)
    {
        return $this->examRepository->forFaculty($facultyId);
    }

    public function createExam(array $data): Exam
    {
        return $this->examRepository->create($data);
    }

    public function updateExam(Exam $exam, array $data): Exam
    {
        return $this->examRepository->update($exam, $data);
    }

    public function deleteExam(Exam $exam): void
    {
        $this->examRepository->delete($exam);
    }
}