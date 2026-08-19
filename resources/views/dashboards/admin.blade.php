<x-app-layout>
    <x-slot name="header">
        Admin Dashboard
    </x-slot>

    <div class="p-6 max-w-6xl mx-auto">

        <p class="mb-6 text-gray-600">
            Welcome back,
            <span class="font-semibold">{{ auth()->user()->name }}</span>.
            Select a module below to manage your university system.
        </p>

        @php
            $cards = [
                [
                    'title' => 'Departments',
                    'desc' => 'Manage academic departments',
                    'route' => 'admin.departments.index',
                    'color' => 'bg-blue-100 text-blue-700',
                    'icon' => 'building',
                ],
                [
                    'title' => 'Faculty',
                    'desc' => 'Manage faculty members',
                    'route' => 'admin.faculty.index',
                    'color' => 'bg-purple-100 text-purple-700',
                    'icon' => 'faculty',
                ],
                [
                    'title' => 'Students',
                    'desc' => 'Manage student records',
                    'route' => 'admin.students.index',
                    'color' => 'bg-green-100 text-green-700',
                    'icon' => 'students',
                ],
                [
                    'title' => 'Courses',
                    'desc' => 'Manage courses & assign faculty',
                    'route' => 'admin.courses.index',
                    'color' => 'bg-amber-100 text-amber-700',
                    'icon' => 'courses',
                ],
                [
                    'title' => 'Fee Management',
                    'desc' => 'Track & manage student fees',
                    'route' => 'admin.fees.index',
                    'color' => 'bg-rose-100 text-rose-700',
                    'icon' => 'fees',
                ],
                [
                    'title' => 'Timetable',
                    'desc' => 'Manage class schedules',
                    'route' => 'admin.timetables.index',
                    'color' => 'bg-cyan-100 text-cyan-700',
                    'icon' => 'calendar',
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

            @foreach($cards as $card)

                <a href="{{ route($card['route']) }}"
                   class="group bg-white rounded-2xl border border-gray-200 shadow-md px-6 py-8 min-h-[280px] hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

                    <div class="w-20 h-20 rounded-full {{ $card['color'] }} flex items-center justify-center mb-6">

                        @switch($card['icon'])

                            @case('building')
                                <x-heroicon-o-building-office-2 class="w-10 h-10"/>
                                @break

                            @case('faculty')
                                <x-heroicon-o-user-group class="w-10 h-10"/>
                                @break

                            @case('students')
                                <x-heroicon-o-academic-cap class="w-10 h-10"/>
                                @break

                            @case('courses')
                                <x-heroicon-o-book-open class="w-10 h-10"/>
                                @break

                            @case('fees')
                                <x-heroicon-o-banknotes class="w-10 h-10"/>
                                @break

                            @case('calendar')
                                <x-heroicon-o-calendar-days class="w-10 h-10"/>
                                @break

                        @endswitch

                    </div>

                    <h3 class="text-xl font-semibold text-gray-800 group-hover:text-indigo-600 transition">
                        {{ $card['title'] }}
                    </h3>

                    <p class="mt-3 text-gray-500">
                        {{ $card['desc'] }}
                    </p>

                </a>

            @endforeach

        </div>

    </div>

</x-app-layout>