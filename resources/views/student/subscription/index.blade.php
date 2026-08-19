<x-app-layout>
    <x-slot name="header">My Subscriptions</x-slot>

    <div class="p-6 max-w-2xl mx-auto">

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded text-sm">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded text-sm">{{ session('error') }}</div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

            @if(!$subscription)

                <h3 class="font-semibold text-lg text-gray-800 mb-2">No Active Subscription</h3>
                <p class="text-sm text-gray-500 mb-4">
                    You don't have a monthly subscription yet. Go to
                    <a href="{{ route('student.fees') }}" class="text-indigo-600 hover:underline">My Fees</a>
                    and click "Subscribe" on any fee to set up automatic monthly payments.
                </p>

            @else

                <h3 class="font-semibold text-lg text-gray-800 mb-4">Subscription Details</h3>

                <table class="w-full text-sm">
                    <tr class="border-b">
                        <td class="py-2 text-gray-500">Fee / Semester</td>
                        <td class="py-2">{{ $subscription->fee?->semester ?? '—' }}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 text-gray-500">Status</td>
                        <td class="py-2">
                            <span @class([
                                'px-2 py-1 rounded text-xs',
                                'bg-green-100 text-green-800' => $subscription->status === 'active',
                                'bg-red-100 text-red-800' => $subscription->status === 'past_due',
                                'bg-gray-100 text-gray-800' => $subscription->status === 'canceled',
                                'bg-yellow-100 text-yellow-800' => $subscription->status === 'incomplete',
                            ])>
                                {{ ucfirst(str_replace('_', ' ', $subscription->status)) }}
                            </span>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 text-gray-500">Monthly Amount</td>
                        <td class="py-2">${{ number_format($subscription->amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-gray-500">Next Billing Date</td>
                        <td class="py-2">
                            {{ $subscription->current_period_end?->format('d M Y') ?? '—' }}
                        </td>
                    </tr>
                </table>

                @if($subscription->status === 'past_due')
                    <div class="mt-4 p-3 bg-red-50 text-red-700 text-sm rounded">
                        Your last payment failed. Please update your payment method to avoid service interruption.
                    </div>
                @endif

            @endif
        </div>
    </div>
</x-app-layout>