<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Faculty</h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin.faculty.create') }}" class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded">
            + Add Faculty
        </a>

        <table class="w-full bg-white shadow rounded">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3">Name</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Department</th>
                    <th class="p-3">Designation</th>
                    <th class="p-3">Employee No</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faculty as $member)
                    <tr class="border-t">
                        <td class="p-3">{{ $member->user->name }}</td>
                        <td class="p-3">{{ $member->user->email }}</td>
                        <td class="p-3">{{ $member->department->name }}</td>
                        <td class="p-3">{{ $member->designation }}</td>
                        <td class="p-3">{{ $member->employee_no }}</td>
                        <td class="p-3 space-x-2">
                           
    <a href="{{ route('admin.faculty.edit', $member) }}" class="text-blue-600">Edit</a>
    <a href="{{ route('admin.faculty.documents.index', $member) }}" class="text-purple-600">Documents</a>
    <form action="{{ route('admin.faculty.destroy', $member) }}" method="POST" class="inline" onsubmit="return confirm('Remove this faculty member?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600">Delete</button>
    </form>
</td>
                        </td>
                    </tr>
                @empty
                    <tr><td class="p-3" colspan="6">No faculty members yet.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $faculty->links() }}
        </div>
    </div>
</x-app-layout>