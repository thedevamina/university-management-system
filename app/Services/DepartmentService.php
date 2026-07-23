<?php

namespace App\Services;

use App\Models\Department;
use App\Repositories\DepartmentRepository;

class DepartmentService
{
    public function __construct(protected DepartmentRepository $departmentRepository)
    {
    }

    public function listDepartments()
    {
        return $this->departmentRepository->getAll();
    }

    public function createDepartment(array $data): Department
    {
        return $this->departmentRepository->create($data);
    }

    public function updateDepartment(Department $department, array $data): Department
    {
        return $this->departmentRepository->update($department, $data);
    }

    public function deleteDepartment(Department $department): void
    {
        $this->departmentRepository->delete($department);
    }
}