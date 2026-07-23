<x-app-layout>
    <x-slot name="header">Admin Dashboard</x-slot>

    <div class="p-6 max-w-6xl mx-auto">
        <p class="mb-6 text-gray-600">Welcome back, <span class="font-medium">{{ auth()->user()->name }}</span>. Manage your university system below.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @php
                $cards = [
                    ['title' => 'Departments', 'desc' => 'Manage academic departments', 'route' => 'admin.departments.index', 'color' => 'bg-blue-100 text-blue-700', 'emoji' => '🏛️'],
                    ['title' => 'Faculty', 'desc' => 'Manage faculty members', 'route' => 'admin.faculty.index', 'color' => 'bg-purple-100 text-purple-700', 'emoji' => '👩‍🏫'],
                    ['title' => 'Students', 'desc' => 'Manage student records', 'route' => 'admin.students.index', 'color' => 'bg-green-100 text-green-700', 'emoji' => '🎓'],
                    ['title' => 'Courses', 'desc' => 'Manage courses & assign faculty', 'route' => 'admin.courses.index', 'color' => 'bg-amber-100 text-amber-700', 'emoji' => '📚'],
                    ['title' => 'Fee Management', 'desc' => 'Track & manage student fees', 'route' => 'admin.fees.index', 'color' => 'bg-rose-100 text-rose-700', 'emoji' => '💰'],
                    ['title' => 'Timetable', 'desc' => 'Manage class schedules', 'route' => 'admin.timetables.index', 'color' => 'bg-cyan-100 text-cyan-700', 'emoji' => '🗓️'],
                ];
            @endphp

            @foreach($cards as $card)
                <a href="{{ route($card['route']) }}" class="group bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-lg hover:-translate-y-0.5 transition">
                    <div class="w-11 h-11 rounded-lg {{ $card['color'] }} flex items-center justify-center text-xl mb-4">
                        {{ $card['emoji'] }}
                    </div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-indigo-600">{{ $card['title'] }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $card['desc'] }}</p>
                </a>
            @endforeach
        </div>
    </div>
</x-app-layout>