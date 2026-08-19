<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Webhook Events
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6">

        <div class="bg-white shadow rounded-lg overflow-hidden">

            <table class="w-full text-sm">

                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left p-4">Event Type</th>
                        <th class="text-left p-4">Processed</th>
                        <th class="text-left p-4">Received At</th>
                        <th class="text-left p-4">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($events as $event)

                        <tr class="border-t">

                            <td class="p-4">
                                {{ $event->type }}
                            </td>

                            <td class="p-4">
                                @if($event->processed)
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded">
                                        Processed
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded">
                                        Pending
                                    </span>
                                @endif
                            </td>

                            <td class="p-4">
                                {{ $event->created_at->format('d M Y, h:i A') }}
                            </td>

                            <td class="p-4">
                                <a
                                    href="{{ route('admin.webhook-events.show', $event) }}"
                                    class="text-blue-600 hover:underline"
                                >
                                    View Details
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500">
                                No webhook events found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>