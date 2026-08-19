<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Subscription Timeline
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6">

        <a href="{{ url()->previous() }}"
           class="text-indigo-600 hover:underline">
            ← Back
        </a>

        {{-- Subscription Information --}}

        <div class="mt-6 bg-white rounded-lg shadow">

            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-semibold">
                    Subscription Information
                </h3>
            </div>

            <table class="w-full">

                <tr class="border-b">
                    <td class="p-3 font-semibold w-64">Subscription ID</td>
                    <td class="p-3">{{ $subscription->id }}</td>
                </tr>

                <tr class="border-b">
                    <td class="p-3 font-semibold">Status</td>
                    <td class="p-3">{{ ucfirst($subscription->status) }}</td>
                </tr>

                <tr class="border-b">
                    <td class="p-3 font-semibold">Amount</td>
                    <td class="p-3">
                        ${{ number_format($subscription->amount,2) }}
                    </td>
                </tr>

                <tr class="border-b">
                    <td class="p-3 font-semibold">Stripe Customer</td>
                    <td class="p-3">
                        {{ $subscription->stripe_customer_id }}
                    </td>
                </tr>

                <tr class="border-b">
                    <td class="p-3 font-semibold">Stripe Subscription</td>
                    <td class="p-3">
                        {{ $subscription->stripe_subscription_id }}
                    </td>
                </tr>

                <tr>
                    <td class="p-3 font-semibold">Current Period End</td>
                    <td class="p-3">
                        {{ optional($subscription->current_period_end)->format('d M Y H:i') ?? 'N/A' }}
                    </td>
                </tr>

            </table>

        </div>

        {{-- Timeline --}}

        <div class="mt-8 bg-white rounded-lg shadow">

            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-semibold">
                    Subscription Webhook Timeline
                </h3>
            </div>

            <table class="w-full">

                <thead class="bg-gray-100">

                    <tr>
                        <th class="p-3 text-left">Event</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Received</th>
                        <th class="p-3 text-left">Action</th>
                    </tr>

                </thead>

                <tbody>

                @forelse($events as $event)

                    <tr class="border-t">

                        <td class="p-3">
                            {{ $event->type }}
                        </td>

                        <td class="p-3">

                            @if($event->processed)

                                <span class="px-2 py-1 rounded bg-green-200 text-green-800">
                                    Success
                                </span>

                            @else

                                <span class="px-2 py-1 rounded bg-red-200 text-red-800">
                                    Failed
                                </span>

                            @endif

                        </td>

                        <td class="p-3">
                            {{ $event->created_at->diffForHumans() }}
                        </td>

                        <td class="p-3">

                            <a href="{{ route('admin.webhook-events.show',$event) }}"
                               class="text-blue-600 hover:underline">

                                View

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="4" class="p-5 text-center text-gray-500">
                            No subscription webhook events found.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>