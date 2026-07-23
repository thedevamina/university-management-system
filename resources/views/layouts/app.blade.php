<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'University') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex">

        {{-- Sidebar --}}
        <aside class="w-64 bg-slate-900 text-slate-200 flex-shrink-0 hidden md:flex md:flex-col">
            <div class="h-16 flex items-center px-6 border-b border-slate-800">
                <a href="{{ route('dashboard') }}" class="text-white font-bold text-lg tracking-wide">
                    🎓 UniSys
                </a>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                @php $user = auth()->user(); @endphp

                @if($user->isAdmin())
                    <p class="px-3 text-xs uppercase text-slate-500 mt-2 mb-1">Admin</p>
                    <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="home">Dashboard</x-sidebar-link>
                    <x-sidebar-link :href="route('admin.departments.index')" :active="request()->routeIs('admin.departments.*')" icon="building">Departments</x-sidebar-link>
                    <x-sidebar-link :href="route('admin.faculty.index')" :active="request()->routeIs('admin.faculty.*')" icon="users">Faculty</x-sidebar-link>
                    <x-sidebar-link :href="route('admin.students.index')" :active="request()->routeIs('admin.students.*')" icon="user">Students</x-sidebar-link>
                    <x-sidebar-link :href="route('admin.courses.index')" :active="request()->routeIs('admin.courses.*')" icon="book">Courses</x-sidebar-link>
                    <x-sidebar-link :href="route('admin.fees.index')" :active="request()->routeIs('admin.fees.*')" icon="cash">Fees</x-sidebar-link>
                    <x-sidebar-link :href="route('admin.timetables.index')" :active="request()->routeIs('admin.timetables.*')" icon="calendar">Timetable</x-sidebar-link>
                @elseif($user->isFaculty())
                    <p class="px-3 text-xs uppercase text-slate-500 mt-2 mb-1">Faculty</p>
                    <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="home">Dashboard</x-sidebar-link>
                    <x-sidebar-link :href="route('faculty.attendance.create')" :active="request()->routeIs('faculty.attendance.*')" icon="check">Attendance</x-sidebar-link>
                    <x-sidebar-link :href="route('faculty.exams.index')" :active="request()->routeIs('faculty.exams.*')" icon="book">Exams & Results</x-sidebar-link>
                @else
                    <p class="px-3 text-xs uppercase text-slate-500 mt-2 mb-1">Student</p>
                    <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="home">Dashboard</x-sidebar-link>
                    <x-sidebar-link :href="route('student.enrollments.index')" :active="request()->routeIs('student.enrollments.*')" icon="book">Enrollments</x-sidebar-link>
                    <x-sidebar-link :href="route('student.results')" :active="request()->routeIs('student.results')" icon="chart">Results</x-sidebar-link>
                    <x-sidebar-link :href="route('student.fees')" :active="request()->routeIs('student.fees')" icon="cash">Fees</x-sidebar-link>
                @endif
            </nav>

            <div class="p-4 border-t border-slate-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white text-sm">
                        ⏻ Log Out
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main content --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- Top bar --}}
            <header class="h-16 bg-white border-b flex items-center justify-between px-6">
                <div>
                    @isset($header)
                        <div class="font-semibold text-lg text-gray-800">{{ $header }}</div>
                    @endisset
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center text-sm font-semibold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                    <span class="text-sm text-gray-700">{{ auth()->user()->name }}</span>
                    <span class="text-xs px-2 py-0.5 rounded-full bg-gray-100 text-gray-500 capitalize">{{ auth()->user()->role }}</span>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>