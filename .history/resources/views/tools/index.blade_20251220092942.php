<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Inventaris Alat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Pesan Sukses --}}
            @if (session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Header Atas (Pencarian & Tombol Tambah) --}}
                    <div class="flex justify-between items-center mb-6">
                        <form action="{{ route('tools.index') }}" method="GET" class="flex gap-2">
                            <input type="text" name="search" placeholder="Cari alat..." class="border-gray-300 rounded-md shadow-sm text-sm">
                            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm">Cari</button>
                        </form>
                        
                        {{-- Tombol ini mengarah ke HALAMAN BARU (create.blade.php) --}}
                        <a href="{{ route('tools.create') }}" class="bg-indigo-600 text-white font-bold py-2 px-4 rounded shadow-sm text-sm hover:bg-indigo-700">
                            + Tambah Alat
                        </a>
                    </div>

                    {{-- Tabel Data --}}
                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full table-auto text-sm text-left">
                            <thead class="bg-gray-50 text-gray-600 uppercase font-medium">
                                <tr>
                                    <th class="px-4 py-3 text-center">No</th>
                                    <th class="px-4 py-3">Nama Alat</th>
                                    <th class="px-4 py-3">Kategori</th>
                                    <th class="px-4 py-3">Kondisi</th>
                                    <th class="px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($tools as $index => $tool)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-center">{{ $tools->firstItem() + $index }}</td>
                                        <td class="px-4 py-3 font-bold">{{ $tool->tool_name }}</td>
                                        <td class="px-4 py-3">{{ $tool->category->category_name ?? '-' }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 rounded text-xs font-bold {{ $tool->current_condition == 'Baik' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $tool->current_condition }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center flex justify-center gap-2">
                                            
                                            {{-- TOMBOL EDIT (Memicu Popup) --}}
                                            <button onclick="document.getElementById('modal-edit-{{ $tool->id }}').classList.remove('hidden')" 
                                                class="text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded">
                                                Edit
                                            </button>

                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('tools.destroy', $tool->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1 rounded">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>

                                    {{-- ========================================== --}}
                                    {{-- MULAI POPUP EDIT (MODAL) --}}
                                    {{-- Kode ini tersembunyi (hidden) sampai tombol Edit diklik --}}
                                    {{-- ========================================== --}}
                                    <div id="modal-edit-{{ $tool->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                            
                                            {{-- Background Gelap --}}
                                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="document.getElementById('modal-edit-{{ $tool->id }}').classList.add('hidden')"></div>

                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                            {{-- Isi Modal --}}
                                            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                
                                                <form action="{{ route('tools.update', $tool->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    
                                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">Edit Alat: {{ $tool->tool_name }}</h3>
                                                        
                                                        {{-- Input Nama --}}
                                                        <div class="mb-4">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Alat</label>
                                                            <input type="text" name="tool_name" value="{{ $tool->tool_name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                        </div>

                                                        {{-- Input Kategori --}}
                                                        <div class="mb-4">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                                                            <select name="category_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight">
                                                                @foreach($categories as $cat)
                                                                    <option value="{{ $cat->id }}" {{ $tool->category_id == $cat->id ? 'selected' : '' }}>
                                                                        {{ $cat->category_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        {{-- Input Kondisi --}}
                                                        <div class="mb-4">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Kondisi</label>
                                                            <select name="current_condition" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight">
                                                                <option value="Baik" {{ $tool->current_condition == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                                <option value="Rusak" {{ $tool->current_condition == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                                            </select>
                                                        </div>

                                                        {{-- Input Status --}}
                                                        <div class="mb-4">
                                                            <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                                                            <select name="availability_status" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight">
                                                                <option value="available" {{ $tool->availability_status == 'available' ? 'selected' : '' }}>Tersedia</option>
                                                                <option value="borrowed" {{ $tool->availability_status == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                                                                <option value="maintenance" {{ $tool->availability_status == 'maintenance' ? 'selected' : '' }}>Perbaikan</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    {{-- Tombol Bawah Modal --}}
                                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                                            Update
                                                        </button>
                                                        <button type="button" onclick="document.getElementById('modal-edit-{{ $tool->id }}').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                            Batal
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- SELESAI MODAL --}}

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $tools->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>