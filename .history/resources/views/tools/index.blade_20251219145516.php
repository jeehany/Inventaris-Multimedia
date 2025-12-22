<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Daftar Inventaris Alat') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow-sm">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Filter Section --}}
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                        <form action="{{ route('tools.index') }}" method="GET" class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
                            
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Alat..." class="border-gray-300 rounded-md shadow-sm text-sm">
                            
                            <select name="category_id" class="border-gray-300 rounded-md shadow-sm text-sm">
                                <option value="">- Semua Kategori -</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->category_name }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-sm">Filter</button>
                            @if(request()->has('search') || request()->has('category_id'))
                                <a href="{{ route('tools.index') }}" class="px-4 py-2 text-gray-500 border rounded-md text-sm text-center">Reset</a>
                            @endif
                        </form>

                        <a href="{{ route('tools.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow-sm text-sm w-full md:w-auto text-center">+ Tambah Alat</a>
                    </div>

                    {{-- Tabel Data --}}
                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full table-auto text-sm text-left">
                            <thead class="bg-gray-50 text-gray-600 uppercase font-medium">
                                <tr>
                                    <th class="px-4 py-3 text-center">No</th>
                                    <th class="px-4 py-3">Nama Alat</th>
                                    <th class="px-4 py-3">Kategori</th>
                                    <th class="px-4 py-3 text-center">Kondisi</th>
                                    <th class="px-4 py-3 text-center">Status</th>
                                    <th class="px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($tools as $index => $tool)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-center">{{ $tools->firstItem() + $index }}</td>
                                        <td class="px-4 py-3 font-bold text-gray-800">{{ $tool->tool_name }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $tool->category->category_name ?? '-' }}</td>
                                        
                                        <td class="px-4 py-3 text-center">
                                            @if($tool->current_condition == 'Baik' || $tool->current_condition == 'good')
                                                <span class="text-green-600 font-bold text-xs bg-green-100 px-2 py-1 rounded">Baik</span>
                                            @else
                                                <span class="text-red-600 font-bold text-xs bg-red-100 px-2 py-1 rounded">Rusak</span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-3 text-center">
                                            @if($tool->availability_status == 'available')
                                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">Tersedia</span>
                                            @elseif($tool->availability_status == 'borrowed')
                                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Dipinjam</span>
                                            @else
                                                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">Maintenance</span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-3 text-center flex justify-center gap-2">
                                            <a href="{{ route('tools.edit', $tool->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-1 rounded">Edit</a>
                                            <form action="{{ route('tools.destroy', $tool->id) }}" method="POST" onsubmit="return confirm('Hapus alat ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 p-1 rounded">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center py-6 text-gray-500">Alat tidak ditemukan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $tools->links() }}</div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>