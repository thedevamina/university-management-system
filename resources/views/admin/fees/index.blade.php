<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Fee Management</h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.fees.create') }}" class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded">
            + Add Fee Record
        </a>

        <table class="w-full bg-white shadow rounded">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3">Student</th>
                    <th class="p-3">Semester</th>
                    <th class="p-3">Amount</th>
                    <th class="p-3">Due Date</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fees as $fee)
                    <tr class="border-t">
                        <td class="p-3">{{ $fee->student->user->name }} ({{ $fee->student->roll_no }})</td>
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
                        <td class="p-3 space-x-2">
                            @if($fee->status !== 'paid')
                                <form action="{{ route('admin.fees.markPaid', $fee) }}" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-green-600">Mark Paid</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.fees.destroy', $fee) }}" method="POST" class="inline" onsubmit="return confirm('Delete this fee record?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td class="p-3" colspan="6">No fee records yet.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $fees->links() }}</div>
    </div>
</x-app-layout>