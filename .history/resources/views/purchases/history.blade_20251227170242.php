<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- HEADER & TOOLS SECTION --}}
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                        
                        {{-- FILTER (DI KIRI) --}}
                        <form action="{{ url()->current() }}" method="GET" class="flex flex-col md:flex-row gap-2 w-full md:w-auto items-center">
    
    {{-- BARU: Filter Status --}}
    <select name="status" class="rounded-md border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 py-2 w-full md:w-auto">
        <option value="">- Semua Status -</option>
        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
    </select>

    {{-- Filter Search --}}
    <input type="text" name="search" value="{{ request('search') }}" 
        placeholder="Cari Kode / Alat..." 
        class="rounded-md border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 py-2 w-full md:w-40">

    {{-- Filter Bulan --}}
    @php
        $indoMonths = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
    @endphp
    <select name="month" class="rounded-md border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 py-2 w-full md:w-auto">
        <option value="">- Bulan -</option>
        @foreach($indoMonths as $key => $val)
            <option value="{{ $key }}" {{ request('month') == $key ? 'selected' : '' }}>
                {{ $val }}
            </option>
        @endforeach
    </select>

    {{-- Filter Tahun --}}
    <select name="year" class="rounded-md border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 py-2 w-full md:w-auto">
        <option value="">- Tahun -</option>
        @for($y = date('Y'); $y >= date('Y') - 5; $y--)
            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                {{ $y }}
            </option>
        @endfor
    </select>

    <button type="submit" class="bg-gray-800 text-white px-3 py-2 rounded-md text-sm hover:bg-gray-700">
        Cari
    </button>

    @if(request('search') || request('month') || request('year') || request('status'))
        <a href="{{ url()->current() }}" class="text-red-500 text-sm hover:underline ml-1">
            Reset
        </a>
    @endif
</form>

                    </div>

                    {{-- TABLE --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Item</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Vendor</th>
                                    <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">Total Akhir</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase">Status</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase">Bukti</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($history as $h)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="font-bold">{{ $h->purchase_code }}</div>
                                        <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($h->updated_at)->format('d M Y') }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-900">
                                        <div class="font-bold">{{ $h->tool_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $h->category->category_name ?? '-' }}</div>
                                        <div class="text-xs mt-1">Qty: {{ $h->quantity }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-600">
                                        {{ $h->vendor->name }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-right">
                                        @if($h->status == 'rejected')
                                            <span class="text-gray-400 line-through decoration-red-500 decoration-2">
                                                Rp {{ number_format($h->subtotal, 0, ',', '.') }}
                                            </span>
                                        @else
                                            @php
                                                // Gunakan harga real jika ada, jika tidak pakai harga estimasi awal
                                                $finalPrice = $h->real_price ? $h->real_price : $h->unit_price;
                                                $finalTotal = $finalPrice * $h->quantity;
                                            @endphp
                                            <div class="font-bold text-gray-900">
                                                Rp {{ number_format($finalTotal, 0, ',', '.') }}
                                            </div>
                                            @if($h->real_price && $h->real_price != $h->unit_price)
                                                <div class="text-xs text-blue-600 italic">(Realisasi)</div>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        @if($h->status == 'rejected')
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Ditolak
                                            </span>
                                            <div class="text-xs text-red-500 mt-1 max-w-[150px] mx-auto truncate" title="{{ $h->rejection_note }}">
                                                "{{ $h->rejection_note }}"
                                            </div>
                                        @elseif($h->is_purchased)
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Selesai
                                            </span>
                                        @endif
                                    </td>
                                   <td class="px-4 py-4 text-center">
                                        @if($h->transaction_proof_photo)
                                            <button onclick="showImage('{{ asset('storage/' . str_replace('public/', '', $h->transaction_proof_photo)) }}', '{{ addslashes($h->tool_name) }}')" 
                                                class="text-blue-600 hover:text-blue-900 text-xs font-bold border border-blue-200 bg-blue-50 px-3 py-1 rounded">
                                                Lihat Nota
                                            </button>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                        Belum ada riwayat transaksi.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- PAGINATION --}}
                    <div class="mt-4">
                        {{ $history->withQueryString()->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- MODAL IMAGE --}}
    <div id="imageModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeImageModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">Bukti Pembayaran</h3>
                        <button type="button" onclick="closeImageModal()" class="text-gray-400 hover:text-gray-500">
                            <span class="text-2xl">&times;</span>
                        </button>
                    </div>
                    <div class="mt-2 flex justify-center bg-gray-100 p-2 rounded">
                        <img id="modalImage" src="" alt="Bukti Transaksi" class="max-h-[70vh] object-contain">
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="closeImageModal()" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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