<?php

namespace App\Services;

use App\Models\FacultyProfile;
use App\Repositories\FacultyRepository;

class FacultyService
{
    public function __construct(protected FacultyRepository $facultyRepository)
    {
    }

    public function listFaculty()
    {
        return $this->facultyRepository->getAll();
    }

    public function createFaculty(array $validated): FacultyProfile
    {
        $user = $this->facultyRepository->createUser([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'faculty',
        ]);

        return $this->facultyRepository->createProfile([
            'user_id' => $user->id,
            'department_id' => $validated['department_id'],
            'designation' => $validated['designation'],
            'employee_no' => $validated['employee_no'],
        ]);
    }

    public function updateFaculty(FacultyProfile $faculty, array $data): FacultyProfile
    {
        return $this->facultyRepository->update($faculty, $data);
    }

    public function deleteFaculty(FacultyProfile $faculty): void
    {
        $this->facultyRepository->delete($faculty);
    }
}