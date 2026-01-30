<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Riwayat Pengadaan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 shadow-sm rounded-r-lg">
                    <p class="font-bold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Berhasil!
                    </p>
                    <p class="text-sm mt-1">{{ session('success') }}</p>
                </div>
            @endif

            {{-- STATISTICS CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                {{-- Card 1: Selesai --}}
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Transaksi Selesai</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $completedPurchases }}</p>
                    </div>
                    <div class="p-3 bg-emerald-50 rounded-full text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                 {{-- Card 2: Total Pengeluaran --}}
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Pengeluaran</p>
                        <p class="text-lg font-bold text-slate-800">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-3 bg-purple-50 rounded-full text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="p-6 md:p-8 text-slate-800">
                    
                    {{-- HEADER & TOOLS SECTION --}}
                    <div class="mb-8 border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-bold text-slate-800">Arsip & Riwayat Transaksi</h3>
                        <p class="text-sm text-slate-500 mt-1">Daftar transaksi yang telah selesai atau dibatalkan.</p>
                    </div>

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                        
                        {{-- Form Filter (MODERN TOOLBAR) --}}
                        <form id="filterForm" action="{{ url()->current() }}" method="GET" class="w-full md:w-auto flex flex-col md:flex-row gap-2 items-center bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-all">
                            
                            {{-- Filter Search --}}
                            <div class="relative w-full md:w-56 group">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    placeholder="Cari Kode / Aset..." 
                                    class="pl-9 pr-4 py-2 w-full border-none bg-transparent rounded-lg text-sm placeholder-slate-400 focus:ring-0 focus:text-slate-800 font-medium"
                                    onblur="this.form.submit()">
                            </div>

                            {{-- Divider --}}
                            <div class="hidden md:block h-6 w-px bg-slate-200 mx-1"></div>
    
                            {{-- Filter Status --}}
                            <div class="w-full md:w-auto relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <select name="status" onchange="this.form.submit()" class="w-full md:w-40 pl-8 pr-8 py-2 border-none bg-transparent rounded-lg text-sm text-slate-600 font-medium focus:ring-0 cursor-pointer hover:text-indigo-700 transition-colors appearance-none">
                                    <option value="">- Semua Status -</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400 group-hover:text-indigo-600 transition-colors">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            
                            {{-- Divider --}}
                            <div class="hidden md:block h-6 w-px bg-slate-200 mx-1"></div>

                            {{-- Filter Bulan --}}
                            <div class="w-full md:w-auto relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                @php
                                    $indoMonths = [
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
                                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
                                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                    ];
                                @endphp
                                <select name="month" onchange="this.form.submit()" class="w-full md:w-32 pl-8 pr-8 py-2 border-none bg-transparent rounded-lg text-sm text-slate-600 font-medium focus:ring-0 cursor-pointer hover:text-indigo-700 transition-colors appearance-none">
                                    <option value="">- Bulan -</option>
                                    @foreach($indoMonths as $key => $val)
                                        <option value="{{ $key }}" {{ request('month') == $key ? 'selected' : '' }}>
                                            {{ $val }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400 group-hover:text-indigo-600 transition-colors">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>

                            {{-- Filter Tahun --}}
                            <div class="w-full md:w-auto relative group">
                                <select name="year" onchange="this.form.submit()" class="w-full md:w-24 pl-3 pr-8 py-2 border-none bg-transparent rounded-lg text-sm text-slate-600 font-medium focus:ring-0 cursor-pointer hover:text-indigo-700 transition-colors appearance-none">
                                    <option value="">- Thn -</option>
                                    @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                            {{ $y }}
                                        </option>
                                    @endfor
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400 group-hover:text-indigo-600 transition-colors">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>

                            {{-- Tombol Reset --}}
                            @if(request('search') || request('month') || request('year') || request('status'))
                                <a href="{{ url()->current() }}" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" title="Reset Filter">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </a>
                            @endif
                        </form>

                        {{-- TOMBOL EXPORT --}}
                        @if(auth()->user()->isHead())
                        <div class="flex items-center gap-2">
                             <a href="{{ route('purchases.history.exportPdf', request()->all()) }}" target="_blank" class="bg-emerald-600 text-white px-4 py-2.5 rounded-xl hover:bg-emerald-700 font-medium text-sm shadow-sm transition flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Analisa Laporan (PDF)
                            </a>
                        </div>
                        @endif
                    </div>

                    {{-- TABLE --}}
                    <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-800 text-white">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Tanggal</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Detail Aset</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Vendor</th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider">Budget (Rencana)</th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider">Realisasi (Bayar)</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Bukti</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @forelse($history as $h)
                                <tr class="hover:bg-slate-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                        <div class="font-bold text-slate-800">{{ $h->purchase_code }}</div>
                                        <div class="text-xs mt-0.5">{{ \Carbon\Carbon::parse($h->updated_at)->format('d M Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-900">
                                        <div class="font-bold text-indigo-700">{{ $h->tool_name }}</div>
                                        <div class="text-xs text-slate-500 mt-0.5">{{ $h->category->category_name ?? '-' }}</div>
                                        <div class="text-xs mt-1 font-medium bg-slate-100 px-1.5 py-0.5 rounded inline-block">Qty: {{ $h->quantity }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        <div class="font-medium">{{ $h->vendor->name }}</div>
                                        <div class="text-xs text-slate-400 mt-0.5">
                                            Merk: {{ $h->brand ?? '-' }}
                                        </div>
                                    </td>
                                    
                                    {{-- KOLOM 1: HARGA RENCANA (BUDGET) --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-slate-500">
                                        Rp {{ number_format($h->unit_price * $h->quantity, 0, ',', '.') }}
                                    </td>

                                    {{-- KOLOM 2: HARGA REALISASI (AKHIR) --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                        @if($h->status == 'rejected')
                                            <span class="text-slate-400 italic">-</span>
                                        @else
                                            @php
                                                // Gunakan actual_unit_price yang sudah kita fix di database
                                                $actualPrice = $h->actual_unit_price ?? $h->unit_price;
                                                $totalReal = $actualPrice * $h->quantity;
                                                $totalPlan = $h->unit_price * $h->quantity;
                                                $diff = $totalPlan - $totalReal;
                                            @endphp
                                            
                                            <div class="font-bold text-slate-800">
                                                Rp {{ number_format($totalReal, 0, ',', '.') }}
                                            </div>

                                            {{-- Indikator Hemat/Lebih --}}
                                            @if($diff > 0)
                                                <div class="text-[10px] text-emerald-600 font-bold bg-emerald-50 px-1.5 py-0.5 rounded inline-block mt-1 border border-emerald-100">
                                                    Hemat: {{ number_format($diff, 0, ',', '.') }}
                                                </div>
                                            @elseif($diff < 0)
                                                <div class="text-[10px] text-rose-600 font-bold bg-rose-50 px-1.5 py-0.5 rounded inline-block mt-1 border border-rose-100">
                                                    Over: {{ number_format(abs($diff), 0, ',', '.') }}
                                                </div>
                                            @endif
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if($h->status == 'rejected')
                                            <div class="flex flex-col items-center">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800 border border-rose-200 mb-1">
                                                    Ditolak
                                                </span>
                                                <div class="group relative cursor-help">
                                                    <span class="text-[10px] text-rose-500 border-b border-dotted border-rose-400">Lihat Alasan</span>
                                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 p-2 bg-slate-800 text-white text-xs rounded shadow-lg w-48 text-center hidden group-hover:block z-10">
                                                        {{ $h->rejection_note }}
                                                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-slate-800"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($h->status == 'approved' || $h->is_purchased)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Selesai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                                {{ $h->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{-- Cek kolom proof_photo ATAU transaction_proof_photo sesuai database --}}
                                        @php
                                            $proof = $h->proof_photo ?? $h->transaction_proof_photo;
                                        @endphp

                                        @if($proof)
                                            <button onclick="showImage('{{ asset('storage/' . $proof) }}', '{{ addslashes($h->tool_name) }}')" 
                                                class="inline-flex items-center px-2.5 py-1.5 border border-indigo-200 text-xs font-semibold rounded text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                Lihat Bukti
                                            </button>
                                        @else
                                            <span class="text-slate-300 text-xs italic">Tidak ada</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <p class="text-base font-medium">Belum ada riwayat transaksi.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- PAGINATION --}}
                    <div class="mt-8">
                        {{ $history->withQueryString()->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- MODAL IMAGE --}}
    <div id="imageModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div class="fixed inset-0 bg-slate-900 bg-opacity-80 transition-opacity blur-sm" aria-hidden="true" onclick="closeImageModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center mb-4 border-b border-slate-100 pb-3">
                        <h3 class="text-lg leading-6 font-bold text-slate-900" id="modalTitle">Bukti Pembayaran</h3>
                        <button type="button" onclick="closeImageModal()" class="text-slate-400 hover:text-slate-500 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    <div class="mt-2 flex justify-center bg-slate-50 p-4 rounded-lg border border-state-100 min-h-[300px] items-center">
                        <img id="modalImage" src="" alt="Bukti Transaksi" class="max-h-[70vh] object-contain shadow-sm rounded">
                    </div>
                </div>
                <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-100">
                    <button type="button" onclick="closeImageModal()" class="w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showImage(src, title) {
            document.getElementById('modalImage').src = src;
            document.getElementById('modalTitle').innerText = "Bukti: " + title;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }
    </script>
</x-app-layout>