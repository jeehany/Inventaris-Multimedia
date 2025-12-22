<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Transaksi Peminjaman') }}
        </h2>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                {{-- BAGIAN FILTER --}}
                <div class="mb-4 bg-white p-4 rounded-lg shadow-sm">
                    <form action="{{ route('borrowings.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                        
                        {{-- Input Pencarian --}}
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Cari Nama Peminjam atau NIS...">
                        </div>

                        {{-- Dropdown Status --}}
                        <div class="w-full md:w-48">
                            <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">-- Semua Status --</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Sedang Dipinjam</option>
                                <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Sudah Kembali</option>
                            </select>
                        </div>

                        {{-- Tombol Cari --}}
                        <div>
                            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">
                                Filter
                            </button>
                            {{-- Tombol Reset (Opsional) --}}
                            @if(request('search') || request('status'))
                                <a href="{{ route('borrowings.index') }}" class="ml-2 text-gray-500 hover:text-gray-700">Reset</a>
                            @endif
                        </div>

                    </form>
                </div>

                {{-- TABEL DATA (Yang sudah ada sebelumnya) --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    </div>

                {{-- PAGINATION LINK (Penting agar bisa pindah halaman) --}}
                <div class="mt-4">
                    {{ $borrowings->links() }}
                </div>

            </div>
        </div>
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
                                    <tr class="hover:bg-gray-50 border-b transition duration-150">
                                        <td class="border px-4 py-3 text-center">{{ $index + 1 }}</td>
                                        
                                        <td class="border px-4 py-3">
                                            <div class="font-bold text-gray-800">{{ $borrowing->borrower->name }}</div>
                                            <div class="text-xs text-gray-500">ID: {{ $borrowing->borrower->code }}</div>
                                        </td>

                                        <td class="border px-4 py-3 text-sm">
                                            {{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d M Y') }}
                                        </td>
                                        <td class="border px-4 py-3 text-red-600 font-semibold text-sm">
                                            {{ \Carbon\Carbon::parse($borrowing->planned_return_date)->format('d M Y') }}
                                        </td>

                                        <td class="border px-4 py-3 text-sm">
                                            <ul class="list-disc list-inside text-gray-700 font-medium">
                                                @foreach($borrowing->items as $item)
                                                    <li>{{ $item->tool->tool_name }}</li>
                                                @endforeach
                                            </ul>

                                            @if($borrowing->notes)
                                                <div class="mt-2 pt-2 border-t border-gray-100">
                                                    <span class="text-[10px] uppercase font-bold text-gray-400">Catatan:</span>
                                                    <p class="text-xs text-gray-600 italic">
                                                        "{{ $borrowing->notes }}"
                                                    </p>
                                                </div>
                                            @endif
                                        </td>

                                        <td class="border px-4 py-3 text-center">
                                            @if($borrowing->borrowing_status == 'active' || $borrowing->borrowing_status == 'Sedang Dipinjam')
                                                <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-xs font-bold border border-yellow-200">
                                                    Dipinjam
                                                </span>
                                            @else
                                                <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs font-bold border border-green-200">
                                                    Selesai
                                                </span>
                                                <div class="text-[10px] text-gray-400 mt-1">
                                                    {{ \Carbon\Carbon::parse($borrowing->actual_return_date)->format('d/m/Y') }}
                                                </div>
                                            @endif
                                        </td>
                                        
                                        <td class="border px-4 py-3 text-center text-xs text-gray-500">
                                            {{ $borrowing->user->name ?? 'Admin' }}
                                        </td>

                                        <td class="border px-4 py-3 text-center">
                                            <div class="flex justify-center items-center space-x-2">
                                                
                                                <button onclick="toggleModal('modal-edit-{{ $borrowing->id }}')" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-1 rounded transition" title="Edit Data">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>

                                                @if($borrowing->borrowing_status == 'active')
                                                    <form action="{{ route('borrowings.return', $borrowing->id) }}" method="POST" onsubmit="return confirm('Barang sudah diterima fisik?');">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white text-xs font-bold py-1 px-2 rounded shadow flex items-center transition">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                            Kembali
                                                        </button>
                                                    </form>
                                                
                                                @else
                                                    <form action="{{ route('borrowings.destroy', $borrowing->id) }}" method="POST" onsubmit="return confirm('Hapus riwayat ini selamanya?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-1 rounded transition" title="Hapus Riwayat">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>

                                            <div id="modal-edit-{{ $borrowing->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="toggleModal('modal-edit-{{ $borrowing->id }}')"></div>

                                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                        
                                                        <form action="{{ route('borrowings.update', $borrowing->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            
                                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                                                                    Edit Peminjaman
                                                                </h3>
                                                                
                                                                <div class="mb-4">
                                                                    <label class="block text-gray-700 text-sm font-bold mb-2">Peminjam</label>
                                                                    <input type="text" value="{{ $borrowing->borrower->name }}" disabled class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                                                </div>

                                                                <div class="mb-4">
                                                                    <label class="block text-gray-700 text-sm font-bold mb-2">Rencana Kembali</label>
                                                                    <input type="date" name="planned_return_date" value="{{ $borrowing->planned_return_date }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                                    <p class="text-xs text-gray-500 mt-1">*Ubah jika peminjam meminta perpanjangan waktu.</p>
                                                                </div>

                                                                <div class="mb-2">
                                                                    <label class="block text-gray-700 text-sm font-bold mb-2">Catatan / Keterangan</label>
                                                                    <textarea name="notes" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">{{ $borrowing->notes }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                                                    Simpan Perubahan
                                                                </button>
                                                                <button type="button" onclick="toggleModal('modal-edit-{{ $borrowing->id }}')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                                    Batal
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-6 text-gray-500">Belum ada data peminjaman.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT DIPINDAHKAN KE SINI (DI DALAM X-APP-LAYOUT) --}}
    <script>
        function toggleModal(modalID){
            document.getElementById(modalID).classList.toggle("hidden");
        }
    </script>

</x-app-layout>