<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Student</h2>
    </x-slot>

    <div class="py-6 max-w-lg mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('admin.students.update', $student) }}" method="POST" class="bg-white p-6 shadow rounded space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1">Name (read-only)</label>
                <input type="text" value="{{ $student->user->name }}" class="w-full border rounded p-2 bg-gray-100" disabled>
            </div>

            <div>
                <label class="block mb-1">Roll No (read-only)</label>
                <input type="text" value="{{ $student->roll_no }}" class="w-full border rounded p-2 bg-gray-100" disabled>
            </div>

            <div>
                <label class="block mb-1">Department</label>
                <select name="department_id" class="w-full border rounded p-2">
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" @selected(old('department_id', $student->department_id) == $dept->id)>{{ $dept->name }}</option>
                    @endforeach
                </select>
                @error('department_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Batch</label>
                <input type="text" name="batch" value="{{ old('batch', $student->batch) }}" class="w-full border rounded p-2">
                @error('batch') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Update</button>
            <a href="{{ route('admin.students.index') }}" class="ml-2 text-gray-600">Cancel</a>
        </form>
    </div>
</x-app-layout>