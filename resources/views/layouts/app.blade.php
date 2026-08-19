<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'University') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50">
    <div class="min-h-screen flex">

        {{-- Sidebar --}}
        <aside class="w-64 bg-slate-900 text-slate-300 flex-shrink-0 hidden md:flex md:flex-col">
            <div class="h-16 flex items-center px-6 border-b border-white/10">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-white font-bold tracking-tight">
                    <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-sm">🎓</span>
                    UniSys
                </a>
            </div>

            <nav class="flex-1 px-3 py-5 space-y-0.5 overflow-y-auto">
                @php $user = auth()->user(); @endphp

                @if($user->isAdmin())
                    <p class="px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500 mt-1 mb-2">Admin</p>
                    <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="home">Dashboard</x-sidebar-link>
                    <x-sidebar-link :href="route('admin.departments.index')" :active="request()->routeIs('admin.departments.*')" icon="building">Departments</x-sidebar-link>
                    <x-sidebar-link :href="route('admin.faculty.index')" :active="request()->routeIs('admin.faculty.*')" icon="users">Faculty</x-sidebar-link>
                    <x-sidebar-link :href="route('admin.students.index')" :active="request()->routeIs('admin.students.*')" icon="user">Students</x-sidebar-link>
                    <x-sidebar-link :href="route('admin.courses.index')" :active="request()->routeIs('admin.courses.*')" icon="book">Courses</x-sidebar-link>
                    <x-sidebar-link :href="route('admin.fees.index')" :active="request()->routeIs('admin.fees.*')" icon="cash">Fees</x-sidebar-link>
                    <x-sidebar-link :href="route('admin.timetables.index')" :active="request()->routeIs('admin.timetables.*')" icon="calendar">Timetable</x-sidebar-link>
                    @if(\Illuminate\Support\Facades\Route::has('admin.webhook-events.index'))
                        <x-sidebar-link :href="route('admin.webhook-events.index')" :active="request()->routeIs('admin.webhook-events.*')" icon="check">Webhook Logs</x-sidebar-link>
                    @endif
                    @if(\Illuminate\Support\Facades\Route::has('admin.subscriptions.index'))
                        <x-sidebar-link :href="route('admin.subscriptions.index')" :active="request()->routeIs('admin.subscriptions.*')" icon="cash">Subscriptions</x-sidebar-link>
                    @endif
                @elseif($user->isFaculty())
                    <p class="px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500 mt-1 mb-2">Faculty</p>
                    <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="home">Dashboard</x-sidebar-link>
                    <x-sidebar-link :href="route('faculty.attendance.create')" :active="request()->routeIs('faculty.attendance.*')" icon="check">Attendance</x-sidebar-link>
                    <x-sidebar-link :href="route('faculty.exams.index')" :active="request()->routeIs('faculty.exams.*')" icon="book">Exams & Results</x-sidebar-link>
                @else
                    <p class="px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500 mt-1 mb-2">Student</p>
                    <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="home">Dashboard</x-sidebar-link>
                    <x-sidebar-link :href="route('student.enrollments.index')" :active="request()->routeIs('student.enrollments.*')" icon="book">Enrollments</x-sidebar-link>
                    <x-sidebar-link :href="route('student.results')" :active="request()->routeIs('student.results')" icon="chart">Results</x-sidebar-link>
                    <x-sidebar-link :href="route('student.fees')" :active="request()->routeIs('student.fees')" icon="cash">Fees</x-sidebar-link>
                    @if(\Illuminate\Support\Facades\Route::has('student.subscription'))
                        <x-sidebar-link :href="route('student.subscription')" :active="request()->routeIs('student.subscription*')" icon="cash">Subscription</x-sidebar-link>
                    @endif
                @endif
            </nav>

            <div class="p-3 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:bg-white/5 hover:text-white text-sm transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Log Out
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main content --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- Top bar --}}
            <header class="h-16 bg-white/80 backdrop-blur border-b border-slate-200 flex items-center justify-between px-6 sticky top-0 z-10">
                <div>
                    @isset($header)
                        <div class="font-semibold text-lg text-slate-800">{{ $header }}</div>
                    @endisset
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-indigo-700 text-white flex items-center justify-center text-sm font-semibold shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                    <div class="leading-tight">
                        <div class="text-sm font-medium text-slate-700">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-slate-400 capitalize">{{ auth()->user()->role }}</div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>