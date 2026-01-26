<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Riwayat Perawatan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 1. PESAN SUKSES / ERROR --}}
            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 shadow-sm rounded-r-lg" role="alert">
                    <p class="font-bold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Berhasil!
                    </p>
                    <p class="text-sm mt-1">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 shadow-sm rounded-r-lg" role="alert">
                    <p class="font-bold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Gagal!
                    </p>
                    <p class="text-sm mt-1">{{ session('error') }}</p>
                </div>
            @endif

            {{-- STATISTICS CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                {{-- Card 1: Total Perbaikan --}}
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Perbaikan</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $totalMaintenance }}</p>
                    </div>
                    <div class="p-3 bg-indigo-50 rounded-full text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                </div>

                 {{-- Card 2: Sedang Proses --}}
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Sedang Proses</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $minProgress }}</p>
                    </div>
                    <div class="p-3 bg-amber-50 rounded-full text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                 {{-- Card 3: Selesai --}}
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Selesai</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $completed }}</p>
                    </div>
                    <div class="p-3 bg-emerald-50 rounded-full text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                 {{-- Card 4: Total Biaya --}}
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Biaya</p>
                        <p class="text-lg font-bold text-slate-800">Rp {{ number_format($totalCost, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-3 bg-purple-50 rounded-full text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            {{-- 2. KONTAINER UTAMA --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="p-6 md:p-8 text-slate-800">

                    {{-- HEADER TEXT --}}
                    <div class="mb-8 border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-bold text-slate-800">Riwayat Perawatan</h3>
                        <p class="text-sm text-slate-500 mt-1">Monitor status perbaikan dan pemeliharaan aset.</p>
                    </div>


                    {{-- A. BAGIAN ATAS: FILTER & TOMBOL TAMBAH --}}
                    <div class="flex flex-col md:flex-row justify-between items-end md:items-center gap-4 mb-8">
                        
                        {{-- Form Filter (MODERN TOOLBAR) --}}
                        <form id="filterForm" action="{{ route('maintenances.index') }}" method="GET" class="w-full md:w-auto flex flex-col md:flex-row gap-2 items-center bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-all">
                            
                            {{-- Input Search --}}
                            <div class="relative w-full md:w-64 group">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    class="pl-10 pr-4 py-2 w-full border-none bg-transparent rounded-lg text-sm placeholder-slate-400 focus:ring-0 focus:text-slate-800 font-medium"
                                    placeholder="Cari Aset / Masalah..."
                                    onblur="this.form.submit()">
                            </div>

                            {{-- Divider --}}
                            <div class="hidden md:block h-6 w-px bg-slate-200 mx-1"></div>

                            {{-- Dropdown Status --}}
                            <div class="w-full md:w-auto relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <select name="status" onchange="this.form.submit()" class="w-full md:w-40 pl-8 pr-8 py-2 border-none bg-transparent rounded-lg text-sm text-slate-600 font-medium focus:ring-0 cursor-pointer hover:text-indigo-700 transition-colors appearance-none">
                                    <option value="">- Status -</option>
                                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Sedang Proses</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400 group-hover:text-indigo-600 transition-colors">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>

                            {{-- Divider --}}
                            <div class="hidden md:block h-6 w-px bg-slate-200 mx-1"></div>

                            {{-- Dropdown Jenis Perawatan --}}
                            <div class="w-full md:w-auto relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                                     <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <select name="type_id" onchange="this.form.submit()" class="w-full md:w-48 pl-8 pr-8 py-2 border-none bg-transparent rounded-lg text-sm text-slate-600 font-medium focus:ring-0 cursor-pointer hover:text-indigo-700 transition-colors appearance-none">
                                    <option value="">- Jenis -</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}" {{ request('type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400 group-hover:text-indigo-600 transition-colors">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>

                            {{-- Tombol Reset --}}
                            @if(request('search') || request('status') || request('type_id'))
                                <a href="{{ route('maintenances.index') }}" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" title="Reset Filter">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </a>
                            @endif
                        </form>

                        {{-- Tombol Tambah --}}
                        @auth
                            @if(auth()->user()->isHead())
                                <a href="{{ route('maintenances.export', request()->query()) }}" class="w-full md:w-auto inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-lg hover:shadow-emerald-500/30 transition duration-150 ease-in-out text-sm gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Export Laporan
                                </a>
                            @else
                                <a href="{{ route('maintenances.create') }}" class="w-full md:w-auto inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-lg hover:shadow-indigo-500/30 transition duration-150 ease-in-out text-sm gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Catat Perbaikan
                                </a>
                            @endif
                        @endauth
                    </div>

                    {{-- B. TABEL DATA --}}
                    {{-- Kita bungkus tabel dengan x-data untuk state modal --}}
                    <div x-data="{ 
                        showModal: false, 
                        modalData: {
                            tool_name: '',
                            tool_code: '',
                            reporter: '',
                            type: '',
                            start_date: '',
                            end_date: '',
                            cost: '',
                            status: '',
                            note: '',
                            action_taken: ''
                        },
                        openModal(data) {
                            this.modalData = data;
                            this.showModal = true;
                        }
                    }" class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                        
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-800 text-white">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Aset Multimedia</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Jenis Permasalahan</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Tgl Mulai</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Biaya</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @forelse ($maintenances as $index => $item)
                                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                                        {{-- ... (Columns 1-6 same as before) ... --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 text-center">
                                            {{ $maintenances->firstItem() + $index }}
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-slate-800">{{ $item->tool->tool_name ?? 'Aset Dihapus' }}</span>
                                                <span class="text-xs text-slate-500">{{ $item->tool->tool_code ?? '-' }}</span>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="flex flex-col gap-1">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-50 text-indigo-700 w-fit">
                                                    {{ $item->type->name ?? 'Umum' }}
                                                </span>
                                                <span class="text-sm text-slate-600 truncate max-w-xs" title="{{ $item->note }}">
                                                    {{ Str::limit($item->note, 30) }}
                                                </span>
                                                <span class="text-xs text-slate-400">Pelapor: {{ $item->user->name ?? '-' }}</span>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                            {{ \Carbon\Carbon::parse($item->start_date)->format('d M Y') }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-700">
                                            Rp {{ number_format($item->cost, 0, ',', '.') }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if($item->status == 'in_progress')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    Proses
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Selesai
                                                </span>
                                                <div class="text-[10px] text-slate-400 mt-1">
                                                    {{ $item->end_date ? \Carbon\Carbon::parse($item->end_date)->format('d/m/Y') : '' }}
                                                </div>
                                            @endif
                                        </td>

                                        {{-- Column Aksi --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center items-center space-x-3">
                                                {{-- Tombol View (Available for All) --}}
                                                <button 
                                                    @click="openModal({
                                                        tool_name: '{{ addslashes($item->tool->tool_name ?? '-') }}',
                                                        tool_code: '{{ $item->tool->tool_code ?? '-' }}',
                                                        reporter: '{{ addslashes($item->user->name ?? '-') }}',
                                                        type: '{{ addslashes($item->type->name ?? '-') }}',
                                                        start_date: '{{ \Carbon\Carbon::parse($item->start_date)->translatedFormat('d F Y') }}',
                                                        end_date: '{{ $item->end_date ? \Carbon\Carbon::parse($item->end_date)->translatedFormat('d F Y') : '-' }}',
                                                        cost: '{{ number_format($item->cost, 0, ',', '.') }}',
                                                        status: '{{ $item->status }}',
                                                        note: `{{ addslashes(preg_replace( "/\r|\n/", " ", $item->note ?? '')) }}`,
                                                        action_taken: `{{ addslashes(preg_replace( "/\r|\n/", " ", $item->action_taken ?? '-')) }}`
                                                    })"
                                                    class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition" 
                                                    title="Lihat Detail">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </button>

                                                @auth
                                                    @if(!auth()->user()->isHead())
                                                        {{-- Tombol Edit --}}
                                                        <a href="{{ route('maintenances.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg transition" title="Edit / Selesaikan">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                        </a>

                                                        {{-- Tombol Hapus --}}
                                                        <form action="{{ route('maintenances.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data perbaikan ini? Status alat akan dikembalikan.');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-rose-600 hover:text-rose-900 bg-rose-50 hover:bg-rose-100 p-2 rounded-lg transition" title="Hapus">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endauth
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-12">
                                            <div class="flex flex-col items-center justify-center text-slate-400">
                                                <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                <p class="text-base font-medium">Belum ada data perbaikan.</p>
                                                <p class="text-sm mt-1">Gunakan filter atau catat perbaikan baru.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- MODAL DETAIL --}}
                        <div x-show="showModal" style="display: none;" 
                             class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
                             
                            {{-- Backdrop --}}
                            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div x-show="showModal" 
                                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                     class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="showModal = false"></div>
                                
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                {{-- Modal Panel --}}
                                <div x-show="showModal"
                                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                     class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                                    
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="sm:flex sm:items-start">
                                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                <h3 class="text-lg leading-6 font-medium text-slate-900" id="modal-title">
                                                    Detail Perawatan
                                                </h3>
                                                <div class="mt-4 border-t border-slate-100 pt-4 space-y-3 text-sm">
                                                    
                                                    <div class="grid grid-cols-3 gap-2">
                                                        <span class="font-bold text-slate-500">Nama Alat:</span>
                                                        <span class="col-span-2 text-slate-800" x-text="modalData.tool_name"></span>
                                                    </div>
                                                    <div class="grid grid-cols-3 gap-2">
                                                        <span class="font-bold text-slate-500">Kode Aset:</span>
                                                        <span class="col-span-2 text-slate-800" x-text="modalData.tool_code"></span>
                                                    </div>
                                                    <div class="grid grid-cols-3 gap-2">
                                                        <span class="font-bold text-slate-500">Pelapor:</span>
                                                        <span class="col-span-2 text-slate-800" x-text="modalData.reporter"></span>
                                                    </div>
                                                    
                                                    <hr class="my-2 border-slate-100">

                                                    <div class="grid grid-cols-3 gap-2">
                                                        <span class="font-bold text-slate-500">Jenis:</span>
                                                        <span class="col-span-2 font-semibold text-indigo-600" x-text="modalData.type"></span>
                                                    </div>
                                                    <div class="grid grid-cols-3 gap-2">
                                                        <span class="font-bold text-slate-500">Status:</span>
                                                        <span class="col-span-2" x-text="modalData.status == 'in_progress' ? 'Sedang Proses' : 'Selesai'"></span>
                                                    </div>
                                                    
                                                    <hr class="my-2 border-slate-100">

                                                    <div class="grid grid-cols-3 gap-2">
                                                        <span class="font-bold text-slate-500">Tanggal Mulai:</span>
                                                        <span class="col-span-2 text-slate-800" x-text="modalData.start_date"></span>
                                                    </div>
                                                    <div class="grid grid-cols-3 gap-2">
                                                        <span class="font-bold text-slate-500">Tanggal Selesai:</span>
                                                        <span class="col-span-2 text-slate-800" x-text="modalData.end_date"></span>
                                                    </div>
                                                    <div class="grid grid-cols-3 gap-2">
                                                        <span class="font-bold text-slate-500">Biaya:</span>
                                                        <span class="col-span-2 font-semibold text-emerald-600" x-text="'Rp ' + modalData.cost"></span>
                                                    </div>

                                                    <hr class="my-2 border-slate-100">

                                                    <div>
                                                        <span class="block font-bold text-slate-500 mb-1">Keluhan / Catatan Awal:</span>
                                                        <p class="bg-amber-50 p-2 rounded text-slate-700 italic border border-amber-100" x-text="modalData.note"></p>
                                                    </div>

                                                    <div>
                                                        <span class="block font-bold text-slate-500 mb-1">Tindakan Perbaikan:</span>
                                                        <p class="bg-slate-50 p-2 rounded text-slate-700 border border-slate-100" x-text="modalData.action_taken || '-'"></p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showModal = false">
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- C. PAGINATION --}}
                    <div class="mt-8">
                        {{ $maintenances->withQueryString()->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>