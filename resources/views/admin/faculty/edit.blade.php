<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Faculty</h2>
    </x-slot>

    <div class="py-6 max-w-lg mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('admin.faculty.update', $faculty) }}" method="POST" class="bg-white p-6 shadow rounded space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1">Name (read-only)</label>
                <input type="text" value="{{ $faculty->user->name }}" class="w-full border rounded p-2 bg-gray-100" disabled>
            </div>

            <div>
                <label class="block mb-1">Email (read-only)</label>
                <input type="text" value="{{ $faculty->user->email }}" class="w-full border rounded p-2 bg-gray-100" disabled>
            </div>

            <div>
                <label class="block mb-1">Department</label>
                <select name="department_id" class="w-full border rounded p-2">
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" @selected(old('department_id', $faculty->department_id) == $dept->id)>{{ $dept->name }}</option>
                    @endforeach
                </select>
                @error('department_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Designation</label>
                <input type="text" name="designation" value="{{ old('designation', $faculty->designation) }}" class="w-full border rounded p-2">
                @error('designation') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Employee Number</label>
                <input type="text" name="employee_no" value="{{ old('employee_no', $faculty->employee_no) }}" class="w-full border rounded p-2">
                @error('employee_no') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Update</button>
            <a href="{{ route('admin.faculty.index') }}" class="ml-2 text-gray-600">Cancel</a>
        </form>
    </div>
</x-app-layout>