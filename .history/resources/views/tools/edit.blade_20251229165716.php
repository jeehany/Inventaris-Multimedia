<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Alat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('tools.update', $tool->id) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- Wajib untuk Update --}}

                        <div class="grid grid-cols-1 gap-6">
                            
                            {{-- Kode Alat (Readonly - Tidak boleh diedit sembarangan) --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Kode Alat</label>
                                <input type="text" value="{{ $tool->tool_code }}" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                                <p class="text-xs text-gray-500 mt-1">Kode alat tidak dapat diubah.</p>
                            </div>

                            {{-- Kategori --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Kategori</label>
                                <input type="text" value="{{ $tool->category->category_name }}" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                                <p class="text-xs text-gray-500 mt-1">Kode alat tidak dapat diubah.</p>

                            
                            </div>

                            {{-- Nama Alat --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Nama Alat</label>
                                <input type="text" name="tool_name" value="{{ old('tool_name', $tool->tool_name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>

                            {{-- Merk / Tipe (BARU) --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Merk / Tipe</label>
                                <input type="text" name="brand" value="{{ old('brand', $tool->brand) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: Tekiro, Bosch">
                            </div>

                            {{-- Tanggal Perolehan (BARU - Bisa diedit jika salah input) --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Tanggal Perolehan</label>
                                <input type="date" name="purchase_date" 
                                       value="{{ old('purchase_date', $tool->purchase_date ? date('Y-m-d', strtotime($tool->purchase_date)) : '') }}" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            {{-- Kondisi --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Kondisi Fisik</label>
                                <select name="current_condition" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="Baik" {{ $tool->current_condition == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Rusak" {{ $tool->current_condition == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                </select>
                            </div>

                            {{-- Status Ketersediaan --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Status Ketersediaan</label>
                                <select name="availability_status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="available" {{ $tool->availability_status == 'available' ? 'selected' : '' }}>Tersedia (Available)</option>
                                    <option value="borrowed" {{ $tool->availability_status == 'borrowed' ? 'selected' : '' }}>Sedang Dipinjam</option>
                                    <option value="maintenance" {{ $tool->availability_status == 'maintenance' ? 'selected' : '' }}>Dalam Perbaikan</option>
                                    <option value="disposed" {{ $tool->availability_status == 'disposed' ? 'selected' : '' }}>Dihapuskan / Hilang</option>
                                </select>
                            </div>

                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('tools.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Simpan Perubahan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>