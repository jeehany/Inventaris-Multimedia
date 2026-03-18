<!DOCTYPE html>
<html>
<head>
    <title>Rekapitulasi Transaksi Vendor</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h2 { text-align: center; margin-bottom: 5px; color: #1e293b; }
        p { text-align: center; margin-top: 0; color: #64748b; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #cbd5e1; padding: 8px 10px; text-align: left; }
        th { background-color: #f1f5f9; color: #334155; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { margin-top: 50px; text-align: right; font-size: 11px; color: #94a3b8; }
        .bg-top { background-color: #e0f2fe; color: #0369a1; }
    </style>
</head>
<body>

    <h2>REKAPITULASI TRANSAKSI SUPPLIER / VENDOR</h2>
    <p>
        @if($startDate && $endDate)
            Periode Transaksi Selesai: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}<br>
        @endif
        Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }}
    </p>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="5%">Peringkat</th>
                <th width="30%">Nama Vendor</th>
                <th width="25%">Kontak / Nomor Telepon</th>
                <th class="text-center" width="15%">Total PO (Selesai)</th>
                <th class="text-right" width="25%">Total Nominal Transaksi (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $totalTrx = 0; $totalVal = 0; @endphp
            @forelse($vendors as $index => $vendor)
                @php 
                    $totalTrx += $vendor->total_transactions;
                    $totalVal += $vendor->total_spent;
                    $isTopVendor = ($index == 0 && $vendor->total_transactions > 0);
                @endphp
                <tr class="{{ $isTopVendor ? 'bg-top' : '' }}">
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $vendor->name }}</strong>
                        @if($isTopVendor)
                            <br><small style="color: #0369a1;">* Vendor Teratas Saat Ini</small>
                        @endif
                    </td>
                    <td>{{ $vendor->phone ?? '-' }}</td>
                    <td class="text-center">{{ $vendor->total_transactions }} Transaksi</td>
                    <td class="text-right">{{ number_format($vendor->total_spent, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data vendor terdaftar.</td>
                </tr>
            @endforelse
            <tr>
                <th colspan="3" class="text-right">TOTAL KESELURUHAN (STATUS SELESAI)</th>
                <th class="text-center">{{ $totalTrx }} Transaksi</th>
                <th class="text-right">{{ number_format($totalVal, 0, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Dihasilkan oleh Sistem Inventaris Multimedia &copy; {{ date('Y') }}
    </div>

</body>
</html>
