<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Transaksi Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-700">Riwayat Peminjaman</h3>
                        <a href="{{ route('borrowings.create') }}" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded shadow-sm">
                            + Buat Peminjaman Baru
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border-collapse border border-gray-200 text-sm">
                            <thead class="bg-gray-100 text-gray-700 uppercase">
                                <tr>
                                    <th class="border px-4 py-3 text-center">No</th>
                                    <th class="border px-4 py-3 text-left">Peminjam</th>
                                    <th class="border px-4 py-3 text-left">Tanggal Pinjam</th>
                                    <th class="border px-4 py-3 text-left">Rencana Kembali</th>
                                    <th class="border px-4 py-3 text-left">Alat yang Dipinjam</th>
                                    <th class="border px-4 py-3 text-center">Status</th>
                                    <th class="border px-4 py-3 text-center">Petugas</th>
                                    <th class="border px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($borrowings as $index => $borrowing)
                                    <tr class="hover:bg-gray-50 border-b">
                                        <td class="border px-4 py-3 text-center">{{ $index + 1 }}</td>
                                        
                                        <td class="border px-4 py-3">
                                            <div class="font-bold text-gray-800">{{ $borrowing->borrower->name }}</div>
                                            <div class="text-xs text-gray-500">NIS: {{ $borrowing->borrower->code }}</div>
                                        </td>

                                        <td class="border px-4 py-3 text-sm">
                                            {{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d M Y') }}
                                        </td>
                                        <td class="border px-4 py-3 text-red-600 font-semibold text-sm">
                                            {{ \Carbon\Carbon::parse($borrowing->planned_return_date)->format('d M Y') }}
                                        </td>

                                        <td class="border px-4 py-3 text-sm">
                                            <ul class="list-disc list-inside">
                                                @foreach($borrowing->items as $item)
                                                    <li>{{ $item->tool->tool_name }}</li>
                                                @endforeach
                                            </ul>
                                        </td>

                                        <td class="border px-4 py-3 text-center">
                                            @if($borrowing->borrowing_status == 'active' || $borrowing->borrowing_status == 'Sedang Dipinjam')
                                                <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-xs font-bold border border-yellow-200">
                                                    Sedang Dipinjam
                                                </span>
                                            @else
                                                <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs font-bold border border-green-200">
                                                    Selesai
                                                </span>
                                                <div class="text-[10px] text-gray-400 mt-1">
                                                    {{ \Carbon\Carbon::parse($borrowing->actual_return_date)->format('d M Y') }}
                                                </div>
                                            @endif
                                        </td>
                                        
                                        <td class="border px-4 py-3 text-center text-xs">
                                            {{ $borrowing->user->name ?? 'Admin' }}
                                        </td>

                                        <td class="border px-4 py-3 text-center">
                                            <div class="flex justify-center items-center space-x-2">
                                                
                                                <a href="{{ route('borrowings.edit', $borrowing->id) }}" class="text-gray-500 hover:text-yellow-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>

                                                @if($borrowing->borrowing_status == 'active')
                                                    <form action="{{ route('borrowings.return', $borrowing->id) }}" method="POST" onsubmit="return confirm('Konfirmasi pengembalian alat?');">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white text-xs font-bold py-1 px-2 rounded shadow flex items-center" title="Kembalikan Barang">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                            Kembali
                                                        </button>
                                                    </form>
                                                
                                                @else
                                                    <form action="{{ route('borrowings.destroy', $borrowing->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus riwayat ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-gray-400 hover:text-red-600" title="Hapus Riwayat">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-6 text-gray-500">Data kosong.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>