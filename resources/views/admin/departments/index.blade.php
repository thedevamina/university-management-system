<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Departments</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin.departments.create') }}" class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded">
            + Add Department
        </a>

        <table class="w-full bg-white shadow rounded">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3">Name</th>
                    <th class="p-3">Code</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departments as $department)
                    <tr class="border-t">
                        <td class="p-3">{{ $department->name }}</td>
                        <td class="p-3">{{ $department->code }}</td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.departments.edit', $department) }}" class="text-blue-600">Edit</a>
                            <form action="{{ route('admin.departments.destroy', $department) }}" method="POST" class="inline" onsubmit="return confirm('Delete this department?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td class="p-3" colspan="3">No departments yet.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $departments->links() }}
        </div>
    </div>
</x-app-layout>