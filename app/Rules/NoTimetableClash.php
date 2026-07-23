<?php

namespace App\Rules;

use App\Models\Timetable;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoTimetableClash implements ValidationRule
{
    public function __construct(
        protected string $day,
        protected string $startTime,
        protected string $endTime,
        protected string $room,
        protected ?int $facultyId = null,
        protected ?int $ignoreId = null,
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = Timetable::where('day', $this->day)
            ->where('room', $this->room)
            ->where('start_time', '<', $this->endTime)
            ->where('end_time', '>', $this->startTime);

        if ($this->ignoreId) {
            $query->where('id', '!=', $this->ignoreId);
        }

        if ($query->exists()) {
            $fail('This room is already booked for an overlapping time slot on ' . $this->day . '.');
        }
    }
}