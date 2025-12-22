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
                                    <tr class="hover:bg-gray-50">
                                        <td class="border px-4 py-3 text-center">{{ $index + 1 }}</td>
                                        
                                        <td class="border px-4 py-3">
                                            <div class="font-bold text-gray-800">{{ $borrowing->borrower->name }}</div>
                                            <div class="text-xs text-gray-500">NIS: {{ $borrowing->borrower->code }}</div>
                                        </td>

                                        <td class="border px-4 py-3">
                                            {{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d M Y') }}
                                        </td>
                                        <td class="border px-4 py-3 text-red-600 font-semibold">
                                            {{ \Carbon\Carbon::parse($borrowing->planned_return_date)->format('d M Y') }}
                                        </td>

                                        <td class="border px-4 py-3">
                                            <ul class="list-disc list-inside">
                                                @foreach($borrowing->items as $item)
                                                    <li>
                                                        {{ $item->tool->tool_name }} 
                                                        <span class="text-xs text-gray-400">({{ $item->tool->tool_code }})</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>

                                        <td class="border px-4 py-3 text-center">
                                            @if($borrowing->borrowing_status == 'active')
                                                <form action="{{ route('borrowings.return', $borrowing->id) }}" method="POST" onsubmit="return confirm('Apakah alat ini sudah dikembalikan dan dicek kondisinya?');">
                                                    @csrf
                                                    @method('PUT') <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-1 px-2 rounded shadow">
                                                        Kembalikan
                                                    </button>
                                                </form>
                                            @else
                                                <div class="flex flex-col items-center">
                                                    <span class="bg-gray-100 text-gray-500 py-0.5 px-2 rounded text-[10px] font-bold border border-gray-300">
                                                        Selesai
                                                    </span>
                                                    <span class="text-[10px] text-gray-400 mt-1">
                                                        {{ $borrowing->actual_return_date ? \Carbon\Carbon::parse($borrowing->actual_return_date)->format('d/m/Y') : '' }}
                                                    </span>
                                                </div>
                                            @endif
                                        </td>

                                        <td class="border px-4 py-3 text-center text-xs">
                                            {{ $borrowing->user->name ?? 'System' }}
                                        </td>

                                        <td class="border px-4 py-3 text-center">
                                            @if($borrowing->borrowing_status == 'active')
                                                <button class="bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-1 px-2 rounded">
                                                    Kembalikan
                                                </button>
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-6 text-gray-500">
                                            Belum ada data peminjaman.
                                        </td>
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