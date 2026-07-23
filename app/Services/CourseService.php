<?php

namespace App\Services;

use App\Models\Course;
use App\Repositories\CourseRepository;

class CourseService
{
    public function __construct(protected CourseRepository $courseRepository)
    {
    }

    public function listCourses()
    {
        return $this->courseRepository->getAllWithRelations();
    }

    public function createCourse(array $data): Course
    {
       
        return $this->courseRepository->create($data);
    }

    public function updateCourse(Course $course, array $data): Course
    {
        return $this->courseRepository->update($course, $data);
    }

    public function deleteCourse(Course $course): void
    {
        $this->courseRepository->delete($course);
    }
}