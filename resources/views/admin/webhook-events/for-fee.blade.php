<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Webhook Logs — {{ $fee->student->user->name }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6">

        <a href="{{ route('admin.fees.index') }}"
           class="text-indigo-600 hover:underline">
            ← Back
        </a>

        <div class="mt-6 bg-white shadow rounded-lg">

            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-semibold">
                    Webhook Categories
                </h3>
            </div>

            <table class="w-full">

                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Type</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Action</th>
                    </tr>
                </thead>

                <tbody>

                    {{-- Payment --}}
                    @if($payment)
                    <tr class="border-t">
                        <td class="p-3 font-semibold">Payment</td>

                        <td class="p-3">
                            @if($payment->status=='paid')
                                <span class="px-2 py-1 rounded bg-green-200 text-green-800">Paid</span>
                            @elseif($payment->status=='processing')
                                <span class="px-2 py-1 rounded bg-yellow-200 text-yellow-800">Processing</span>
                            @else
                                <span class="px-2 py-1 rounded bg-red-200 text-red-800">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            @endif
                        </td>

                        <td class="p-3">
                            <a href="{{ route('admin.webhook-events.payment',$payment) }}"
                               class="text-blue-600 hover:underline">
                                View
                            </a>
                        </td>
                    </tr>
                    @endif

                    {{-- Subscription --}}
                    @if($subscription)
                    <tr class="border-t">
                        <td class="p-3 font-semibold">Subscription</td>

                        <td class="p-3">
                            @if($subscription->status=='active')
                                <span class="px-2 py-1 rounded bg-green-200 text-green-800">Active</span>
                            @elseif($subscription->status=='past_due')
                                <span class="px-2 py-1 rounded bg-red-200 text-red-800">Past Due</span>
                            @else
                                <span class="px-2 py-1 rounded bg-yellow-200 text-yellow-800">
                                    {{ ucfirst($subscription->status) }}
                                </span>
                            @endif
                        </td>

                        <td class="p-3">
                            <a href="{{ route('admin.webhook-events.subscription',$subscription) }}"
                               class="text-blue-600 hover:underline">
                                View
                            </a>
                        </td>
                    </tr>
                    @endif

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>