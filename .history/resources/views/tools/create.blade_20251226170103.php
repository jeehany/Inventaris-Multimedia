<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Alat Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Tampilkan Error Validasi jika ada --}}
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('tools.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            
                            {{-- 1. Kategori (Trigger Generate Code) --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Kategori</label>
                                <select id="category_select" name="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $cat)
                                        {{-- Pastikan value adalah ID --}}
                                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- 2. Kode Alat (Otomatis & Readonly) --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Kode Alat (Otomatis)</label>
                                <div class="relative">
                                    <input type="text" id="tool_code" name="tool_code" 
                                           value="{{ old('tool_code') }}"
                                           readonly 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 text-gray-600 cursor-not-allowed focus:ring-0" 
                                           placeholder="Pilih kategori untuk generate kode..." required>
                                    
                                    {{-- Loading indicator kecil --}}
                                    <div id="loading_code" class="absolute right-3 top-3 hidden">
                                        <svg class="animate-spin h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">*Kode digenerate otomatis berdasarkan urutan terakhir (termasuk data terhapus).</p>
                            </div>

                            {{-- 3. Nama Alat --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Nama Alat</label>
                                <input type="text" name="tool_name" value="{{ old('tool_name') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="Contoh: Laptop Asus ROG">
                            </div>

                            {{-- 4. Kondisi Fisik --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Kondisi Fisik</label>
                                <select name="current_condition" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="Baik" {{ old('current_condition') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Rusak" {{ old('current_condition') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                </select>
                            </div>

                            {{-- 5. Status Ketersediaan --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Status Ketersediaan</label>
                                <select name="availability_status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="available" {{ old('availability_status') == 'available' ? 'selected' : '' }}>Tersedia (Available)</option>
                                    <option value="borrowed" {{ old('availability_status') == 'borrowed' ? 'selected' : '' }}>Sedang Dipinjam</option>
                                    <option value="maintenance" {{ old('availability_status') == 'maintenance' ? 'selected' : '' }}>Dalam Perbaikan</option>
                                </select>
                            </div>

                            {{-- 6. Jumlah (Opsional, jika sistem kamu support stok > 1) --}}
                            {{-- Jika sistem menggunakan 1 kode = 1 barang unik, sebaiknya input ini disembunyikan/dihapus --}}
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Jumlah</label>
                                <input type="number" name="amount" value="1" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('tools.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Simpan Data</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- Script AJAX --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('category_select');
            const codeInput = document.getElementById('tool_code');
            const loader = document.getElementById('loading_code');

            async function fetchNext(catId) {
                // Reset input jika tidak ada kategori
                if (!catId) { 
                    codeInput.value = ''; 
                    return; 
                }

                // Tampilkan loading
                if(loader) loader.classList.remove('hidden');
                codeInput.classList.add('opacity-50');

                try {
                    // Panggil route yang kita buat di web.php
                    const response = await fetch(`/tools/get-next-code/${catId}`);
                    
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    const json = await response.json();
                    
                    // Masukkan hasil ke input
                    if (json.next) {
                        codeInput.value = json.next;
                    } else {
                        codeInput.value = 'ERROR-GEN';
                    }

                } catch (error) {
                    console.error('Gagal mengambil kode:', error);
                    codeInput.value = 'ERROR';
                } finally {
                    // Sembunyikan loading
                    if(loader) loader.classList.add('hidden');
                    codeInput.classList.remove('opacity-50');
                }
            }

            if (select) {
                // Event saat user mengubah pilihan kategori
                select.addEventListener('change', function() { 
                    fetchNext(this.value); 
                });

                // Trigger saat halaman dimuat (jika user kembali dari validasi error / old input)
                if (select.value && codeInput.value === '') {
                    fetchNext(select.value);
                }
            }
        });
    </script>
</x-app-layout>