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

            {{-- 2. KONTAINER UTAMA --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <div class="p-6 md:p-8 text-slate-800">

                    {{-- A. BAGIAN ATAS: FILTER & TOMBOL TAMBAH --}}
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                        
                        {{-- Form Filter --}}
                        <form action="{{ route('maintenances.index') }}" method="GET" class="flex flex-col md:flex-row gap-3 w-full md:w-auto items-center">
                            
                            {{-- Input Search --}}
                            <div class="relative w-full md:w-64">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    class="pl-10 w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                    placeholder="Cari Aset / Masalah...">
                            </div>

                            {{-- Dropdown Status --}}
                            <select name="status" class="w-full md:w-auto border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                <option value="">- Status -</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Sedang Proses</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                            </select>

                            {{-- Dropdown Jenis Perawatan --}}
                            <select name="type_id" class="w-full md:w-auto border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                <option value="">- Jenis -</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ request('type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>

                            {{-- Tombol Filter --}}
                            <button type="submit" class="w-full md:w-auto bg-slate-800 text-white px-5 py-2 rounded-lg hover:bg-slate-700 text-sm font-medium transition shadow-md">
                                Filter
                            </button>

                            {{-- Tombol Reset --}}
                            @if(request('search') || request('status') || request('type_id'))
                                <a href="{{ route('maintenances.index') }}" class="w-full md:w-auto bg-white border border-slate-300 text-slate-600 px-4 py-2 rounded-lg hover:bg-slate-50 text-sm transition font-medium text-center">
                                    Reset
                                </a>
                            @endif
                        </form>

                        {{-- Tombol Tambah --}}
                        @auth
                            @if(!auth()->user()->isHead())
                                <a href="{{ route('maintenances.create') }}" class="w-full md:w-auto inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-lg hover:shadow-indigo-500/30 transition duration-150 ease-in-out text-sm gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Catat Perbaikan
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
                                                <span class="text-xs text-slate-400">Teknisi: {{ $item->user->name ?? '-' }}</span>
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

                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center items-center space-x-3">
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
                                                    @else
                                                        <span class="text-slate-400 text-xs italic bg-slate-100 px-2 py-1 rounded">View Only</span>
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