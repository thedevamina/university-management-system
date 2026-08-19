<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                Webhook Details
            </h2>

            <span class="px-3 py-1 rounded-full text-xs font-semibold
                @if(str_contains($webhookEvent->type,'succeeded'))
                    bg-green-100 text-green-700
                @elseif(str_contains($webhookEvent->type,'failed'))
                    bg-red-100 text-red-700
                @elseif(str_contains($webhookEvent->type,'processing'))
                    bg-yellow-100 text-yellow-700
                @else
                    bg-blue-100 text-blue-700
                @endif
            ">
                {{ $webhookEvent->type }}
            </span>
        </div>
    </x-slot>


    @php
        $payload = $webhookEvent->payload;
        $object = $payload['data']['object'] ?? [];
    @endphp


    <div class="max-w-6xl mx-auto py-6">

        <a href="{{ url()->previous() }}"
           class="text-indigo-600 hover:underline">
            ← Back
        </a>


        {{-- Webhook Information --}}
        <div class="mt-6 bg-white shadow rounded-xl p-6">

            <h3 class="text-lg font-bold mb-5">
                Webhook Information
            </h3>


            <div class="overflow-hidden rounded-lg border">

                <table class="w-full text-sm">

                    <tr class="border-b">
                        <td class="font-semibold py-3 px-4 w-64 bg-gray-50">
                            Stripe Event ID
                        </td>
                        <td class="px-4 break-all">
                            {{ $webhookEvent->stripe_event_id }}
                        </td>
                    </tr>


                    <tr class="border-b">
                        <td class="font-semibold py-3 px-4 bg-gray-50">
                            Event Type
                        </td>

                        <td class="px-4">
                            {{ $webhookEvent->type }}
                        </td>
                    </tr>


                    <tr class="border-b">
                        <td class="font-semibold py-3 px-4 bg-gray-50">
                            Processed
                        </td>

                        <td class="px-4">
                            @if($webhookEvent->processed)

                                <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700">
                                    Processed
                                </span>

                            @else

                                <span class="px-3 py-1 rounded-full text-xs bg-gray-100 text-gray-700">
                                    Pending
                                </span>

                            @endif
                        </td>
                    </tr>


                    <tr class="border-b">
                        <td class="font-semibold py-3 px-4 bg-gray-50">
                            Error Message
                        </td>

                        <td class="px-4">
                            {{ $webhookEvent->error_message ?? 'None' }}
                        </td>
                    </tr>


                    <tr>
                        <td class="font-semibold py-3 px-4 bg-gray-50">
                            Received At
                        </td>

                        <td class="px-4">
                            {{ $webhookEvent->created_at->format('d M Y, h:i A') }}
                        </td>
                    </tr>


                </table>

            </div>

        </div>



        {{-- Checkout Session --}}
        @if(str_contains($webhookEvent->type,'checkout.session'))

        <div class="mt-6 bg-white shadow rounded-xl p-6">

            <h3 class="text-lg font-bold mb-5">
                Checkout Session Details
            </h3>


            <table class="w-full text-sm border rounded-lg overflow-hidden">


                <tr class="border-b">
                    <td class="font-semibold py-3 px-4 w-64 bg-gray-50">
                        Session ID
                    </td>

                    <td class="px-4 break-all">
                        {{ $object['id'] ?? 'N/A' }}
                    </td>
                </tr>


                <tr class="border-b">
                    <td class="font-semibold py-3 px-4 bg-gray-50">
                        Payment Intent
                    </td>

                    <td class="px-4 break-all">
                        {{ $object['payment_intent'] ?? 'N/A' }}
                    </td>
                </tr>


                <tr class="border-b">
                    <td class="font-semibold py-3 px-4 bg-gray-50">
                        Payment Status
                    </td>

                    <td class="px-4">
                        {{ $object['payment_status'] ?? 'N/A' }}
                    </td>
                </tr>


                <tr>
                    <td class="font-semibold py-3 px-4 bg-gray-50">
                        Amount
                    </td>

                    <td class="px-4">
                        ${{ number_format(($object['amount_total'] ?? 0) / 100, 2) }}
                        {{ strtoupper($object['currency'] ?? '') }}
                    </td>
                </tr>


            </table>

        </div>

        @endif




        {{-- Payment Intent --}}
        @if(str_contains($webhookEvent->type,'payment_intent'))


        <div class="mt-6 bg-white shadow rounded-xl p-6">

            <h3 class="text-lg font-bold mb-5">
                Payment Intent Details
            </h3>


            <table class="w-full text-sm">


                <tr class="border-b">

                    <td class="font-semibold py-3 px-4 w-64 bg-gray-50">
                        Payment Intent ID
                    </td>

                    <td class="px-4 break-all">
                        {{ $object['id'] ?? 'N/A' }}
                    </td>

                </tr>



                <tr class="border-b">
    <td class="font-semibold py-3 px-4 bg-gray-50">
        Status
    </td>

    <td class="px-4">

        @if($webhookEvent->type === 'payment_intent.succeeded' || $webhookEvent->type === 'checkout.session.completed')

            <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700">
                Success
            </span>


        @elseif($webhookEvent->type === 'payment_intent.payment_failed')

            <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-700">
                Failed
            </span>


        @elseif($webhookEvent->type === 'payment_intent.processing')

            <span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">
                Processing
            </span>


        @else

            <span class="px-3 py-1 rounded-full text-xs bg-gray-100 text-gray-700">
                {{ $webhookEvent->processed ? 'Completed' : 'Pending' }}
            </span>


        @endif

    </td>
