<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Inventaris Alat') }}
            </h2>
            <a href="{{ route('categories.index') }}" class="text-sm text-indigo-600 hover:underline font-bold">
                Kelola Kategori &rarr;
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('tools.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + Tambah Alat Baru
                        </a>
                    </div>

                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-4 py-2">No</th>
                                <th class="border px-4 py-2">Kode</th>
                                <th class="border px-4 py-2">Nama Alat</th>
                                <th class="border px-4 py-2">Kategori</th>
                                <th class="border px-4 py-2">Kondisi</th>
                                <th class="border px-4 py-2 text-center">Status</th>
                                <th class="border px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tools as $tool)
                                <tr>
                                    <td class="border px-4 py-2 text-center">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2 font-mono text-blue-600">{{ $tool->tool_code }}</td>
                                    <td class="border px-4 py-2 font-semibold">{{ $tool->tool_name }}</td>
                                    <td class="border px-4 py-2">{{ $tool->category->category_name ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $tool->current_condition }}</td>
                                    <td class="border px-4 py-2 text-center">
                                        <span class="px-2 py-1 rounded text-xs font-bold 
                                            {{ $tool->availability_status == 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $tool->availability_status }}
                                        </span>
                                    </td>
                                    <td class="border px-4 py-2 text-center">
                                        <div class="flex justify-center items-center gap-4">
                                            
                                            <a href="{{ route('tools.edit', $tool->id) }}" class="text-blue-600 hover:underline">
                                                Edit
                                            </a>

                                            <form action="{{ route('tools.destroy', $tool->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus alat {{ $tool->tool_name }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline font-semibold">
                                                    Hapus
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="border px-4 py-4 text-center text-gray-500">
                                        Belum ada data alat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>