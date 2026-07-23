<x-app-layout>
    <x-slot name="header">Faculty Dashboard</x-slot>

    <div class="p-6 max-w-6xl mx-auto">
        <p class="mb-6 text-gray-600">Welcome back, <span class="font-medium">{{ auth()->user()->name }}</span>.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <a href="{{ route('faculty.attendance.create') }}" class="group bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-lg hover:-translate-y-0.5 transition">
                <div class="w-11 h-11 rounded-lg bg-green-100 text-green-700 flex items-center justify-center text-xl mb-4"></div>
                <h3 class="font-semibold text-gray-800 group-hover:text-indigo-600">Mark Attendance</h3>
                <p class="text-sm text-gray-500 mt-1">Record student attendance</p>
            </a>

            <a href="{{ route('faculty.exams.index') }}" class="group bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-lg hover:-translate-y-0.5 transition">
                <div class="w-11 h-11 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-xl mb-4">📝</div>
                <h3 class="font-semibold text-gray-800 group-hover:text-indigo-600">Exams & Results</h3>
                <p class="text-sm text-gray-500 mt-1">Create exams & enter marks</p>
            </a>
        </div>
    </div>
</x-app-layout>