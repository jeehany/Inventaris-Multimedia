<!DOCTYPE html>
<html>
<head>
    <title>Laporan Nilai Aset / Depresiasi</title>
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
        .val-good { color: #059669; font-weight: bold; }
        .val-bad { color: #dc2626; font-weight: bold; }
    </style>
</head>
<body>

    <h2>LAPORAN NILAI ASET & BEBAN PERAWATAN</h2>
    <p>Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="15%">Kode Aset</th>
                <th width="25%">Nama Aset</th>
                <th width="15%">Kategori</th>
                <th class="text-right" width="15%">Harga Beli Awal (Rp)</th>
                <th class="text-right" width="15%">Total Servis (Rp)</th>
                <th class="text-right" width="15%">Valuasi Saat Ini (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $totalInit = 0; $totalMaint = 0; $totalVal = 0; @endphp
            @forelse($tools as $index => $t)
                @php 
                    $totalInit += $t->initial_price ?? 0;
                    $totalMaint += $t->total_maintenance_cost;
                    $totalVal += $t->current_valuation;
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $t->tool_code }}</td>
                    <td>{{ $t->tool_name }}</td>
                    <td>{{ $t->category_name ?? '-' }}</td>
                    <td class="text-right">{{ number_format($t->initial_price ?? 0, 0, ',', '.') }}</td>
                    <td class="text-right {{ $t->total_maintenance_cost > 0 ? 'val-bad' : '' }}">
                        {{ number_format($t->total_maintenance_cost, 0, ',', '.') }}
                    </td>
                    <td class="text-right val-good">{{ number_format($t->current_valuation, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data aset terdaftar.</td>
                </tr>
            @endforelse
            <tr>
                <th colspan="4" class="text-right">TOTAL KESELURUHAN (RP)</th>
                <th class="text-right">{{ number_format($totalInit, 0, ',', '.') }}</th>
                <th class="text-right val-bad">{{ number_format($totalMaint, 0, ',', '.') }}</th>
                <th class="text-right val-good">{{ number_format($totalVal, 0, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Dihasilkan oleh Sistem Inventaris Multimedia &copy; {{ date('Y') }}
    </div>

</body>
</html>
