<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Fees</h2>
    </x-slot>
    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded text-sm">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded text-sm">{{ session('error') }}</div>
        @endif

        <table class="w-full bg-white shadow rounded">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3">Semester</th>
                    <th class="p-3">Amount</th>
                    <th class="p-3">Due Date</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fees as $fee)
                    <tr class="border-t">
                        <td class="p-3">{{ $fee->semester }}</td>
                        <td class="p-3">{{ number_format($fee->amount, 2) }}</td>
                        <td class="p-3">{{ $fee->due_date }}</td>
                        <td class="p-3">
                            <span @class([
                                'px-2 py-1 rounded text-sm',
                                'bg-green-100 text-green-800' => $fee->status === 'paid',
                                'bg-yellow-100 text-yellow-800' => $fee->status === 'unpaid',
                                'bg-red-100 text-red-800' => $fee->status === 'overdue',
                            ])>
                                {{ ucfirst($fee->status) }}
                            </span>
                        </td>
                       <td class="p-3">
    @if($fee->status !== 'paid')
        <a href="{{ route('student.payment.checkout', $fee) }}"
           class="inline-block px-3 py-1.5 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-500">
            Pay Now
        </a>
        <a href="{{ route('student.subscription.checkout', $fee) }}"
           class="inline-block px-3 py-1.5 bg-purple-600 text-white text-sm rounded-md hover:bg-purple-500 ml-2">
            Subscribe
        </a>
    @else
        <span class="text-sm text-gray-400">Paid</span>
    @endif
</td>
                      
                    </tr>
                @empty
                    <tr><td class="p-3" colspan="5">No fee records yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>