<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Course</h2>
    </x-slot>

    <div class="py-6 max-w-lg mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('admin.courses.update', $course) }}" method="POST" class="bg-white p-6 shadow rounded space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1">Course Title</label>
                <input type="text" name="title" value="{{ old('title', $course->title) }}" class="w-full border rounded p-2">
                @error('title') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Course Code</label>
                <input type="text" name="code" value="{{ old('code', $course->code) }}" class="w-full border rounded p-2">
                @error('code') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Department</label>
                <select name="department_id" class="w-full border rounded p-2">
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" @selected(old('department_id', $course->department_id) == $dept->id)>{{ $dept->name }}</option>
                    @endforeach
                </select>
                @error('department_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Assign Faculty</label>
                <select name="faculty_id" class="w-full border rounded p-2">
                    <option value="">-- None --</option>
                    @foreach($facultyList as $f)
                        <option value="{{ $f->id }}" @selected(old('faculty_id', $course->faculty_id) == $f->id)>{{ $f->user->name }}</option>
                    @endforeach
                </select>
                @error('faculty_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Credit Hours</label>
                <input type="number" name="credit_hours" value="{{ old('credit_hours', $course->credit_hours) }}" min="1" max="6" class="w-full border rounded p-2">
                @error('credit_hours') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Update</button>
            <a href="{{ route('admin.courses.index') }}" class="ml-2 text-gray-600">Cancel</a>
        </form>
    </div>
</x-app-layout>