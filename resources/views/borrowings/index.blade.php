<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Transaksi Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 1. PESAN SUKSES --}}
            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 shadow-sm rounded-r-lg">
                    <p class="font-bold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Berhasil!
                    </p>
                    <p class="text-sm mt-1">{{ session('success') }}</p>
                </div>
            @endif

            {{-- STATISTICS CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                {{-- Card 1: Sedang Dipinjam --}}
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Sedang Dipinjam</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $activeBorrowings }}</p>
                    </div>
                    <div class="p-3 bg-amber-50 rounded-full text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                 {{-- Card 2: Sudah Kembali --}}
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Sudah Kembali</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $returnedBorrowings }}</p>
                    </div>
                    <div class="p-3 bg-emerald-50 rounded-full text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </div>

                 {{-- Card 3: Terlambat --}}
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Terlambat</p>
                        <p class="text-2xl font-bold text-rose-600">{{ $overdueBorrowings }}</p>
                    </div>
                    <div class="p-3 bg-rose-50 rounded-full text-rose-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="p-6 md:p-8 text-slate-800">

                    {{-- HEADER TEXT --}}
                    <div class="mb-8 border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-bold text-slate-800">Transaksi Peminjaman</h3>
                        <p class="text-sm text-slate-500 mt-1">Kelola sirkulasi aset, peminjaman, dan pengembalian.</p>
                    </div>

                    {{-- A. BAGIAN FILTER --}}
                    <div class="flex flex-col md:flex-row justify-between items-end md:items-center gap-4 mb-8">
                        {{-- Form Filter (MODERN TOOLBAR) --}}
                        <form id="filterForm" action="{{ route('borrowings.index') }}" method="GET" class="w-full md:w-auto flex flex-col md:flex-row gap-2 items-center bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-all">
                            
                            {{-- Search Input --}}
                            <div class="relative w-full md:w-64 group">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    class="pl-10 pr-4 py-2 w-full border-none bg-transparent rounded-lg text-sm placeholder-slate-400 focus:ring-0 focus:text-slate-800 font-medium" 
                                    placeholder="Cari Nama / ID..."
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
                                    <option value="">- Status -</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Dipinjam</option>
                                    <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Kembali</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400 group-hover:text-indigo-600 transition-colors">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>

                            {{-- Divider --}}
                            <div class="hidden md:block h-6 w-px bg-slate-200 mx-1"></div>

                            {{-- Filter Periode --}}
                            <div class="w-full md:w-auto relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <select name="period" onchange="this.form.submit()" class="w-full md:w-48 pl-8 pr-8 py-2 border-none bg-transparent rounded-lg text-sm text-slate-600 font-medium focus:ring-0 cursor-pointer hover:text-indigo-700 transition-colors appearance-none">
                                    <option value="all">- Periode -</option>
                                    <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>Minggu Terakhir</option>
                                    <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>Bulan Terakhir</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400 group-hover:text-indigo-600 transition-colors">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            
                            {{-- Reset --}}
                            @if(request('search') || request('status') || (request('period') && request('period') !== 'all'))
                                <a href="{{ route('borrowings.index') }}" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" title="Reset Filter">
                                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </a>
                            @endif
                        </form>

                        @auth
                            @if(auth()->user()->isHead())
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" @click.away="open = false" class="w-full md:w-auto inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-lg hover:shadow-emerald-500/30 transition duration-150 ease-in-out text-sm gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Export Laporan
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="open" class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-xl z-20 border border-slate-100" style="display: none;">
                                        <a href="{{ route('borrowings.analysis_pdf', request()->query()) }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-indigo-600">
                                            📊 Laporan Analisa (PDF)
                                        </a>
                                        <div class="border-t border-slate-100 my-1"></div>
                                        <a href="{{ route('borrowings.exportPdf', request()->query()) }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-emerald-600">
                                            📄 Laporan Peminjaman (PDF)
                                        </a>
                                        <a href="{{ route('borrowings.exportExcel', request()->query()) }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-green-600">
                                            📗 Laporan Peminjaman (Excel)
                                        </a>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('borrowings.create') }}" class="w-full md:w-auto inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-lg hover:shadow-indigo-500/30 transition duration-150 ease-in-out text-sm gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Peminjaman Baru
                                </a>
                            @endif
                        @endauth
                    </div>

                    {{-- B. TABEL DATA --}}
                    <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-800 text-white">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Anggota Tim</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Tgl Pinjam</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Rencana Kembali</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Aset Multimedia</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @forelse ($borrowings as $index => $borrowing)
                                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 text-center">{{ $borrowings->firstItem() + $index }}</td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                     @if($borrowing->borrower->photo)
                                                        <img class="h-10 w-10 rounded-full object-cover border border-slate-200" src="{{ asset('storage/' . $borrowing->borrower->photo) }}" alt="{{ $borrowing->borrower->name }}">
                                                    @else
                                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold border border-indigo-200">
                                                            {{ substr($borrowing->borrower->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-slate-800 title-font">{{ $borrowing->borrower->name }}</div>
                                                    <div class="text-xs text-slate-500">{{ $borrowing->borrower->code }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d M Y') }}</td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-rose-600 font-medium">{{ \Carbon\Carbon::parse($borrowing->planned_return_date)->format('d M Y') }}</td>

                                        <td class="px-6 py-4">
                                            <ul class="list-disc list-inside text-sm text-slate-700 space-y-1">
                                                @foreach($borrowing->items as $item)
                                                    <li>{{ $item->tool->tool_name ?? 'Item Dihapus' }}</li>
                                                @endforeach
                                            </ul>
                                            @if($borrowing->notes)
                                                <div class="text-xs text-slate-400 italic mt-1 pl-1">"{{ $borrowing->notes }}"</div>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if($borrowing->borrowing_status == 'active')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    Dipinjam
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Kembali
                                                </span>
                                                <div class="text-[10px] text-slate-400 mt-1">
                                                    {{ $borrowing->final_status }} ({{ $borrowing->return_condition }})
                                                </div>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center items-center space-x-2">
                                                {{-- DETAIL --}}
                                                <button onclick="toggleModal('modal-detail-{{ $borrowing->id }}')" class="text-sky-600 hover:text-sky-900 bg-sky-50 p-2 rounded-lg hover:bg-sky-100 transition" title="Lihat Detail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </button>

                                                @auth
                                                    @if(!auth()->user()->isHead())
                                                        {{-- EDIT (Active Only) --}}
                                                        @if($borrowing->borrowing_status == 'active')
                                                            <button onclick="toggleModal('modal-edit-{{ $borrowing->id }}')" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition" title="Edit Data">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                </svg>
                                                            </button>

                                                            {{-- RETURN (Active Only) --}}
                                                            <button onclick="toggleModal('modal-return-{{ $borrowing->id }}')" class="text-emerald-600 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 p-2 rounded-lg transition" title="Proses Pengembalian">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                </svg>
                                                            </button>
                                                        @else
                                                            {{-- DELETE (Returned Only) --}}
                                                            <button type="button" onclick="openDeleteModal('{{ route('borrowings.destroy', $borrowing->id) }}', 'Hapus Riwayat Peminjaman?', 'Yakin ingin menghapus riwayat peminjaman ini secara permanen?')" class="text-rose-600 hover:text-rose-900 bg-rose-50 hover:bg-rose-100 p-2 rounded-lg transition" title="Hapus Riwayat">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        @endif
                                                    @endif
                                                @endauth
                                            </div>

                                            {{-- MODAL DETAIL --}}
                                            <div id="modal-detail-{{ $borrowing->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-hidden="true">
                                                <div class="flex items-center justify-center min-h-screen px-4 text-center">
                                                    <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" onclick="toggleModal('modal-detail-{{ $borrowing->id }}')"></div>
                                                    <div class="inline-block bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:max-w-2xl sm:w-full border border-slate-200">
                                                        <div class="bg-white px-6 py-6">
                                                            <div class="flex justify-between items-center border-b border-slate-100 pb-4 mb-4">
                                                                <h3 class="text-xl font-bold text-slate-800">Detail Transaksi</h3>
                                                                <button onclick="toggleModal('modal-detail-{{ $borrowing->id }}')" class="text-slate-400 hover:text-slate-600 transition">
                                                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                                </button>
                                                            </div>
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                                <div>
                                                                    <h4 class="font-bold text-indigo-900 text-sm uppercase tracking-wider mb-3">Informasi Peminjam</h4>
                                                                    <div class="space-y-3">
                                                                        <div class="flex justify-between text-sm"><span class="text-slate-500">Nama:</span> <span class="font-medium text-slate-800">{{ $borrowing->borrower->name }}</span></div>
                                                                        <div class="flex justify-between text-sm"><span class="text-slate-500">ID Anggota:</span> <span class="font-medium text-slate-800">{{ $borrowing->borrower->code }}</span></div>
                                                                        <div class="flex justify-between text-sm"><span class="text-slate-500">Admin:</span> <span class="font-medium text-slate-800">{{ $borrowing->user->name ?? 'System' }}</span></div>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <h4 class="font-bold text-indigo-900 text-sm uppercase tracking-wider mb-3">Timeline</h4>
                                                                    <div class="space-y-3">
                                                                        <div class="flex justify-between text-sm"><span class="text-slate-500">Mulai:</span> <span class="font-medium text-slate-800">{{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d F Y') }}</span></div>
                                                                        <div class="flex justify-between text-sm"><span class="text-slate-500">Rencana Kembali:</span> <span class="font-bold text-rose-600">{{ \Carbon\Carbon::parse($borrowing->planned_return_date)->format('d F Y') }}</span></div>
                                                                        @if($borrowing->actual_return_date)
                                                                            <div class="flex justify-between text-sm bg-emerald-50 p-1 -mx-1 rounded"><span class="text-emerald-700">Dikembalikan:</span> <span class="font-bold text-emerald-700">{{ \Carbon\Carbon::parse($borrowing->actual_return_date)->format('d F Y') }}</span></div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mt-6">
                                                                <h4 class="font-bold text-indigo-900 text-sm uppercase tracking-wider mb-3">Aset Multimedia</h4>
                                                                <div class="bg-slate-50 rounded-lg border border-slate-200 overflow-hidden">
                                                                    <table class="min-w-full divide-y divide-slate-200">
                                                                        <thead class="bg-slate-100">
                                                                            <tr><th class="px-4 py-2 text-left text-xs font-semibold text-slate-500 uppercase">Aset</th><th class="px-4 py-2 text-center text-xs font-semibold text-slate-500 uppercase">Kode</th><th class="px-4 py-2 text-center text-xs font-semibold text-slate-500 uppercase">Kondisi Awal</th></tr>
                                                                        </thead>
                                                                        <tbody class="divide-y divide-slate-200">
                                                                            @foreach($borrowing->items as $item)
                                                                                <tr>
                                                                                    <td class="px-4 py-2 text-sm text-slate-800 font-medium">{{ $item->tool->tool_name ?? 'Dihapus' }}</td>
                                                                                    <td class="px-4 py-2 text-sm text-center text-slate-500">{{ $item->tool->tool_code ?? '-' }}</td>
                                                                                    <td class="px-4 py-2 text-sm text-center text-slate-500">{{ $item->tool->condition ?? 'Baik' }}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="bg-slate-50 px-6 py-4 flex justify-end">
                                                            <button type="button" onclick="toggleModal('modal-detail-{{ $borrowing->id }}')" class="bg-white border border-slate-300 text-slate-700 px-4 py-2 rounded-lg hover:bg-slate-50 text-sm font-medium shadow-sm transition">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- MODAL RETURN (Active Only) --}}
                                            @if($borrowing->borrowing_status == 'active')
                                                <div id="modal-return-{{ $borrowing->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-hidden="true">
                                                    <div class="flex items-center justify-center min-h-screen px-4 text-center">
                                                        <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" onclick="toggleModal('modal-return-{{ $borrowing->id }}')"></div>
                                                        <div class="inline-block bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full border border-slate-200">
                                                            <form action="{{ route('borrowings.return', $borrowing->id) }}" method="POST">
                                                                @csrf @method('PUT')
                                                                <div class="bg-white px-6 py-6">
                                                                    <div class="flex items-center gap-3 mb-4 border-b border-slate-100 pb-4">
                                                                        <div class="p-2 bg-emerald-100 rounded-full text-emerald-600">
                                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                                        </div>
                                                                        <h3 class="text-xl font-bold text-slate-800">Proses Pengembalian</h3>
                                                                    </div>
                                                                    <div class="space-y-4">
                                                                        <div>
                                                                            <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Dikembalikan</label>
                                                                            <input type="date" name="returned_at" value="{{ date('Y-m-d') }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                                                        </div>
                                                                        <div>
                                                                            <label class="block text-sm font-medium text-slate-700 mb-1">Kondisi Aset</label>
                                                                            <select name="return_condition" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                                                                <option value="Baik">Baik / Normal</option>
                                                                                <option value="Rusak Ringan">Rusak Ringan / Lecet</option>
                                                                                <option value="Rusak Berat">Rusak Berat (Maintenance)</option>
                                                                            </select>
                                                                        </div>
                                                                        <div>
                                                                            <label class="block text-sm font-medium text-slate-700 mb-1">Status Akhir</label>
                                                                            <select name="final_status" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                                                                <option value="Selesai">Selesai (Kembali ke Stok)</option>
                                                                                <option value="Hilang">Hilang (Stok Berkurang)</option>
                                                                                <option value="Diganti">Diganti (Ganti Rugi)</option>
                                                                            </select>
                                                                            <p class="text-xs text-slate-500 mt-1">*Jika "Rusak Berat", otomatis terjadwal maintenance.</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3">
                                                                    <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 text-sm font-medium shadow-sm transition">Simpan & Selesai</button>
                                                                    <button type="button" onclick="toggleModal('modal-return-{{ $borrowing->id }}')" class="bg-white border border-slate-300 text-slate-700 px-4 py-2 rounded-lg hover:bg-slate-50 text-sm font-medium transition">Batal</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- MODAL EDIT (Active Only) --}}
                                            @if($borrowing->borrowing_status == 'active')
                                                <div id="modal-edit-{{ $borrowing->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-hidden="true">
                                                    <div class="flex items-center justify-center min-h-screen px-4 text-center">
                                                        <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" onclick="toggleModal('modal-edit-{{ $borrowing->id }}')"></div>
                                                        <div class="inline-block bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full border border-slate-200">
                                                            <form action="{{ route('borrowings.update', $borrowing->id) }}" method="POST">
                                                                @csrf @method('PUT')
                                                                <div class="bg-white px-6 py-6">
                                                                    <h3 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3">Edit Peminjaman</h3>
                                                                    <div class="mb-4">
                                                                        <label class="block text-sm font-medium text-slate-700 mb-1">Anggota Tim</label>
                                                                        <input type="text" value="{{ $borrowing->borrower->name }}" disabled class="w-full bg-slate-100 border-slate-300 rounded-lg text-slate-500 text-sm cursor-not-allowed">
                                                                    </div>
                                                                    <div class="mb-4">
                                                                        <label class="block text-sm font-medium text-slate-700 mb-1">Perpanjang / Ubah Tanggal Kembali</label>
                                                                        <input type="date" name="planned_return_date" value="{{ $borrowing->planned_return_date }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                                                    </div>
                                                                    <div class="mb-2">
                                                                        <label class="block text-sm font-medium text-slate-700 mb-1">Catatan</label>
                                                                        <textarea name="notes" rows="3" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">{{ $borrowing->notes }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3">
                                                                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm font-medium shadow-sm transition">Simpan Perubahan</button>
                                                                    <button type="button" onclick="toggleModal('modal-edit-{{ $borrowing->id }}')" class="bg-white border border-slate-300 text-slate-700 px-4 py-2 rounded-lg hover:bg-slate-50 text-sm font-medium transition">Batal</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-12">
                                            <div class="flex flex-col items-center justify-center text-slate-400">
                                                <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                <p class="text-base font-medium">Belum ada sirkulasi peminjaman.</p>
                                                <p class="text-sm mt-1">Silakan buat peminjaman baru.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-8">{{ $borrowings->links() }}</div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleModal(modalID){
            const modal = document.getElementById(modalID);
            if (modal) {
                if (modal.classList.contains('hidden')) {
                    modal.classList.remove('hidden');
                } else {
                    modal.classList.add('hidden');
                }
            }
        }
    </script>
    <x-modal-delete id="deleteModal" />
</x-app-layout>