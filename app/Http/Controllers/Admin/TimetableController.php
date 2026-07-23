<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use App\Models\Course;
use App\Models\FacultyProfile;
use App\Rules\NoTimetableClash;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index()
    {
        $timetables = Timetable::with('course', 'faculty.user')->orderBy('day')->orderBy('start_time')->paginate(15);
        return view('admin.timetables.index', compact('timetables'));
    }

    public function create()
    {
        $courses = Course::all();
        $facultyList = FacultyProfile::with('user')->get();
        return view('admin.timetables.create', compact('courses', 'facultyList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'faculty_id' => 'required|exists:faculty_profiles,id',
            'day' => 'required|in:Mon,Tue,Wed,Thu,Fri,Sat',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => ['required', 'string', 'max:50', new NoTimetableClash(
                $request->day, $request->start_time, $request->end_time, $request->room
            )],
        ]);

        Timetable::create($validated);

        return redirect()->route('admin.timetables.index')->with('success', 'Timetable entry created.');
    }

    public function edit(Timetable $timetable)
    {
        $courses = Course::all();
        $facultyList = FacultyProfile::with('user')->get();
        return view('admin.timetables.edit', compact('timetable', 'courses', 'facultyList'));
    }

    public function update(Request $request, Timetable $timetable)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'faculty_id' => 'required|exists:faculty_profiles,id',
            'day' => 'required|in:Mon,Tue,Wed,Thu,Fri,Sat',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => ['required', 'string', 'max:50', new NoTimetableClash(
                $request->day, $request->start_time, $request->end_time, $request->room, ignoreId: $timetable->id
            )],
        ]);

        $timetable->update($validated);

        return redirect()->route('admin.timetables.index')->with('success', 'Timetable updated.');
    }

    public function destroy(Timetable $timetable)
    {
        $timetable->delete();
        return redirect()->route('admin.timetables.index')->with('success', 'Timetable entry removed.');
    }
}