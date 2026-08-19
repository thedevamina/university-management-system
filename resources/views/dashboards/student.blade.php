<x-app-layout>
    <x-slot name="header">
        Student Dashboard
    </x-slot>

    <div class="p-6 max-w-6xl mx-auto">

        <p class="mb-6 text-gray-600">
            Welcome back,
            <span class="font-semibold">{{ auth()->user()->name }}</span>.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

            {{-- Enrollments --}}
            <a href="{{ route('student.enrollments.index') }}"
               class="group bg-white rounded-2xl border border-gray-200 shadow-sm p-6 hover:shadow-lg hover:-translate-y-1 transition duration-300">

                <div class="w-16 h-16 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center mb-5">
                    <x-heroicon-o-book-open class="w-8 h-8"/>
                </div>

                <h3 class="text-xl font-semibold text-gray-800 group-hover:text-indigo-600 transition">
                    My Enrollments
                </h3>

                <p class="mt-2 text-gray-500">
                    Enroll or drop courses
                </p>

            </a>

            {{-- Results --}}
            <a href="{{ route('student.results') }}"
               class="group bg-white rounded-2xl border border-gray-200 shadow-sm p-6 hover:shadow-lg hover:-translate-y-1 transition duration-300">

                <div class="w-16 h-16 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center mb-5">
                    <x-heroicon-o-chart-bar class="w-8 h-8"/>
                </div>

                <h3 class="text-xl font-semibold text-gray-800 group-hover:text-indigo-600 transition">
                    My Results
                </h3>

                <p class="mt-2 text-gray-500">
                    View exam results &amp; grades
                </p>

            </a>

            {{-- Fees --}}
            <a href="{{ route('student.fees') }}"
               class="group bg-white rounded-2xl border border-gray-200 shadow-sm p-6 hover:shadow-lg hover:-translate-y-1 transition duration-300">

                <div class="w-16 h-16 rounded-full bg-rose-100 text-rose-700 flex items-center justify-center mb-5">
                    <x-heroicon-o-banknotes class="w-8 h-8"/>
                </div>

                <h3 class="text-xl font-semibold text-gray-800 group-hover:text-indigo-600 transition">
                    My Fees
                </h3>

                <p class="mt-2 text-gray-500">
                    Check fee status
                </p>

            </a>

        </div>

    </div>
</x-app-layout>