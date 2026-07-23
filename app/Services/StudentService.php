<?php

namespace App\Services;

use App\Models\Department;
use App\Models\StudentProfile;
use App\Repositories\StudentRepository;

class StudentService
{
    public function __construct(protected StudentRepository $studentRepository)
    {
    }

    public function listStudents()
    {
        return $this->studentRepository->getAll();
    }

    public function createStudent(array $validated): StudentProfile
    {
        $user = $this->studentRepository->createUser([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'student',
        ]);

        // Roll number auto-generate karne ki business logic yahan hai
        $department = Department::find($validated['department_id']);
        $count = $this->studentRepository->countInDepartment($department->id) + 1;
        $rollNo = $department->code . '-' . $validated['batch'] . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

        return $this->studentRepository->createProfile([
            'user_id' => $user->id,
            'department_id' => $validated['department_id'],
            'roll_no' => $rollNo,
            'batch' => $validated['batch'],
        ]);
    }

    public function updateStudent(StudentProfile $student, array $data): StudentProfile
    {
        return $this->studentRepository->update($student, $data);
    }

    public function deleteStudent(StudentProfile $student): void
    {
        $this->studentRepository->delete($student);
    }
}