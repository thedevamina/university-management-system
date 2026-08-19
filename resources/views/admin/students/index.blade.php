<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Students</h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin.students.create') }}" class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded">
            + Add Student
        </a>

        <table class="w-full bg-white shadow rounded">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3">Roll No</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Department</th>
                    <th class="p-3">Batch</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr class="border-t">
                        <td class="p-3">{{ $student->roll_no }}</td>
                        <td class="p-3">{{ $student->user->name }}</td>
                        <td class="p-3">{{ $student->user->email }}</td>
                        <td class="p-3">{{ $student->department->name }}</td>
                        <td class="p-3">{{ $student->batch }}</td>
                        <td class="p-3 space-x-2">
    <a href="{{ route('admin.students.edit', $student) }}" class="text-blue-600">Edit</a>
    <a href="{{ route('admin.students.documents.index', $student) }}" class="text-purple-600">Documents</a>
    <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="inline" onsubmit="return confirm('Remove this student?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600">Delete</button>
    </form>
</td>
                    </tr>
                @empty
                    <tr><td class="p-3" colspan="6">No students yet.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $students->links() }}
        </div>
    </div>
</x-app-layout>