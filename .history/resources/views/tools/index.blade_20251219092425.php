<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Inventaris Alat') }}
        </h2>
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
                                <th class="border px-4 py-2">Kode Alat</th>
                                <th class="border px-4 py-2">Nama Alat</th>
                                <th class="border px-4 py-2">Kondisi</th>
                                <th class="border px-4 py-2">Status</th>
                                <th class="border px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tools as $tool)
                                <tr>
                                    <td class="border px-4 py-2 text-center">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2">{{ $tool->tool_code }}</td>
                                    <td class="border px-4 py-2">{{ $tool->tool_name }}</td>
                                    <td class="border px-4 py-2">{{ $tool->current_condition }}</td>
                                    <td class="border px-4 py-2">{{ $tool->availability_status }}</td>
                                    <td class="border px-4 py-2 text-center">
                                        <a href="#" class="text-blue-600 hover:underline">Edit</a> | 
                                        <a href="#" class="text-red-600 hover:underline">Hapus</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="border px-4 py-2 text-center text-gray-500">
                                        Belum ada data alat. Silakan tambah data baru.
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