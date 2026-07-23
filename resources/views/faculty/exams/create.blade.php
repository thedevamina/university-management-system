<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Exam</h2>
    </x-slot>

    <div class="py-6 max-w-lg mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('faculty.exams.store') }}" method="POST" class="bg-white p-6 shadow rounded space-y-4">
            @csrf

            <div>
                <label class="block mb-1">Course</label>
                <select name="course_id" class="w-full border rounded p-2">
                    <option value="">-- Select --</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>{{ $course->title }} ({{ $course->code }})</option>
                    @endforeach
                </select>
                @error('course_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Exam Title</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded p-2" placeholder="e.g. Midterm Exam">
                @error('title') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Type</label>
                <select name="type" class="w-full border rounded p-2">
                    <option value="quiz">Quiz</option>
                    <option value="midterm" selected>Midterm</option>
                    <option value="final">Final</option>
                    <option value="assignment">Assignment</option>
                </select>
            </div>

            <div>
                <label class="block mb-1">Exam Date</label>
                <input type="date" name="exam_date" value="{{ old('exam_date') }}" class="w-full border rounded p-2">
                @error('exam_date') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Total Marks</label>
                <input type="number" name="total_marks" value="{{ old('total_marks', 100) }}" class="w-full border rounded p-2">
                @error('total_marks') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
            <a href="{{ route('faculty.exams.index') }}" class="ml-2 text-gray-600">Cancel</a>
        </form>
    </div>
</x-app-layout>