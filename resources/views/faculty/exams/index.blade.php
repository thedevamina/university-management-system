<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Exams</h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <a href="{{ route('faculty.exams.create') }}" class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded">
            + Add Exam
        </a>

        <table class="w-full bg-white shadow rounded">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3">Course</th>
                    <th class="p-3">Title</th>
                    <th class="p-3">Type</th>
                    <th class="p-3">Date</th>
                    <th class="p-3">Total Marks</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($exams as $exam)
                    <tr class="border-t">
                        <td class="p-3">{{ $exam->course->title }}</td>
                        <td class="p-3">{{ $exam->title }}</td>
                        <td class="p-3">{{ ucfirst($exam->type) }}</td>
                        <td class="p-3">{{ $exam->exam_date }}</td>
                        <td class="p-3">{{ $exam->total_marks }}</td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('faculty.results.create', $exam) }}" class="text-green-600">Enter Marks</a>
                            <a href="{{ route('faculty.exams.edit', $exam) }}" class="text-blue-600">Edit</a>
                            <form action="{{ route('faculty.exams.destroy', $exam) }}" method="POST" class="inline" onsubmit="return confirm('Delete this exam?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td class="p-3" colspan="6">No exams yet.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $exams->links() }}</div>
    </div>
</x-app-layout>