</tr>



                <tr class="border-b">

                    <td class="font-semibold py-3 px-4 bg-gray-50">
                        Amount
                    </td>

                    <td class="px-4">

                        ${{ number_format(($object['amount'] ?? 0) / 100, 2) }}
                        {{ strtoupper($object['currency'] ?? '') }}

                    </td>

                </tr>



                <tr>

                    <td class="font-semibold py-3 px-4 bg-gray-50">
                        Payment Method
                    </td>

                    <td class="px-4">
                        {{ $object['payment_method'] ?? 'N/A' }}
                    </td>

                </tr>


            </table>


        </div>


        @endif



{{-- Related Webhook Events --}}

<div class="mt-6 bg-white shadow rounded-lg p-6">

    <h3 class="text-lg font-bold mb-4">
        Related Payment Webhook Events
    </h3>


    <table class="w-full text-sm">

        <thead class="bg-gray-100">

            <tr>
                <th class="p-3 text-left">
                    Event
                </th>

                <th class="p-3 text-left">
                    Status
                </th>

                <th class="p-3 text-left">
                    Time
                </th>
            </tr>

        </thead>


        <tbody>

        @forelse($relatedEvents as $event)

            <tr class="border-t">

                <td class="p-3">
                    {{ $event->type }}
                </td>


                <td class="p-3">

                    @if($event->processed)

                        <span class="px-2 py-1 bg-green-200 rounded">
                            Success
                        </span>

                    @else

                        <span class="px-2 py-1 bg-red-200 rounded">
                            Failed
                        </span>

                    @endif

                </td>


                <td class="p-3">
                    {{ $event->created_at->diffForHumans() }}
                </td>

            </tr>

        @empty

            <tr>
                <td colspan="3" class="p-4 text-center">
                    No related events found
                </td>
            </tr>

        @endforelse


        </tbody>

    </table>

</div>

@if($relatedEvents->count())

<div class="mt-6 bg-white shadow rounded-lg p-6">

<h3 class="text-lg font-bold mb-4">
Related Webhook Events
</h3>


<table class="w-full text-sm">

<thead>
<tr class="border-b">

<th class="text-left py-2">
Event
</th>

<th class="text-left">
Status
</th>

<th class="text-left">
Time
</th>

<th>
Action
</th>

</tr>
</thead>


<tbody>

@foreach($relatedEvents as $event)

<tr class="border-b">

<td class="py-3">
{{ $event->type }}
</td>


<td>

@if($event->processed)

<span class="px-2 py-1 bg-green-200 rounded">
Success
</span>

@else

<span class="px-2 py-1 bg-red-200 rounded">
Failed
</span>

@endif

</td>


<td>
{{ $event->created_at->diffForHumans() }}
</td>


<td>

<a href="{{ route('admin.webhook-events.show',$event) }}"
class="text-blue-600">
View
</a>

</td>


</tr>


@endforeach

</tbody>

</table>

</div>

@endif

        {{-- Raw Payload --}}

        <div class="mt-6 bg-white shadow rounded-xl p-6">


            <h3 class="text-lg font-bold mb-4">
                Raw Webhook Payload
            </h3>


            <details class="bg-gray-900 rounded-lg">


                <summary class="cursor-pointer text-white p-4 font-semibold">
                    Click to view JSON payload
                </summary>


                <pre class="text-green-400 p-5 overflow-x-auto text-xs">{{ json_encode($webhookEvent->payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>


            </details>


        </div>



    </div>


</x-app-layout>