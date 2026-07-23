<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Enter Marks — {{ $exam->title }} ({{ $exam->course->title }})
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <form action="{{ route('faculty.results.store', $exam) }}" method="POST" class="bg-white p-4 shadow rounded">
            @csrf

            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-3">Roll No</th>
                        <th class="p-3">Student</th>
                        <th class="p-3">Marks (out of {{ $exam->total_marks }})</th>
                        <th class="p-3">Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        @php $existing = $existingResults->get($student->id); @endphp
                        <tr class="border-t">
                            <td class="p-3">{{ $student->roll_no }}</td>
                            <td class="p-3">{{ $student->user->name }}</td>
                            <td class="p-3">
                                <input type="number" step="0.01" min="0" max="{{ $exam->total_marks }}"
                                    name="marks[{{ $student->id }}]"
                                    value="{{ old('marks.'.$student->id, $existing->marks_obtained ?? '') }}"
                                    class="border rounded p-1 w-24">
                            </td>
                            <td class="p-3">{{ $existing->grade ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td class="p-3" colspan="4">No students enrolled in this course.</td></tr>
                    @endforelse
                </tbody>
            </table>

            @if($students->isNotEmpty())
                <button type="submit" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded">Save Marks</button>
            @endif
        </form>
    </div>
</x-app-layout>