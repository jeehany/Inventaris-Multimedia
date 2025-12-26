<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Transaksi Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 1. PESAN SUKSES (Alert) --}}
            @if (session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow-sm" role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            {{-- 2. KONTAINER UTAMA (Putih) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- A. BAGIAN ATAS: FILTER & TOMBOL TAMBAH --}}
                    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                        
                        {{-- Form Filter --}}
                        <form action="{{ route('borrowings.index') }}" method="GET" class="flex flex-col md:flex-row gap-2 w-full md:w-auto items-center">
                            
                            {{-- Input Search --}}
                            <input type="text" name="search" value="{{ request('search') }}" 
                                class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm w-full md:w-auto"
                                placeholder="Cari Nama / ID...">

                            {{-- Dropdown Status --}}
                            <select name="status" class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm w-full md:w-auto">
                                <option value="">- Semua Status -</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Kembali</option>
                            </select>

                            {{-- Dropdown Periode --}}
                            <select name="period" class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm w-full md:w-auto">
                                <option value="all" {{ request('period') == 'all' || request('period') == null ? 'selected' : '' }}>- Semua Periode -</option>
                                <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>Minggu Terakhir</option>
                                <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>Bulan Terakhir</option>
                            </select>

                            {{-- Tombol Filter --}}
                            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-sm w-full md:w-auto">
                                Filter
                            </button>

                            {{-- [BARU] Tombol Cetak PDF --}}
                            {{-- Menggunakan request()->query() agar filter yang sedang aktif ikut terkirim ke PDF --}}
                            <a href="{{ route('borrowings.exportPdf', request()->query()) }}" target="_blank" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 text-sm flex items-center justify-center gap-1 w-full md:w-auto" title="Cetak Laporan PDF sesuai filter">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                PDF
                            </a>

                            {{-- Tombol Reset --}}
                            @if(request('search') || request('status') || (request('period') && request('period') !== 'all'))
                                <a href="{{ route('borrowings.index') }}" class="px-4 py-2 text-gray-500 hover:text-gray-700 text-sm border border-gray-300 rounded-md text-center w-full md:w-auto">
                                    Reset
                                </a>
                            @endif
                        </form>

                        {{-- Tombol Tambah (Di Kanan) --}}
                        <a href="{{ route('borrowings.create') }}" class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow-sm text-center text-sm">
                            + Peminjaman Baru
                        </a>
                    </div>

                    {{-- B. TABEL DATA --}}
                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full table-auto text-sm text-left">
                            <thead class="bg-gray-50 text-gray-600 uppercase font-medium">
                                <tr>
                                    <th class="px-4 py-3 text-center">No</th>
                                    <th class="px-4 py-3">Peminjam</th>
                                    <th class="px-4 py-3">Tgl Pinjam</th>
                                    <th class="px-4 py-3">Rencana Kembali</th>
                                    <th class="px-4 py-3">Barang</th>
                                    <th class="px-4 py-3 text-center">Status</th>
                                    <th class="px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($borrowings as $index => $borrowing)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-center font-medium text-gray-500">
                                            {{ $borrowings->firstItem() + $index }}
                                        </td>
                                        
                                        <td class="px-4 py-3">
                                            <div class="font-bold text-gray-800">{{ $borrowing->borrower->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $borrowing->borrower->code }}</div>
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d M Y') }}
                                        </td>
                                        
                                        <td class="px-4 py-3 text-red-600 font-medium">
                                            {{ \Carbon\Carbon::parse($borrowing->planned_return_date)->format('d M Y') }}
                                        </td>

                                        <td class="px-4 py-3">
                                            <ul class="list-disc list-inside text-gray-700">
                                                @foreach($borrowing->items as $item)
                                                    <li>{{ $item->tool->tool_name ?? 'Alat Dihapus' }}</li>
                                                @endforeach
                                            </ul>
                                            @if($borrowing->notes)
                                                <div class="text-xs text-gray-500 italic mt-1">"{{ $borrowing->notes }}"</div>
                                            @endif
                                        </td>

                                        {{-- KOLOM STATUS --}}
                                        <td class="px-4 py-3 text-center">
                                            @if($borrowing->borrowing_status == 'active')
                                                <span class="bg-yellow-100 text-yellow-800 py-1 px-2 rounded-full text-xs font-bold border border-yellow-200">
                                                    Sedang Dipinjam
                                                </span>
                                            @else
                                                <span class="bg-green-100 text-green-800 py-1 px-2 rounded-full text-xs font-bold border border-green-200">
                                                    Dikembalikan
                                                </span>
                                                <div class="text-[10px] text-gray-400 mt-1">
                                                    {{ $borrowing->actual_return_date ? \Carbon\Carbon::parse($borrowing->actual_return_date)->format('d/m/Y') : '-' }}
                                                </div>
                                            @endif
                                        </td>

                                      
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-8 text-gray-400">
                                            Tidak ada data peminjaman yang ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- C. PAGINATION --}}
                    <div class="mt-6">
                        {{ $borrowings->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk Modal --}}
    <script>
        function toggleModal(modalID){
            const modal = document.getElementById(modalID);
            const body = document.querySelector('body');
            
            modal.classList.toggle("hidden");
            
            if (!modal.classList.contains('hidden')) {
                body.style.overflow = 'hidden';
            } else {
                body.style.overflow = 'auto';
            }
        }
    </script>
</x-app-layout>