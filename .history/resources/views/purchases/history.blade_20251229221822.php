<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Transaksi (Selesai)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- TABEL RIWAYAT --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Tgl & Barang</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Merk</th>
                                    <th class="px-4 py-3 text-right text-xs font-bold text-gray-600 uppercase">Harga Asli</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase">Status</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase">Detail</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($purchases as $p)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-4 text-sm text-gray-900">
                                        <div class="text-xs text-gray-500">{{ $p->purchase_code }}</div>
                                        <div class="font-bold">{{ $p->tool_name }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-600">
                                        {{ $p->brand ?? '-' }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-right font-bold text-green-600">
                                        Rp {{ number_format($p->actual_unit_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full uppercase font-bold">
                                            {{ $p->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        {{-- TOMBOL LIHAT DETAIL --}}
                                        <button onclick="openDetailModal(
                                            '{{ $p->tool_name }}', 
                                            '{{ $p->brand }}', 
                                            '{{ $p->unit_price }}', 
                                            '{{ $p->actual_unit_price }}', 
                                            '{{ $p->proof_photo ? asset('storage/'.$p->proof_photo) : '' }}'
                                        )" class="text-blue-600 hover:text-blue-900 underline text-sm">
                                            Lihat
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada riwayat transaksi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $purchases->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL DETAIL --}}
    <div id="detailModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeDetailModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4" id="detailTitle">Detail Barang</h3>
                    
                    <div class="space-y-3">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-2 rounded">
                                <p class="text-xs text-gray-500">Rencana Anggaran</p>
                                <p class="font-medium" id="detailPlanned">Rp 0</p>
                            </div>
                            <div class="bg-green-50 p-2 rounded border border-green-200">
                                <p class="text-xs text-green-700 font-bold">Realisasi (Beli)</p>
                                <p class="font-bold text-green-700 text-lg" id="detailActual">Rp 0</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">Merk / Brand:</p>
                            <p class="font-medium" id="detailBrand">-</p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 mb-1">Bukti Nota:</p>
                            <img id="detailImage" src="" alt="Nota" class="w-full h-auto rounded border border-gray-200 hidden">
                            <p id="noImageText" class="text-sm text-red-500 italic hidden">Tidak ada foto nota.</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="closeDetailModal()" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openDetailModal(name, brand, planned, actual, photoUrl) {
            document.getElementById('detailTitle').innerText = name;
            document.getElementById('detailBrand').innerText = brand || '-';
            
            // Format Uang
            let fmt = new Intl.NumberFormat('id-ID');
            document.getElementById('detailPlanned').innerText = "Rp " + fmt.format(planned);
            document.getElementById('detailActual').innerText = "Rp " + fmt.format(actual);

            // Foto
            const img = document.getElementById('detailImage');
            const noImg = document.getElementById('noImageText');
            
            if (photoUrl) {
                img.src = photoUrl;
                img.classList.remove('hidden');
                noImg.classList.add('hidden');
            } else {
                img.classList.add('hidden');
                noImg.classList.remove('hidden');
            }

            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }
    </script>
</x-app-layout>