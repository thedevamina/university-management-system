<x-app-layout>
    <x-slot name="header">
        Faculty Dashboard
    </x-slot>

    <div class="p-6 max-w-6xl mx-auto">

        <p class="mb-6 text-gray-600">
            Welcome back,
            <span class="font-semibold">{{ auth()->user()->name }}</span>.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

            {{-- Attendance --}}
            <a href="{{ route('faculty.attendance.create') }}"
               class="group bg-white rounded-2xl border border-gray-200 shadow-sm p-6 hover:shadow-lg hover:-translate-y-1 transition duration-300">

                <div class="w-16 h-16 rounded-full bg-green-100 text-green-700 flex items-center justify-center mb-5">
                    <x-heroicon-o-check-circle class="w-8 h-8"/>
                </div>

                <h3 class="text-xl font-semibold text-gray-800 group-hover:text-indigo-600 transition">
                    Mark Attendance
                </h3>

                <p class="mt-2 text-gray-500">
                    Record student attendance
                </p>

            </a>

            {{-- Exams --}}
            <a href="{{ route('faculty.exams.index') }}"
               class="group bg-white rounded-2xl border border-gray-200 shadow-sm p-6 hover:shadow-lg hover:-translate-y-1 transition duration-300">

                <div class="w-16 h-16 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center mb-5">
                    <x-heroicon-o-document-text class="w-8 h-8"/>
                </div>

                <h3 class="text-xl font-semibold text-gray-800 group-hover:text-indigo-600 transition">
                    Exams &amp; Results
                </h3>

                <p class="mt-2 text-gray-500">
                    Create exams and enter marks
                </p>

            </a>

        </div>

    </div>
</x-app-layout>