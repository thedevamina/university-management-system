<?php

namespace App\Repositories;

use App\Models\FacultyProfile;
use App\Models\User;

class FacultyRepository
{
    public function getAll()
    {
        return FacultyProfile::with('user', 'department')->latest()->paginate(10);
    }

    public function createUser(array $data): User
    {
        return User::create($data);
    }

    public function createProfile(array $data): FacultyProfile
    {
        return FacultyProfile::create($data);
    }

    public function update(FacultyProfile $faculty, array $data): FacultyProfile
    {
        $faculty->update($data);
        return $faculty;
    }

    public function delete(FacultyProfile $faculty): void
    {
        $faculty->user()->delete(); // cascades to profile
    }
}