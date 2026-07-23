<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Fee Record</h2>
    </x-slot>

    <div class="py-6 max-w-lg mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('admin.fees.store') }}" method="POST" class="bg-white p-6 shadow rounded space-y-4">
            @csrf

            <div>
                <label class="block mb-1">Student</label>
                <select name="student_id" class="w-full border rounded p-2">
                    <option value="">-- Select --</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>
                            {{ $student->user->name }} ({{ $student->roll_no }})
                        </option>
                    @endforeach
                </select>
                @error('student_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Semester</label>
                <input type="text" name="semester" value="{{ old('semester') }}" class="w-full border rounded p-2" placeholder="e.g. Fall 2026">
                @error('semester') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Amount</label>
                <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" class="w-full border rounded p-2">
                @error('amount') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Due Date</label>
                <input type="date" name="due_date" value="{{ old('due_date') }}" class="w-full border rounded p-2">
                @error('due_date') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
            <a href="{{ route('admin.fees.index') }}" class="ml-2 text-gray-600">Cancel</a>
        </form>
    </div>
</x-app-layout>