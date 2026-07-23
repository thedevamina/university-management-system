<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Results</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <table class="w-full bg-white shadow rounded">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3">Course</th>
                    <th class="p-3">Exam</th>
                    <th class="p-3">Type</th>
                    <th class="p-3">Marks</th>
                    <th class="p-3">Grade</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $result)
                    <tr class="border-t">
                        <td class="p-3">{{ $result->exam->course->title }}</td>
                        <td class="p-3">{{ $result->exam->title }}</td>
                        <td class="p-3">{{ ucfirst($result->exam->type) }}</td>
                        <td class="p-3">{{ $result->marks_obtained }} / {{ $result->exam->total_marks }}</td>
                        <td class="p-3 font-semibold">{{ $result->grade }}</td>
                    </tr>
                @empty
                    <tr><td class="p-3" colspan="5">No results published yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>