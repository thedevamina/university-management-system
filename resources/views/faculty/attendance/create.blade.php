<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mark Attendance</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

        @if(session('success'))
            <div class="p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Course + Date selector --}}
        <form method="GET" action="{{ route('faculty.attendance.create') }}" class="bg-white p-4 shadow rounded flex gap-4 items-end">
            <div>
                <label class="block mb-1">Course</label>
                <select name="course_id" class="border rounded p-2">
                    <option value="">-- Select Course --</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" @selected($selectedCourseId == $course->id)>
                            {{ $course->title }} ({{ $course->code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1">Date</label>
                <input type="date" name="date" value="{{ $date }}" class="border rounded p-2">
            </div>

            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Load Students</button>
        </form>

        {{-- Attendance form --}}
        @if($selectedCourseId)
            <form method="POST" action="{{ route('faculty.attendance.store') }}" class="bg-white p-4 shadow rounded">
                @csrf
                <input type="hidden" name="course_id" value="{{ $selectedCourseId }}">
                <input type="hidden" name="date" value="{{ $date }}">

                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3">Roll No</th>
                            <th class="p-3">Student</th>
                            <th class="p-3">Present</th>
                            <th class="p-3">Absent</th>
                            <th class="p-3">Leave</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            @php
                                $current = $existingAttendance->get($student->id)?->status ?? 'present';
                            @endphp
                            <tr class="border-t">
                                <td class="p-3">{{ $student->roll_no }}</td>
                                <td class="p-3">{{ $student->user->name }}</td>
                                <td class="p-3">
                                    <input type="radio" name="attendance[{{ $student->id }}]" value="present" @checked($current === 'present')>
                                </td>
                                <td class="p-3">
                                    <input type="radio" name="attendance[{{ $student->id }}]" value="absent" @checked($current === 'absent')>
                                </td>
                                <td class="p-3">
                                    <input type="radio" name="attendance[{{ $student->id }}]" value="leave" @checked($current === 'leave')>
                                </td>
                            </tr>
                        @empty
                            <tr><td class="p-3" colspan="5">No students enrolled in this course yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                @if($students->isNotEmpty())
                    <button type="submit" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded">Save Attendance</button>
                @endif
            </form>
        @endif

    </div>
</x-app-layout>