<?php

namespace App\Repositories;

use App\Models\Fee;

class FeeRepository
{
    public function getAll()
    {
        return Fee::with('student.user')->latest()->paginate(15);
    }

    public function forStudent(int $studentId)
    {
        return Fee::where('student_id', $studentId)->latest()->get();
    }

    public function create(array $data): Fee
    {
        return Fee::create($data);
    }

    public function markPaid(Fee $fee): Fee
    {
        $fee->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
        return $fee;
    }

    public function delete(Fee $fee): void
    {
        $fee->delete();
    }
}