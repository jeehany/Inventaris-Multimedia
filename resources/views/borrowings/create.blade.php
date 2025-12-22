<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Peminjaman Baru') }}
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

                    <form action="{{ route('borrowings.store') }}" method="POST">
                        @csrf

                        {{-- 1. PILIH PEMINJAM --}}
                        <div class="mb-4">
                            <label for="borrower_id" class="block text-sm font-medium text-gray-700 mb-1">Nama Peminjam</label>
                            <select name="borrower_id" id="borrower_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="">-- Cari Peminjam --</option>
                                @foreach($borrowers as $borrower)
                                    <option value="{{ $borrower->id }}" {{ old('borrower_id') == $borrower->id ? 'selected' : '' }}>
                                        {{ $borrower->name }} (ID: {{ $borrower->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            {{-- 2. PILIH KATEGORI (Filter) --}}
                            <div>
                                <label for="category_filter" class="block text-sm font-medium text-gray-700 mb-1">Pilih Kategori Alat</label>
                                <select id="category_filter" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50">
                                    <option value="">-- Pilih Kategori Dahulu --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 mt-1">*Pilih kategori untuk memunculkan daftar alat.</p>
                            </div>

                            {{-- 3. PILIH ALAT (Hasil Filter) --}}
                            <div>
                                <label for="tool_ids" class="block text-sm font-medium text-gray-700 mb-1">Pilih Alat (Bisa lebih dari satu)</label>
                                <select name="tool_ids[]" id="tool_ids" multiple class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 h-32 bg-gray-100 cursor-not-allowed" disabled required>
                                    <option value="">-- Alat akan muncul setelah kategori dipilih --</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">*Tahan tombol CTRL (Windows) atau Command (Mac) untuk memilih banyak.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            {{-- TANGGAL PINJAM --}}
                            <div>
                                <label for="borrow_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pinjam</label>
                                <input type="date" name="borrow_date" id="borrow_date" value="{{ old('borrow_date', date('Y-m-d')) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>

                            {{-- RENCANA KEMBALI --}}
                            <div>
                                <label for="planned_return_date" class="block text-sm font-medium text-gray-700 mb-1">Rencana Kembali</label>
                                <input type="date" name="planned_return_date" id="planned_return_date" value="{{ old('planned_return_date') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>
                        </div>

                        {{-- 4. INPUT CATATAN (NOTES) --}}
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                            <textarea 
                                name="notes" 
                                id="notes" 
                                rows="3" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                                placeholder="Contoh: Keperluan acara seminar atau catatan kondisi alat..."
                            >{{ old('notes') }}</textarea>
                        </div>

                        {{-- TOMBOL SUBMIT --}}
                        <div class="flex items-center justify-end">
                            <a href="{{ route('borrowings.index') }}" class="text-gray-600 hover:text-gray-900 mr-4 font-medium">Batal</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow-lg transition duration-150 ease-in-out">
                                Proses Peminjaman
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- JAVASCRIPT UNTUK DROPWDOWN DINAMIS --}}
    <script>
        document.getElementById('category_filter').addEventListener('change', function() {
            var categoryId = this.value;
            var toolSelect = document.getElementById('tool_ids');

            // 1. Reset Dropdown Alat
            toolSelect.innerHTML = '<option value="">Memuat data...</option>';
            toolSelect.disabled = true;
            toolSelect.classList.add('bg-gray-100', 'cursor-not-allowed');

            if (categoryId) {
                // 2. Fetch Data dari Server
                fetch('/get-tools/' + categoryId)
                    .then(response => response.json())
                    .then(data => {
                        // Kosongkan opsi
                        toolSelect.innerHTML = '';
                        
                        if (data.length === 0) {
                            toolSelect.innerHTML = '<option value="">Tidak ada alat tersedia di kategori ini</option>';
                        } else {
                            // Loop data alat dan masukkan ke dropdown
                            data.forEach(tool => {
                                var option = document.createElement('option');
                                option.value = tool.id;
                                option.text = tool.tool_name + ' (Kode: ' + tool.tool_code + ')';
                                toolSelect.appendChild(option);
                            });
                            
                            // Aktifkan Dropdown
                            toolSelect.disabled = false;
                            toolSelect.classList.remove('bg-gray-100', 'cursor-not-allowed');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toolSelect.innerHTML = '<option value="">Gagal memuat data</option>';
                    });
            } else {
                toolSelect.innerHTML = '<option value="">-- Pilih Kategori Dahulu --</option>';
            }
        });
    </script>
</x-app-layout>