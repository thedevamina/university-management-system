<?php

namespace App\Repositories;

use App\Models\StudentProfile;
use App\Models\User;

class StudentRepository
{
    public function getAll()
    {
        return StudentProfile::with('user', 'department')->latest()->paginate(10);
    }

    public function countInDepartment(int $departmentId): int
    {
        return StudentProfile::where('department_id', $departmentId)->count();
    }

    public function createUser(array $data): User
    {
        return User::create($data);
    }

    public function createProfile(array $data): StudentProfile
    {
        return StudentProfile::create($data);
    }

    public function update(StudentProfile $student, array $data): StudentProfile
    {
        $student->update($data);
        return $student;
    }

    public function delete(StudentProfile $student): void
    {
        $student->user()->delete(); // cascades to profile
    }
}