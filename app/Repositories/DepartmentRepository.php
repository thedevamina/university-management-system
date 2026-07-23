<?php

namespace App\Repositories;

use App\Models\Department;

class DepartmentRepository
{
    public function getAll()
    {
        return Department::latest()->paginate(10);
    }

    public function create(array $data): Department
    {
        return Department::create($data);
    }

    public function update(Department $department, array $data): Department
    {
        $department->update($data);
        return $department;
    }

    public function delete(Department $department): void
    {
        $department->delete();
    }
}