<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Transaksi Pembelian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <strong>Error Input:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('purchases.store') }}" method="POST">
                @csrf
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Informasi Pembelian</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                                <input type="date" name="purchase_date" value="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Supplier (Vendor)</label>
                                <select name="vendor_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">-- Pilih Vendor --</option>
                                    @foreach($vendors as $vendor)
                                        <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mt-2">Status akan diset secara otomatis menjadi <strong>Pending</strong> dan menunggu persetujuan kepala.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Daftar Barang</h3>
                            <button type="button" onclick="addItemRow()" class="bg-green-600 text-white text-sm px-3 py-2 rounded shadow hover:bg-green-700">
                                + Tambah Baris
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full border text-sm" id="itemsTable">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-2 py-2 text-left w-1/4">Nama Alat</th>
                                        <th class="px-2 py-2 text-left w-1/5">Kategori</th>
                                        <th class="px-2 py-2 text-left w-1/5">Spesifikasi</th>
                                        <th class="px-2 py-2 text-center w-16">Qty</th>
                                        <th class="px-2 py-2 text-right w-32">Harga Satuan</th>
                                        <th class="px-2 py-2 text-right w-32">Subtotal</th>
                                        <th class="px-2 py-2 text-center w-10">#</th>
                                    </tr>
                                </thead>
                                <tbody id="itemsBody">
                                    <tr>
                                        <td class="p-2">
                                            <input type="text" name="items[0][tool_name]" class="w-full rounded border-gray-300 text-sm" placeholder="Nama Barang" required>
                                        </td>
                                        <td class="p-2">
                                            <select name="items[0][category_id]" class="w-full rounded border-gray-300 text-sm" required>
                                                <option value="">Pilih...</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="p-2">
                                            <input type="text" name="items[0][specification]" class="w-full rounded border-gray-300 text-sm" placeholder="Spek">
                                        </td>
                                        <td class="p-2">
                                            <input type="number" name="items[0][quantity]" class="w-full rounded border-gray-300 text-sm text-center qty-input" value="1" min="1" required oninput="calculateRow(this)">
                                        </td>
                                        <td class="p-2">
                                            <input type="number" name="items[0][unit_price]" class="w-full rounded border-gray-300 text-sm text-right price-input" placeholder="0" min="0" required oninput="calculateRow(this)">
                                        </td>
                                        <td class="p-2 text-right">
                                            <input type="text" class="w-full bg-gray-100 border-none text-right font-semibold subtotal-display" value="0" readonly>
                                        </td>
                                        <td class="p-2 text-center">
                                            <button type="button" class="text-red-500 font-bold" onclick="removeRow(this)">X</button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="bg-gray-50 font-bold">
                                        <td colspan="5" class="p-2 text-right">TOTAL TRANSAKSI:</td>
                                        <td class="p-2 text-right text-lg text-blue-600" id="grandTotal">Rp 0</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('purchases.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Batal</a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded font-bold hover:bg-blue-700 shadow">SIMPAN & PROSES</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        let itemIndex = 1;

        // Kita simpan opsi kategori dalam variabel JS biar bisa dipakai pas nambah baris baru
        const categoryOptions = `
            <option value="">Pilih...</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
            @endforeach
        `;

        function addItemRow() {
            const tableBody = document.getElementById('itemsBody');
            const newRow = `
                <tr>
                    <td class="p-2">
                        <input type="text" name="items[${itemIndex}][tool_name]" class="w-full rounded border-gray-300 text-sm" placeholder="Nama Barang" required>
                    </td>
                    <td class="p-2">
                        <select name="items[${itemIndex}][category_id]" class="w-full rounded border-gray-300 text-sm" required>
                            ${categoryOptions}
                        </select>
                    </td>
                    <td class="p-2">
                        <input type="text" name="items[${itemIndex}][specification]" class="w-full rounded border-gray-300 text-sm" placeholder="Spek">
                    </td>
                    <td class="p-2">
                        <input type="number" name="items[${itemIndex}][quantity]" class="w-full rounded border-gray-300 text-sm text-center qty-input" value="1" min="1" required oninput="calculateRow(this)">
                    </td>
                    <td class="p-2">
                        <input type="number" name="items[${itemIndex}][unit_price]" class="w-full rounded border-gray-300 text-sm text-right price-input" placeholder="0" min="0" required oninput="calculateRow(this)">
                    </td>
                    <td class="p-2 text-right">
                        <input type="text" class="w-full bg-gray-100 border-none text-right font-semibold subtotal-display" value="0" readonly>
                    </td>
                    <td class="p-2 text-center">
                        <button type="button" class="text-red-500 font-bold" onclick="removeRow(this)">X</button>
                    </td>
                </tr>
            `;
            tableBody.insertAdjacentHTML('beforeend', newRow);
            itemIndex++;
        }

        function removeRow(button) {
            const row = button.closest('tr');
            if(document.querySelectorAll('#itemsBody tr').length > 1) {
                row.remove();
                calculateGrandTotal();
            } else {
                alert("Minimal 1 baris.");
            }
        }

        function calculateRow(inputElement) {
            const row = inputElement.closest('tr');
            const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            const subtotal = qty * price;
            
            // Format tampilan rupiah
            row.querySelector('.subtotal-display').value = subtotal.toLocaleString('id-ID');
            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            let total = 0;
            document.querySelectorAll('#itemsBody tr').forEach(row => {
                const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
                const price = parseFloat(row.querySelector('.price-input').value) || 0;
                total += (qty * price);
            });
            document.getElementById('grandTotal').innerText = "Rp " + total.toLocaleString('id-ID');
        }
    </script>
</x-app-layout>