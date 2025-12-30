<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaction (Pending)') }}
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
                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Belanja (Pending)</h3>
                        <p class="text-sm text-gray-500">Item di sini belum dibeli. Klik "Proses" untuk input harga asli & nota.</p>
                    </div>

                    {{-- TABLE --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Tanggal</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Barang</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase">Vendor</th>
                                    <th class="px-4 py-3 text-right text-xs font-bold text-gray-600 uppercase">Estimasi Budget</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-600 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($purchases as $p)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-4 text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($p->date)->format('d M Y') }}<br>
                                        <span class="text-xs text-blue-600 font-bold">{{ $p->purchase_code }}</span>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-900">
                                        <div class="font-bold">{{ $p->tool_name }}</div>
                                        <div class="text-xs text-gray-500">Qty: {{ $p->quantity }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-600">
                                        {{ $p->vendor->name }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-right font-medium">
                                        Rp {{ number_format($p->unit_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        @if(Auth::user()->role == 'head')
                                            <span class="text-xs text-gray-400 italic">Read-only</span>
                                        @else
                                            {{-- TOMBOL PROSES --}}
                                            <button type="button" 
                                                onclick="openProcessModal('{{ $p->id }}', '{{ addslashes($p->tool_name) }}', '{{ $p->unit_price }}')"
                                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm shadow">
                                                Proses
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">Tidak ada transaksi pending.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL PROSES TRANSAKSI --}}
    <div id="processModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeProcessModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                
                {{-- FORM START --}}
                <form id="processForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Selesaikan Transaksi</h3>
                        
                        {{-- Nama Barang --}}
                        <div class="mb-4 bg-blue-50 p-2 rounded">
                            <p class="text-xs text-blue-600 font-bold uppercase">Barang</p>
                            <p id="modalToolName" class="font-bold text-gray-800 text-lg">-</p>
                        </div>

                        {{-- Grid Harga --}}
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Budget (Rencana)</label>
                                <input type="text" id="displayPlannedPrice" disabled class="w-full bg-gray-200 border-gray-300 rounded text-sm cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-blue-700 mb-1">Harga Asli (Nota)</label>
                                <input type="number" name="actual_unit_price" required class="w-full border-blue-500 rounded text-sm focus:ring-blue-500" placeholder="Rp 0">
                            </div>
                        </div>

                        {{-- Brand --}}
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-gray-700 mb-1">Merk / Brand</label>
                            <input type="text" name="brand" required class="w-full border-gray-300 rounded text-sm" placeholder="Contoh: Canon, Honda">
                        </div>

                        {{-- Upload Nota --}}
                        <div class="mb-2">
                            <label class="block text-xs font-bold text-gray-700 mb-1">Foto Nota / Bukti</label>
                            <input type="file" name="proof_photo" required class="w-full text-sm text-gray-500 border border-gray-300 rounded p-1">
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">
                            Simpan & Selesai
                        </button>
                        <button type="button" onclick="closeProcessModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
                {{-- FORM END --}}
            </div>
        </div>
    </div>

    <script>
        function openProcessModal(id, name, plannedPrice) {
            // 1. Reset Form
            document.getElementById('processForm').reset();
            
            // 2. Set Action URL
            document.getElementById('processForm').action = "/purchases/" + id + "/process";
            
            // 3. Isi Data Tampilan
            document.getElementById('modalToolName').innerText = name;
            
            // Format Rupiah untuk tampilan Budget
            let formatted = new Intl.NumberFormat('id-ID').format(plannedPrice);
            document.getElementById('displayPlannedPrice').value = "Rp " + formatted;
            
            // 4. Buka Modal
            document.getElementById('processModal').classList.remove('hidden');
        }

        function closeProcessModal() {
            document.getElementById('processModal').classList.add('hidden');
        }
    </script>
</x-app-layout>