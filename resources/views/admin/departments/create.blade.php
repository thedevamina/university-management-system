<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Department</h2>
    </x-slot>

    <div class="py-6 max-w-lg mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('admin.departments.store') }}" method="POST" class="bg-white p-6 shadow rounded space-y-4">
            @csrf

            <div>
                <label class="block mb-1">Department Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded p-2">
                @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">Code</label>
                <input type="text" name="code" value="{{ old('code') }}" class="w-full border rounded p-2">
                @error('code') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
            <a href="{{ route('admin.departments.index') }}" class="ml-2 text-gray-600">Cancel</a>
        </form>
    </div>
</x-app-layout>