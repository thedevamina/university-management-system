<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use App\Models\FacultyProfile;
use App\Models\StudentProfile;
use App\Models\Course;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::firstOrCreate(
            ['email' => 'admin10@gmail.com'],
            ['name' => 'admin', 'password' => bcrypt('12345678'), 'role' => 'admin']
        );

        // Department
        $dept = Department::firstOrCreate(
            ['code' => 'CS'],
            ['name' => 'Computer Science']
        );

        // Faculty
        $facultyUser = User::firstOrCreate(
            ['email' => 'aliamina104@gmail.com'],
            ['name' => 'Amina Ali', 'password' => bcrypt('password123'), 'role' => 'faculty']
        );
        FacultyProfile::firstOrCreate(
            ['user_id' => $facultyUser->id],
            ['department_id' => $dept->id, 'designation' => 'Lecturer', 'employee_no' => 'EMP-001']
        );

        // Student
        $studentUser = User::firstOrCreate(
            ['email' => 'student1@test.com'],
            ['name' => 'student1', 'password' => bcrypt('password123'), 'role' => 'student']
        );
        StudentProfile::firstOrCreate(
            ['user_id' => $studentUser->id],
            ['department_id' => $dept->id, 'roll_no' => 'CS-2026-001', 'batch' => '2026']
        );

        // Course
        Course::firstOrCreate(
            ['code' => 'CS204'],
            ['title' => 'Mobile App Development', 'department_id' => $dept->id, 'credit_hours' => 3]
        );
    }
}