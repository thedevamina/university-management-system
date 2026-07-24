<?php

namespace App\Services;

use App\Models\Fee;
use App\Repositories\FeeRepository;

class FeeService
{
    public function __construct(protected FeeRepository $feeRepository)
    {
    }

    public function listFees()
    {
        return $this->feeRepository->getAll();
    }

    public function myFees(int $studentId)
    {
        return $this->feeRepository->forStudent($studentId);
    }

    public function createFee(array $data): Fee
    {
        return $this->feeRepository->create($data);
    }

    public function markPaid(Fee $fee): Fee
    {
        return $this->feeRepository->markPaid($fee);
    }

    public function deleteFee(Fee $fee): void
    {
        $this->feeRepository->delete($fee);
    }
}