<?php

namespace App\Repositories;

use App\Models\Course;

class CourseRepository
{
    public function getAllWithRelations()
    {
        return Course::with('department', 'faculty.user')->latest()->paginate(10);
    }

    public function find(int $id): ?Course
    {
        return Course::find($id);
    }

    public function create(array $data): Course
    {
        return Course::create($data);
    }

    public function update(Course $course, array $data): Course
    {
        $course->update($data);
        return $course;
    }

    public function delete(Course $course): void
    {
        $course->delete();
    }

     public function isCodeTaken(string $code, ?int $ignoreId = null): bool
    {
        $query = Course::where('code', $code);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->exists();
    }
}