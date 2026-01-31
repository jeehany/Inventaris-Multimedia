<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Pengajuan Pengadaan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- PESAN SUKSES / ERROR --}}
            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 shadow-sm rounded-r-lg">
                    <p class="font-bold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Berhasil!
                    </p>
                    <p class="text-sm mt-1">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 shadow-sm rounded-r-lg">
                    <p class="font-bold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Gagal!
                    </p>
                    <p class="text-sm mt-1">{{ session('error') }}</p>
                </div>
            @endif

            {{-- STATISTICS CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                {{-- Card 1: Pengajuan Pending --}}
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Menunggu Persetujuan</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $pendingRequests }}</p>
                    </div>
                    <div class="p-3 bg-amber-50 rounded-full text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                 {{-- Card 2: Ditolak --}}
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Ditolak</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $rejectedRequests }}</p>
                    </div>
                    <div class="p-3 bg-rose-50 rounded-full text-rose-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="p-6 md:p-8 text-slate-800">

                    {{-- HEADER TEXT --}}
                    <div class="mb-8 border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-bold text-slate-800">Daftar Pengajuan</h3>
                        <p class="text-sm text-slate-500 mt-1">Kelola status dan persetujuan pengadaan aset baru.</p>
                    </div>

                    {{-- MODERN TOOLBAR (Search & Filter) --}}
                    <div class="flex flex-col md:flex-row justify-between items-end md:items-center gap-4 mb-8">
                        
                        {{-- Left: Filter Group --}}
                        <form id="filterForm" action="{{ route('purchases.request') }}" method="GET" class="w-full md:w-auto flex flex-col md:flex-row gap-2 items-center bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-all">
                            
                            {{-- Search Input --}}
                            <div class="relative w-full md:w-64 group">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    class="pl-10 pr-4 py-2 w-full border-none bg-transparent rounded-lg text-sm placeholder-slate-400 focus:ring-0 focus:text-slate-800 font-medium"
                                    placeholder="Cari Kode / Aset..."
                                    onblur="this.form.submit()">
                            </div>

                            {{-- Divider (Vertical Line) --}}
                            <div class="hidden md:block h-6 w-px bg-slate-200 mx-1"></div>

                            {{-- Filter Status (Dropdown) --}}
                            <div class="w-full md:w-auto relative group">
                                <!-- Icon Filter (Optional Add-on for visual cue) -->
                                <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                                </div>

                                <select name="status" onchange="this.form.submit()" class="w-full md:w-48 pl-8 pr-10 py-2 border-none bg-transparent rounded-lg text-sm text-slate-600 font-medium focus:ring-0 cursor-pointer hover:text-indigo-700 transition-colors appearance-none">
                                    <option value="all" class="font-bold">- Semua Status -</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option> 
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400 group-hover:text-indigo-600 transition-colors">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>

                            {{-- Reset Button (Muncul jika ada filter aktif) --}}
                            @if(request('search') || (request('status') && request('status') !== 'all'))
                                <a href="{{ route('purchases.request') }}" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" title="Reset Filter">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </a>
                            @endif
                        </form>



                        @auth
                            {{-- EXPORT BUTTON FOR HEAD --}}
                            @if(in_array(auth()->user()->role, ['kepala', 'head']))
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" @click.away="open = false" class="w-full md:w-auto inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-lg hover:shadow-emerald-500/30 transition duration-150 ease-in-out text-sm gap-2 whitespace-nowrap">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Export Laporan
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-xl z-20 border border-slate-100" style="display: none;">
                                        <a href="{{ route('purchases.request.exportPdf', request()->query()) }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-emerald-600">
                                            📄 Data Pengajuan (PDF)
                                        </a>
                                        <a href="{{ route('purchases.request.export', request()->query()) }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-green-600">
                                            📗 Data Pengajuan (Excel)
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if(!in_array(auth()->user()->role, ['kepala', 'head']))
                                <a href="{{ route('purchases.create') }}" class="w-full md:w-auto inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-lg hover:shadow-indigo-500/30 transition duration-150 ease-in-out text-sm gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Ajukan Pengadaan
                                </a>
                            @endif
                        @endauth
                    </div>

                    {{-- TABEL DATA --}}
                    <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-800 text-white">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider w-16">No</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Kode & Tanggal</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Detail Aset</th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider">Total (Rp)</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @forelse ($purchases as $index => $purchase)
                                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 text-center">
                                            {{ $purchases->firstItem() + $index }}
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-bold text-slate-800">{{ $purchase->purchase_code }}</div>
                                            <div class="text-xs text-slate-500 mt-0.5">
                                                {{ \Carbon\Carbon::parse($purchase->date)->format('d M Y') }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="font-bold text-indigo-700">{{ $purchase->tool_name }}</div>
                                            <div class="text-xs text-slate-500 mt-1 flex flex-col gap-0.5">
                                                <span><span class="font-medium text-slate-700">Vendor:</span> {{ $purchase->vendor->name }}</span>
                                                <span><span class="font-medium text-slate-700">Qty:</span> {{ $purchase->quantity }} unit</span>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-slate-700">
                                            Rp {{ number_format($purchase->subtotal, 0, ',', '.') }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if($purchase->status == 'pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    Menunggu
                                                </span>
                                            @elseif($purchase->status == 'approved')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 border border-indigo-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    Disetujui
                                                </span>
                                            @elseif($purchase->status == 'completed') 
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Selesai
                                                </span>
                                            @elseif($purchase->status == 'rejected')
                                                <div class="flex flex-col items-center">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800 border border-rose-200">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        Ditolak
                                                    </span>
                                                    @if($purchase->rejection_note)
                                                        <div class="group relative mt-1">
                                                            <span class="text-[10px] text-rose-500 border-b border-dotted border-rose-400 cursor-help">Lihat Alasan</span>
                                                            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 p-2 bg-slate-800 text-white text-xs rounded shadow-lg w-48 text-center hidden group-hover:block z-10 opacity-0 group-hover:opacity-100 transition-opacity">
                                                                {{ $purchase->rejection_note }}
                                                                <div class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-slate-800"></div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center items-center space-x-2">

                                                {{-- BUTTON "LIHAT" (SEMUA ROLE BISA LIHAT) --}}
                                                <button onclick="openDetailModal({{ $purchase }})" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg transition" title="Lihat Detail">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </button>
                                                
                                                @if(in_array(auth()->user()->role, ['kepala', 'head']))
                                                    @if($purchase->status == 'pending')
                                                        {{-- Approve --}}
                                                        <form action="{{ route('purchases.approve', $purchase->id) }}" method="POST">
                                                            @csrf @method('PATCH')
                                                            <button type="submit" class="text-emerald-600 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 p-2 rounded-lg transition" title="Setujui Pengajuan" onclick="return confirm('Setujui pengajuan ini?')">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                        
                                                        {{-- Reject --}}
                                                        <button type="button" class="text-rose-600 hover:text-rose-900 bg-rose-50 hover:bg-rose-100 p-2 rounded-lg transition" title="Tolak Pengajuan" onclick="rejectPurchase({{ $purchase->id }})">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>

                                                        <form id="reject-form-{{ $purchase->id }}" action="{{ route('purchases.reject', $purchase->id) }}" method="POST" class="hidden">
                                                            @csrf @method('PATCH')
                                                            <input type="hidden" name="note" id="note-{{ $purchase->id }}">
                                                        </form>
                                                    @else
                                                        {{-- <span class="text-slate-400 text-xs italic bg-slate-100 px-2 py-1 rounded">Locked</span> --}}
                                                    @endif
                                
                                                @else
                                                    {{-- STAFF --}}
                                                    @if($purchase->status == 'pending')
                                                        <button type="button" onclick="openDeleteModal('{{ route('purchases.destroy', $purchase->id) }}', 'Batalkan Pengajuan?', 'Yakin ingin membatalkan pengajuan ini? Data akan dihapus permanen.')" class="text-rose-600 hover:text-rose-900 bg-rose-50 hover:bg-rose-100 p-2 rounded-lg transition" title="Batalkan Pengajuan">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    @else
                                                        {{-- <span class="text-slate-400 text-xs italic bg-slate-100 px-2 py-1 rounded">Locked</span> --}}
                                                    @endif
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-12">
                                            <div class="flex flex-col items-center justify-center text-slate-400">
                                                <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                <p class="text-base font-medium">Belum ada pengajuan pengadaan.</p>
                                                <p class="text-xs mt-1">Silakan ajukan pengadaan aset baru.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $purchases->withQueryString()->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- MODAL DETAIL (Mirip Borrowings & Maintenance) --}}
    <div id="detailModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity blur-sm" aria-hidden="true" onclick="closeDetailModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full">
                
                {{-- Header Modal --}}
                <div class="bg-slate-800 px-4 py-3 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-bold text-white flex items-center gap-2" id="modal-title">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Detail Pengajuan
                    </h3>
                    <button type="button" onclick="closeDetailModal()" class="text-slate-400 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                {{-- Content Modal --}}
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                    <div id="modalContent" class="space-y-4">
                        {{-- Diisi via JS --}}
                    </div>
                </div>

                <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-100">
                    <button type="button" onclick="closeDetailModal()" class="w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function rejectPurchase(id) {
            let reason = prompt("Masukkan alasan penolakan:");
            if (reason !== null && reason.trim() !== "") {
                document.getElementById('note-' + id).value = reason;
                document.getElementById('reject-form-' + id).submit();
            }
        }

        function openDetailModal(data) {
            const modal = document.getElementById('detailModal');
            const content = document.getElementById('modalContent');
            
            // Format Rupiah
            const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' });
            
            // Translate Status
            let statusBadge = '';
            if(data.status === 'pending') statusBadge = '<span class="px-2 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-bold border border-amber-200">Menunggu</span>';
            else if(data.status === 'approved') statusBadge = '<span class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-bold border border-indigo-200">Disetujui</span>';
            else if(data.status === 'rejected') statusBadge = '<span class="px-2 py-1 bg-rose-100 text-rose-800 rounded-full text-xs font-bold border border-rose-200">Ditolak</span>';
            else if(data.status === 'completed') statusBadge = '<span class="px-2 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-bold border border-emerald-200">Selesai</span>';

            // Tanggal
            const date = new Date(data.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

            // HTML Structure (Grid 2 Kolom)
            content.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="col-span-2 border-b border-slate-100 pb-2 mb-2">
                        <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Info Transaksi</p>
                    </div>

                    <div>
                        <p class="text-xs text-slate-500">Kode Pengajuan</p>
                        <p class="font-bold text-slate-800">${data.purchase_code}</p>
                    </div>
                     <div>
                        <p class="text-xs text-slate-500">Tanggal</p>
                        <p class="font-bold text-slate-800">${date}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Pemohon (User)</p>
                        <p class="font-bold text-slate-800">${data.user ? data.user.name : '-'}</p>
                    </div>
                     <div>
                        <p class="text-xs text-slate-500">Status</p>
                        <div class="mt-1">${statusBadge}</div>
                    </div>

                    <div class="col-span-2 border-b border-slate-100 pb-2 mb-2 mt-2">
                        <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Detail Aset</p>
                    </div>

                    <div class="col-span-2">
                        <p class="text-xs text-slate-500">Nama Aset</p>
                        <p class="font-bold text-indigo-700 text-base">${data.tool_name}</p>
                    </div>
                    <div>
                         <p class="text-xs text-slate-500">Vendor</p>
                        <p class="font-bold text-slate-800">${data.vendor ? data.vendor.name : '-'}</p>
                    </div>
                    <div>
                         <p class="text-xs text-slate-500">Kategori</p>
                        <p class="font-bold text-slate-800">${data.category ? data.category.category_name : '-'}</p>
                    </div>
                    <div class="col-span-2">
                         <p class="text-xs text-slate-500">Spesifikasi</p>
                        <p class="font-medium text-slate-700 bg-slate-50 p-2 rounded border border-slate-100">${data.specification || '-'}</p>
                    </div>

                    <div class="col-span-2 border-b border-slate-100 pb-2 mb-2 mt-2">
                        <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Estimasi Biaya</p>
                    </div>

                    <div>
                        <p class="text-xs text-slate-500">Harga Satuan</p>
                        <p class="font-mono font-medium text-slate-600">${formatter.format(data.unit_price)}</p>
                    </div>
                     <div>
                        <p class="text-xs text-slate-500">Jumlah (Qty)</p>
                        <p class="font-mono font-medium text-slate-600">${data.quantity} Unit</p>
                    </div>
                    <div class="col-span-2 bg-indigo-50 p-3 rounded-lg border border-indigo-100 mt-2">
                        <div class="flex justify-between items-center">
                            <p class="text-sm font-bold text-indigo-900">Total Estimasi</p>
                            <p class="text-lg font-bold text-indigo-700">${formatter.format(data.subtotal)}</p>
                        </div>
                    </div>

                    ${data.status === 'rejected' && data.rejection_note ? `
                        <div class="col-span-2 bg-rose-50 p-3 rounded-lg border border-rose-100 mt-2">
                            <p class="text-xs font-bold text-rose-800 uppercase mb-1">Alasan Penolakan</p>
                            <p class="text-sm text-rose-700 italic">"${data.rejection_note}"</p>
                        </div>
                    ` : ''}
                </div>
            `;

            modal.classList.remove('hidden');
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }
    </script>
    <x-modal-delete id="deleteModal" />
</x-app-layout>