<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="border-b pb-4 mb-4 flex justify-between items-start">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">Nota Pembelian</h3>
                            <p class="text-sm text-gray-500">Dibuat oleh: {{ $purchase->user->name ?? '-' }}</p>
                        </div>
                        <div class="text-right">
                            <span class="block text-sm text-gray-500">Tanggal</span>
                            <span class="font-bold">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d F Y') }}</span>
                            <div class="mt-2">
                                <span class="px-3 py-1 text-xs font-bold rounded-full {{ $purchase->status == 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ strtoupper($purchase->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6 bg-gray-50 p-4 rounded">
                        <h4 class="font-bold text-sm text-gray-500 uppercase">Supplier / Vendor</h4>
                        <p class="text-lg font-semibold">{{ $purchase->vendor->name }}</p>
                        <p class="text-gray-600">{{ $purchase->vendor->address }}</p>
                        <p class="text-gray-600">{{ $purchase->vendor->phone }}</p>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-bold text-sm text-gray-500 uppercase mb-2">Rincian Barang</h4>
                        <table class="min-w-full border">
                            <thead class="bg-gray-100 border-b">
                                <tr>
                                    <th class="px-4 py-2 text-left">Nama Barang</th>
                                    <th class="px-4 py-2 text-left">Spesifikasi</th>
                                    <th class="px-4 py-2 text-center">Qty</th>
                                    <th class="px-4 py-2 text-right">Harga Satuan</th>
                                    <th class="px-4 py-2 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchase->items as $item)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ $item->tool_name }}</td>
                                    <td class="px-4 py-2 text-gray-500 text-sm">{{ $item->specification }}</td>
                                    <td class="px-4 py-2 text-center">{{ $item->quantity }}</td>
                                    <td class="px-4 py-2 text-right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-right font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-gray-50">
                                    <td colspan="4" class="px-4 py-3 text-right font-bold">TOTAL PEMBELIAN</td>
                                    <td class="px-4 py-3 text-right font-bold text-lg text-blue-600">
                                        Rp {{ number_format($purchase->total_amo, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="flex justify-start">
                        <a href="{{ route('purchases.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                            &larr; Kembali
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>