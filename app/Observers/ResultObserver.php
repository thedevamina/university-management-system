<?php

namespace App\Observers;

use App\Models\Result;

class ResultObserver
{
    public function saving(Result $result): void
    {
        $percentage = ($result->marks_obtained / $result->exam->total_marks) * 100;

        $result->grade = match(true) {
            $percentage >= 85 => 'A',
            $percentage >= 70 => 'B',
            $percentage >= 55 => 'C',
            $percentage >= 40 => 'D',
            default => 'F',
        };
    }
}