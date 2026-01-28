<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Item Terhapus') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Alert Success --}}
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 shadow-sm rounded-r-lg">
                    <div class="flex items-center gap-2 font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Berhasil!
                    </div>
                    <p class="text-sm mt-1">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-slate-200">
                <div class="p-6 md:p-8 text-slate-800">
                    
                    {{-- HEADER TEXT --}}
                    <div class="mb-8 border-b border-slate-100 pb-4">
                        <h3 class="text-lg font-bold text-slate-800">Item Terhapus (Recycle Bin)</h3>
                        <p class="text-sm text-slate-500 mt-1">Daftar aset yang telah dihapus sementara dan dapat dipulihkan.</p>
                    </div>

                    {{-- HEADER: PENCARIAN & FILTER --}}
                    <div class="flex flex-col md:flex-row justify-between items-end md:items-center gap-4 mb-8">
                        
                        {{-- Form Filter (MODERN TOOLBAR) --}}
                        <form id="filterForm" action="{{ route('tools.trash') }}" method="GET" class="w-full md:w-auto flex flex-col md:flex-row gap-2 items-center bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500 transition-all">
                            
                            {{-- Input Search --}}
                            <div class="relative w-full md:w-64 group">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    class="pl-10 pr-4 py-2 w-full border-none bg-transparent rounded-lg text-sm placeholder-slate-400 focus:ring-0 focus:text-slate-800 font-medium"
                                    placeholder="Cari Nama / Kode..."
                                    onblur="this.form.submit()">
                            </div>

                            {{-- Divider --}}
                            <div class="hidden md:block h-6 w-px bg-slate-200 mx-1"></div>

                            {{-- Dropdown Kategori --}}
                            <div class="w-full md:w-auto relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                </div>
                                <select name="category_id" onchange="this.form.submit()" class="w-full md:w-48 pl-8 pr-8 py-2 border-none bg-transparent rounded-lg text-sm text-slate-600 font-medium focus:ring-0 cursor-pointer hover:text-indigo-700 transition-colors appearance-none">
                                    <option value="all">- Semua Kategori -</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400 group-hover:text-indigo-600 transition-colors">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>

                            {{-- Tombol Reset --}}
                            @if(request('search') || (request('category_id') && request('category_id') != 'all'))
                                <a href="{{ route('tools.trash') }}" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-colors" title="Reset Filter">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </a>
                            @endif
                        </form>

                        {{-- Link Kembali / Export --}}
                        @if(auth()->user()->isHead())
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" @click.away="open = false" class="inline-flex items-center gap-2 text-white bg-emerald-600 hover:bg-emerald-700 text-sm font-bold whitespace-nowrap px-4 py-2 rounded-lg shadow-md transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Export Laporan
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div x-show="open" class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-xl z-20 border border-slate-100" style="display: none;">
                                    <a href="{{ route('tools.exportTrashPdf', request()->query()) }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-emerald-600">
                                        📄 Laporan Terhapus (PDF)
                                    </a>
                                    <a href="{{ route('tools.exportTrash', request()->query()) }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-green-600">
                                        📗 Laporan Terhapus (Excel)
                                    </a>
                                </div>
                            </div>
                        @else 
                            <a href="{{ route('tools.index') }}" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 text-sm font-bold whitespace-nowrap bg-indigo-50 px-4 py-2 rounded-lg hover:bg-indigo-100 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Kembali ke Daftar Aktif
                            </a>
                        @endif
                    </div>

                    {{-- TABEL DATA --}}
                    <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-800 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Kode Aset</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Nama Aset</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Tgl Dihapus</th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Alasan Musnah</th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @forelse ($tools as $tool)
                                    <tr class="hover:bg-slate-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="font-mono text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded border border-slate-200">
                                                {{ $tool->tool_code }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-slate-800">{{ $tool->tool_name }}</div>
                                            <div class="text-xs text-slate-400">{{ $tool->brand ?? 'Tanpa Merk' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                            {{ $tool->category->category_name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-rose-600">
                                            {{ $tool->deleted_at->format('d M Y') }}
                                        </td>
                                        
                                        {{-- TAMPILKAN ALASAN DI SINI --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-200">
                                                {{ $tool->disposal_reason ?? 'Tidak ada alasan' }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @auth
                                                @if(!auth()->user()->isHead())
                                                    <form action="{{ route('tools.restore', $tool->id) }}" method="POST" onsubmit="return confirm('Kembalikan aset ini ke daftar aktif?');">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="inline-flex items-center justify-center px-3 py-1.5 border border-transparent text-xs font-bold rounded-md text-emerald-700 bg-emerald-100 hover:bg-emerald-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition shadow-sm gap-1">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                            Pulihkan
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-slate-400 text-xs italic bg-slate-100 px-2 py-1 rounded">View Only</span>
                                                @endif
                                            @endauth
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-12">
                                            <div class="flex flex-col items-center justify-center text-slate-400">
                                                <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                <p class="text-base font-medium">Tempat sampah kosong.</p>
                                                <p class="text-sm mt-1">Belum ada aset yang dihapus.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION --}}
                    <div class="mt-8">
                        {{ $tools->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>