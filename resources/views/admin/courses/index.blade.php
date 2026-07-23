<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Courses</h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin.courses.create') }}" class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded">
            + Add Course
        </a>

        <table class="w-full bg-white shadow rounded">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3">Code</th>
                    <th class="p-3">Title</th>
                    <th class="p-3">Department</th>
                    <th class="p-3">Faculty</th>
                    <th class="p-3">Credit Hours</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                    <tr class="border-t">
                        <td class="p-3">{{ $course->code }}</td>
                        <td class="p-3">{{ $course->title }}</td>
                        <td class="p-3">{{ $course->department->name }}</td>
                        <td class="p-3">{{ $course->faculty?->user?->name ?? '—' }}</td>
                        <td class="p-3">{{ $course->credit_hours }}</td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.courses.edit', $course) }}" class="text-blue-600">Edit</a>
                            <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="inline" onsubmit="return confirm('Delete this course?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td class="p-3" colspan="6">No courses yet.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $courses->links() }}
        </div>
    </div>
</x-app-layout>