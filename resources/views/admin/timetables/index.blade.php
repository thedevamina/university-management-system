<x-app-layout>
    <x-slot name="header">Timetable</x-slot>

    <div class="p-6 max-w-6xl mx-auto">

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded text-sm">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.timetables.create') }}" class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-500">
            + Add Timetable Entry
        </a>

        @php
            $days = ['Mon','Tue','Wed','Thu','Fri','Sat'];
            $grouped = $timetables->groupBy('day');
            $colors = ['from-blue-500 to-blue-700','from-amber-400 to-amber-600','from-indigo-500 to-indigo-700','from-emerald-500 to-emerald-700','from-rose-500 to-rose-700'];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($days as $day)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-slate-800 text-white text-sm font-medium text-center py-2">{{ $day }}</div>
                    <div class="p-3 space-y-3 min-h-[120px]">
                        @forelse(($grouped[$day] ?? []) as $tt)
                            <div class="rounded-lg overflow-hidden border border-gray-100">
                                <div class="bg-gradient-to-br {{ $colors[$tt->course_id % count($colors)] }} px-3 py-2">
                                    <p class="text-white text-xs font-medium">{{ $tt->start_time }} - {{ $tt->end_time }}</p>
                                </div>
                                <div class="p-2">
                                    <p class="text-sm font-medium text-gray-800">{{ $tt->course->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $tt->faculty->user->name }}</p>
                                    <p class="text-xs text-gray-400">Room {{ $tt->room }}</p>
                                    <div class="flex gap-2 mt-2">
                                        <a href="{{ route('admin.timetables.edit', $tt) }}" class="text-xs text-blue-600">Edit</a>
                                        <form action="{{ route('admin.timetables.destroy', $tt) }}" method="POST" onsubmit="return confirm('Delete?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-xs text-red-600">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-gray-300 text-center pt-6">No classes</p>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">{{ $timetables->links() }}</div>
    </div>
</x-app-layout>