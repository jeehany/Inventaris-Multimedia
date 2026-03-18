<!DOCTYPE html>
<html>
<head>
    <title>Rekap Kerusakan Aset per Kategori</title>
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
        .bg-red { background-color: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>

    <h2>REKAPITULASI KERUSAKAN ASET PER KATEGORI</h2>
    <p>
        @if($startDate && $endDate)
            Periode Servis: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}<br>
        @endif
        Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }}
    </p>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="35%">Kategori Barang</th>
                <th class="text-center" width="20%">Total Terdaftar</th>
                <th class="text-center" width="20%">Frekuensi Diservis (x)</th>
                <th class="text-right" width="20%">Total Biaya Maint. (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $totalTools = 0; $totalMaintFreq = 0; $totalCost = 0; @endphp
            @forelse($categories as $index => $cat)
                @php 
                    $totalTools += $cat->tools_count;
                    $totalMaintFreq += $cat->maintenance_count;
                    $totalCost += $cat->total_repair_cost;
                    $isMostDamaged = ($index == 0 && $cat->maintenance_count > 0);
                @endphp
                <tr class="{{ $isMostDamaged ? 'bg-red' : '' }}">
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $cat->category_name }}</strong>
                        @if($isMostDamaged)
                            <br><small style="color: #dc2626;">* Kategori Paling Rawan Rusak</small>
                        @endif
                    </td>
                    <td class="text-center">{{ $cat->tools_count }} Unit</td>
                    <td class="text-center">{{ $cat->maintenance_count }} Kali</td>
                    <td class="text-right">{{ number_format($cat->total_repair_cost, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data kategori terdaftar.</td>
                </tr>
            @endforelse
            <tr>
                <th colspan="2" class="text-right">TOTAL KESELURUHAN</th>
                <th class="text-center">{{ $totalTools }} Unit</th>
                <th class="text-center">{{ $totalMaintFreq }} Kali</th>
                <th class="text-right">{{ number_format($totalCost, 0, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Dihasilkan oleh Sistem Inventaris Multimedia &copy; {{ date('Y') }}
    </div>

</body>
</html>
