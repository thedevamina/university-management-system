<?php

namespace App\Repositories;

use App\Models\Exam;

class ExamRepository
{
    public function forFaculty(int $facultyId)
    {
        return Exam::whereHas('course', function ($q) use ($facultyId) {
            $q->where('faculty_id', $facultyId);
        })->with('course')->latest()->paginate(10);
    }

    public function create(array $data): Exam
    {
        return Exam::create($data);
    }

    public function update(Exam $exam, array $data): Exam
    {
        $exam->update($data);
        return $exam;
    }

    public function delete(Exam $exam): void
    {
        $exam->delete();
    }
}