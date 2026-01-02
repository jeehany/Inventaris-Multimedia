<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Buat Peminjaman Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Alert Errors --}}
            @if ($errors->any())
                <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 shadow-sm rounded-r-lg">
                    <div class="flex items-center gap-2 mb-2 font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Terdapat kesalahan pada input:
                    </div>
                    <ul class="list-disc list-inside text-sm space-y-1 ml-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-slate-200">
                <div class="p-8 text-slate-800">
                    
                    <div class="mb-8 border-b border-slate-100 pb-4">
                        <h3 class="text-2xl font-bold text-slate-800">Form Transaksi Sirkulasi</h3>
                        <p class="text-slate-500 mt-1">Isi data lengkap untuk mencatat peminjaman aset multimedia.</p>
                    </div>

                    <form action="{{ route('borrowings.store') }}" method="POST">
                        @csrf

                        {{-- 1. BAGIAN PEMINJAM --}}
                        <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 mb-8">
                            <h4 class="font-bold text-indigo-900 text-sm uppercase tracking-wider mb-4 border-b border-indigo-100 pb-2">Informasi Peminjam</h4>
                            <div class="max-w-xl">
                                <label for="borrower_id" class="block text-sm font-semibold text-slate-700 mb-2">Nama Anggota Tim</label>
                                <select name="borrower_id" id="borrower_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-slate-700 font-medium" required>
                                    <option value="">-- Cari Nama Anggota --</option>
                                    @foreach($borrowers as $borrower)
                                        <option value="{{ $borrower->id }}" {{ old('borrower_id') == $borrower->id ? 'selected' : '' }}>
                                            {{ $borrower->name }} (ID: {{ $borrower->code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- 2. PILIH ASET --}}
                        <div class="bg-slate-50 p-6 rounded-xl border border-slate-200 mb-8">
                            <h4 class="font-bold text-indigo-900 text-sm uppercase tracking-wider mb-4 border-b border-indigo-100 pb-2">Pilih Aset Multimedia</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Filter Kategori --}}
                                <div>
                                    <label for="category_filter" class="block text-sm font-semibold text-slate-700 mb-2">Filter Kategori</label>
                                    <select id="category_filter" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white text-slate-700">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-xs text-slate-500 mt-2 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Pilih kategori untuk menampilkan daftar aset.
                                    </p>
                                </div>
    
                                {{-- Pilih Alat --}}
                                <div>
                                    <label for="tool_ids" class="block text-sm font-semibold text-slate-700 mb-2">Daftar Aset (Multi-Select)</label>
                                    <select name="tool_ids[]" id="tool_ids" multiple class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 h-40 bg-slate-100 cursor-not-allowed text-sm text-slate-600 font-mono" disabled required>
                                        <option value="" class="p-2">-- Menunggu Input Kategori --</option>
                                    </select>
                                    <div class="mt-2 text-xs text-indigo-600 bg-indigo-50 p-2 rounded border border-indigo-100 inline-block">
                                        <strong>Tips:</strong> Tahan tombol <kbd class="font-sans bg-white border border-slate-300 rounded px-1">CTRL</kbd> (Win) atau <kbd class="font-sans bg-white border border-slate-300 rounded px-1">CMD</kbd> (Mac) untuk memilih banyak aset.
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 3. JADWAL --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div>
                                <label for="borrow_date" class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Pinjam</label>
                                <input type="date" name="borrow_date" id="borrow_date" value="{{ old('borrow_date', date('Y-m-d')) }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>
                            <div>
                                <label for="planned_return_date" class="block text-sm font-semibold text-slate-700 mb-2">Rencana Kembali</label>
                                <input type="date" name="planned_return_date" id="planned_return_date" value="{{ old('planned_return_date') }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>
                        </div>

                        {{-- 4. CATATAN --}}
                        <div class="mb-10">
                            <label for="notes" class="block text-sm font-semibold text-slate-700 mb-2">Catatan Keperluan (Opsional)</label>
                            <textarea 
                                name="notes" 
                                id="notes" 
                                rows="3" 
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 placeholder-slate-400" 
                                placeholder="Contoh: Digunakan untuk dokumentasi event tahunan..."
                            >{{ old('notes') }}</textarea>
                        </div>

                        {{-- TOMBOL SUBMIT --}}
                        <div class="flex items-center justify-end border-t border-slate-100 pt-6">
                            <a href="{{ route('borrowings.index') }}" class="text-slate-600 hover:text-slate-900 mr-6 font-semibold transition">Batal</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:shadow-indigo-500/30 transition duration-200 ease-in-out transform hover:-translate-y-0.5">
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
            toolSelect.innerHTML = '<option value="" class="p-2 text-slate-400">Memuat data...</option>';
            toolSelect.disabled = true;
            toolSelect.classList.add('bg-slate-100', 'cursor-not-allowed', 'text-slate-400');
            toolSelect.classList.remove('bg-white', 'text-slate-700');

            if (categoryId) {
                // 2. Fetch Data dari Server
                fetch('/get-tools/' + categoryId)
                    .then(response => response.json())
                    .then(data => {
                        // Kosongkan opsi
                        toolSelect.innerHTML = '';
                        
                        if (data.length === 0) {
                            toolSelect.innerHTML = '<option value="" class="p-2">Tidak ada aset tersedia / stok habis</option>';
                        } else {
                            // Loop data alat dan masukkan ke dropdown
                            data.forEach(tool => {
                                var option = document.createElement('option');
                                option.value = tool.id;
                                option.text = tool.tool_name + ' (Kode: ' + tool.tool_code + ')';
                                option.className = "p-2 hover:bg-indigo-50 cursor-pointer border-b border-slate-50 last:border-0";
                                toolSelect.appendChild(option);
                            });
                            
                            // Aktifkan Dropdown
                            toolSelect.disabled = false;
                            toolSelect.classList.remove('bg-slate-100', 'cursor-not-allowed', 'text-slate-400');
                            toolSelect.classList.add('bg-white', 'text-slate-700');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toolSelect.innerHTML = '<option value="" class="p-2 text-rose-500">Gagal memuat data</option>';
                    });
            } else {
                toolSelect.innerHTML = '<option value="" class="p-2">-- Pilih Kategori Dahulu --</option>';
            }
        });
    </script>
</x-app-layout>