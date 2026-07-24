<?php

namespace App\Repositories;

use App\Models\Timetable;

class TimetableRepository
{
    public function getAll()
    {
        return Timetable::with('course', 'faculty.user')->orderBy('day')->orderBy('start_time')->paginate(15);
    }

    public function create(array $data): Timetable
    {
        return Timetable::create($data);
    }

    public function update(Timetable $timetable, array $data): Timetable
    {
        $timetable->update($data);
        return $timetable;
    }

    public function delete(Timetable $timetable): void
    {
        $timetable->delete();
    }
}