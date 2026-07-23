<x-app-layout>
    <x-slot name="header">My Courses</x-slot>

    <div class="p-6 max-w-6xl mx-auto space-y-10">

        @if(session('success'))
            <div class="p-3 bg-green-100 text-green-800 rounded text-sm">{{ session('success') }}</div>
        @endif

        {{-- Enrolled Courses as Cards --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">My Courses</h3>

            @if($enrollments->isEmpty())
                <p class="text-gray-500 text-sm">You are not enrolled in any course yet.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @php
                        $banners = ['from-blue-500 to-blue-700','from-amber-400 to-amber-600','from-indigo-500 to-indigo-700','from-emerald-500 to-emerald-700','from-rose-500 to-rose-700','from-cyan-500 to-cyan-700'];
                    @endphp
                    @foreach($enrollments as $enrollment)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="h-24 bg-gradient-to-br {{ $banners[$enrollment->course_id % count($banners)] }} relative">
                                <span class="absolute top-2 left-2 text-xs font-medium bg-white/90 text-gray-700 px-2 py-0.5 rounded">
                                    {{ $enrollment->semester }}
                                </span>
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-gray-400">{{ $enrollment->course->code }}</p>
                                <h4 class="font-semibold text-gray-800">{{ $enrollment->course->title }}</h4>
                                <p class="text-xs text-gray-500 mt-1 capitalize">Status: {{ $enrollment->status }}</p>

                                <form action="{{ route('student.enrollments.destroy', $enrollment) }}" method="POST" onsubmit="return confirm('Drop this course?')" class="mt-3">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-red-600 hover:underline">Drop Course</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Available Courses --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Available Courses — {{ auth()->user()->studentProfile->department->name }}</h3>

            @if($availableCourses->isEmpty())
                <p class="text-gray-500 text-sm">No more courses available to enroll.</p>
            @else
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 divide-y">
                    @foreach($availableCourses as $course)
                        <form action="{{ route('student.enrollments.store') }}" method="POST" class="flex items-center justify-between p-4 gap-4">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <div>
                                <p class="text-xs text-gray-400">{{ $course->code }}</p>
                                <p class="font-medium text-gray-800">{{ $course->title }}</p>
                                <p class="text-xs text-gray-500">{{ $course->credit_hours }} credit hours</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="text" name="semester" placeholder="e.g. Fall 2026" required class="border rounded-md p-1.5 text-sm w-32">
                                <button type="submit" class="px-3 py-1.5 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-500">Enroll</button>
                            </div>
                        </form>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</x-app-layout>