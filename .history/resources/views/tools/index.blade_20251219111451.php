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
                                    <td class="border px-4 py-2 text-center" x-data="{ showModal: false }">
                                        <div class="flex justify-center items-center gap-4">
                                            
                                            <button @click="showModal = true" class="text-blue-600 hover:underline cursor-pointer">
                                                Edit
                                            </button>

                                            <form action="{{ route('tools.destroy', $tool->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline font-semibold">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>

                                        <div x-show="showModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center" 
                                            style="display: none;">
                                            
                                            <div class="relative bg-white rounded-lg shadow-xl p-8 w-full max-w-md mx-4">
                                                
                                                <div class="flex justify-between items-center mb-4">
                                                    <h3 class="text-xl font-bold text-gray-900">Edit Alat: {{ $tool->tool_code }}</h3>
                                                    <button @click="showModal = false" class="text-gray-500 hover:text-gray-700 font-bold text-xl">&times;</button>
                                                </div>

                                                <form action="{{ route('tools.update', $tool->id) }}" method="POST" class="text-left">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="mb-4">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Alat</label>
                                                        <input type="text" name="tool_name" value="{{ $tool->tool_name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                    </div>

                                                    <div class="mb-4">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                                                        <select name="category_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                            @foreach($categories as $cat)
                                                                <option value="{{ $cat->id }}" {{ $tool->category_id == $cat->id ? 'selected' : '' }}>
                                                                    {{ $cat->category_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-4">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Kondisi</label>
                                                        <input type="text" name="current_condition" value="{{ $tool->current_condition }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                    </div>
                                                    
                                                    <div class="mb-4">
                                                        <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                                                        <select name="availability_status" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                            <option value="available" {{ $tool->availability_status == 'available' ? 'selected' : '' }}>
                                                                Tersedia (Available)
                                                            </option>
                                                            <option value="borrowed" {{ $tool->availability_status == 'borrowed' ? 'selected' : '' }}>
                                                                Sedang Dipinjam (Borrowed)
                                                            </option>
                                                            <option value="maintenance" {{ $tool->availability_status == 'maintenance' ? 'selected' : '' }}>
                                                                Dalam Perbaikan (Maintenance)
                                                            </option>
                                                            <option value="missing" {{ $tool->availability_status == 'missing' ? 'selected' : '' }}>
                                                                Hilang (Missing)
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <input type="hidden" name="tool_code" value="{{ $tool->tool_code }}">

                                                    <div class="flex justify-end gap-2 mt-6">
                                                        <button type="button" @click="showModal = false" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                                            Batal
                                                        </button>
                                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                            Simpan Perubahan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
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