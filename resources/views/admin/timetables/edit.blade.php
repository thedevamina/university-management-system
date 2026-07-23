<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Timetable Entry</h2>
    </x-slot>

    <div class="py-6 max-w-lg mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('admin.timetables.update', $timetable) }}" method="POST" class="bg-white p-6 shadow rounded space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1">Course</label>
                <select name="course_id" class="w-full border rounded p-2">
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" @selected(old('course_id', $timetable->course_id) == $course->id)>{{ $course->title }}</option>
                    @endforeach
                </select>
                @error('course_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Faculty</label>
                <select name="faculty_id" class="w-full border rounded p-2">
                    @foreach($facultyList as $f)
                        <option value="{{ $f->id }}" @selected(old('faculty_id', $timetable->faculty_id) == $f->id)>{{ $f->user->name }}</option>
                    @endforeach
                </select>
                @error('faculty_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Day</label>
                <select name="day" class="w-full border rounded p-2">
                    @foreach(['Mon','Tue','Wed','Thu','Fri','Sat'] as $d)
                        <option value="{{ $d }}" @selected(old('day', $timetable->day) === $d)>{{ $d }}</option>
                    @endforeach
                </select>
                @error('day') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block mb-1">Start Time</label>
                  <input type="time" name="start_time" value="{{ old('start_time', substr($timetable->start_time, 0, 5)) }}" class="w-full border rounded p-2">
                    @error('start_time') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>
                <div class="flex-1">
                    <label class="block mb-1">End Time</label>
                    <input type="time" name="end_time" value="{{ old('end_time', substr($timetable->end_time, 0, 5)) }}" class="w-full border rounded p-2">
                    @error('end_time') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block mb-1">Room</label>
                <input type="text" name="room" value="{{ old('room', $timetable->room) }}" class="w-full border rounded p-2">
                @error('room') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Update</button>
            <a href="{{ route('admin.timetables.index') }}" class="ml-2 text-gray-600">Cancel</a>
        </form>
    </div>
</x-app-layout>