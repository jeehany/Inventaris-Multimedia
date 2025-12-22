<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Inventaris Multimedia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-10">
                <div class="p-6 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-bold mb-4 text-indigo-700">📂 Kategori Alat Multimedia</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <form action="{{ route('categories.store') }}" method="POST" class="flex gap-2">
                                @csrf
                                <input type="text" name="name" placeholder="Nama Kategori Baru (mis: Drone, Lighting)" 
                                    class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded whitespace-nowrap">
                                    + Simpan
                                </button>
                            </form>
                            <p class="text-xs text-gray-500 mt-2">* Tambahkan kategori sebelum input alat baru.</p>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            @forelse($categories as $cat)
                                <span class="bg-indigo-100 text-indigo-800 text-sm font-medium px-3 py-1 rounded-full flex items-center">
                                    {{ $cat->name }}
                                    <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" class="ml-2 inline" onsubmit="return confirm('Hapus kategori ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-indigo-400 hover:text-red-600 font-bold">×</button>
                                    </form>
                                </span>
                            @empty
                                <span class="text-gray-400 italic">Belum ada kategori.</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-800">📹 Daftar Semua Alat</h3>
                        <a href="{{ route('tools.create') }}" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded shadow">
                            + Tambah Alat Baru
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="table-auto w-full border-collapse border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-4 py-2 text-left">No</th>
                                    <th class="border px-4 py-2 text-left">Kode</th>
                                    <th class="border px-4 py-2 text-left">Nama Alat</th>
                                    <th class="border px-4 py-2 text-left">Kategori</th> <th class="border px-4 py-2 text-left">Kondisi</th>
                                    <th class="border px-4 py-2 text-center">Status</th>
                                    <th class="border px-4 py-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tools as $index => $tool)
                                <tr>
                                    <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                    <td class="border px-4 py-2 font-mono text-blue-600">{{ $tool->tool_code }}</td>
                                    <td class="border px-4 py-2 font-semibold">{{ $tool->tool_name }}</td>
                                    <td class="border px-4 py-2">
                                        <span class="bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded">
                                            {{ $tool->category->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="border px-4 py-2">{{ $tool->current_condition }}</td>
                                    <td class="border px-4 py-2 text-center">
                                        @if($tool->availability_status == 'available')
                                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded">Tersedia</span>
                                        @elseif($tool->availability_status == 'borrowed')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-1 rounded">Dipinjam</span>
                                        @elseif($tool->availability_status == 'maintenance')
                                            <span class="bg-orange-100 text-orange-800 text-xs font-bold px-2 py-1 rounded">Perbaikan</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-bold px-2 py-1 rounded">Hilang</span>
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2 text-center">
                                        <a href="#" class="text-blue-500 hover:text-blue-700">Edit</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="border px-4 py-4 text-center text-gray-500">
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
    </div>
</x-app-layout>