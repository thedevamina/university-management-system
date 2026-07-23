<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Student</h2>
    </x-slot>

    <div class="py-6 max-w-lg mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('admin.students.store') }}" method="POST" class="bg-white p-6 shadow rounded space-y-4">
            @csrf

            <div>
                <label class="block mb-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded p-2">
                @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded p-2">
                @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Password</label>
                <input type="password" name="password" class="w-full border rounded p-2">
                @error('password') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Department</label>
                <select name="department_id" class="w-full border rounded p-2">
                    <option value="">-- Select --</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" @selected(old('department_id') == $dept->id)>{{ $dept->name }}</option>
                    @endforeach
                </select>
                @error('department_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Roll No</label>
                <input type="text" name="roll_no" value="{{ old('roll_no') }}" class="w-full border rounded p-2" placeholder="e.g. CS-2026-001">
                @error('roll_no') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Batch</label>
                <input type="text" name="batch" value="{{ old('batch') }}" class="w-full border rounded p-2" placeholder="e.g. 2026">
                @error('batch') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
            <a href="{{ route('admin.students.index') }}" class="ml-2 text-gray-600">Cancel</a>
        </form>
    </div>
</x-app-layout>