<?php

namespace App\Services;

use App\Models\Timetable;
use App\Repositories\TimetableRepository;

class TimetableService
{
    public function __construct(protected TimetableRepository $timetableRepository)
    {
    }

    public function listTimetables()
    {
        return $this->timetableRepository->getAll();
    }

    public function createEntry(array $data): Timetable
    {
        return $this->timetableRepository->create($data);
    }

    public function updateEntry(Timetable $timetable, array $data): Timetable
    {
        return $this->timetableRepository->update($timetable, $data);
    }

    public function deleteEntry(Timetable $timetable): void
    {
        $this->timetableRepository->delete($timetable);
    }
}