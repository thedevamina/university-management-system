<x-app-layout>
    <x-slot name="header">Student Dashboard</x-slot>

    <div class="p-6 max-w-6xl mx-auto">
        <p class="mb-6 text-gray-600">Welcome back, <span class="font-medium">{{ auth()->user()->name }}</span>.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <a href="{{ route('student.enrollments.index') }}" class="group bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-lg hover:-translate-y-0.5 transition">
                <div class="w-11 h-11 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center text-xl mb-4">📚</div>
                <h3 class="font-semibold text-gray-800 group-hover:text-indigo-600">My Enrollments</h3>
                <p class="text-sm text-gray-500 mt-1">Enroll or drop courses</p>
            </a>

            <a href="{{ route('student.results') }}" class="group bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-lg hover:-translate-y-0.5 transition">
                <div class="w-11 h-11 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center text-xl mb-4">📊</div>
                <h3 class="font-semibold text-gray-800 group-hover:text-indigo-600">My Results</h3>
                <p class="text-sm text-gray-500 mt-1">View exam results & grades</p>
            </a>

            <a href="{{ route('student.fees') }}" class="group bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-lg hover:-translate-y-0.5 transition">
                <div class="w-11 h-11 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center text-xl mb-4">💳</div>
                <h3 class="font-semibold text-gray-800 group-hover:text-indigo-600">My Fees</h3>
                <p class="text-sm text-gray-500 mt-1">Check fee status</p>
            </a>
        </div>
    </div>
</x-app-layout>