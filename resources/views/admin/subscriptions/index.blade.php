<x-app-layout>
    <x-slot name="header">Student Subscriptions</x-slot>

    <div class="p-6 max-w-6xl mx-auto">

        <table class="w-full bg-white shadow rounded text-sm">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3">Student</th>
                    <th class="p-3">Amount</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Next Billing</th>
                    <th class="p-3">Stripe Subscription ID</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscriptions as $sub)
                    <tr class="border-t">
                        <td class="p-3">{{ $sub->student->user->name }} ({{ $sub->student->roll_no }})</td>
                        <td class="p-3">${{ number_format($sub->amount, 2) }}</td>
                        <td class="p-3">
                            <span @class([
                                'px-2 py-1 rounded text-xs',
                                'bg-green-100 text-green-800' => $sub->status === 'active',
                                'bg-red-100 text-red-800' => $sub->status === 'past_due',
                                'bg-gray-100 text-gray-800' => $sub->status === 'canceled',
                                'bg-yellow-100 text-yellow-800' => $sub->status === 'incomplete',
                            ])>
                                {{ ucfirst(str_replace('_', ' ', $sub->status)) }}
                            </span>
                        </td>
                        <td class="p-3">{{ $sub->current_period_end?->format('d M Y') ?? '—' }}</td>
                        <td class="p-3 font-mono text-xs">{{ $sub->stripe_subscription_id ?? '—' }}</td>
                    </tr>
                @empty
                    <tr><td class="p-3" colspan="5">No subscriptions yet.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $subscriptions->links() }}</div>
    </div>
</x-app-layout>