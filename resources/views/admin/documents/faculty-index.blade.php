<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 px-4">

        <h2 class="text-2xl font-bold mb-2">
            Documents – {{ $faculty->user->name }}
        </h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Upload Form --}}
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Upload Document</h3>

            <form action="{{ route('admin.faculty.documents.store', $faculty) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Select File (PDF, DOC, JPG, PNG — max 2MB)
                    </label>
                    <input type="file"
                           name="document"
                           class="block w-full border border-gray-300 rounded px-3 py-2">
                    @error('document')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Upload
                </button>
            </form>
        </div>

        {{-- Documents List --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Uploaded Documents</h3>

            @if($documents->isEmpty())
                <p class="text-gray-500">No documents uploaded yet.</p>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">File Name</th>
                            <th class="px-4 py-2">Uploaded At</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documents as $doc)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ Storage::url($doc->file_path) }}"
                                   target="_blank"
                                   class="text-blue-600 hover:underline">
                                    {{ $doc->file_name }}
                                </a>
                            </td>
                            <td class="px-4 py-2">
                                {{ $doc->created_at->format('d M Y') }}
                            </td>
                            <td class="px-4 py-2">
                                <form action="{{ route('admin.faculty.documents.destroy', [$faculty, $doc]) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:underline text-sm">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>
</x-app-layout>