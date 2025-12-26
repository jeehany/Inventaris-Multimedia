<!DOCTYPE html>
<html>
<head>
    <title>Laporan Inventaris Alat</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; font-size: 18px; }
        .header h3 { margin: 5px 0; font-size: 14px; }
        .header p { margin: 5px 0; font-size: 10px; font-style: italic;}
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; vertical-align: top; }
        th { background-color: #e0e0e0; }
        
        /* Warna Status */
        .status-good { color: #16a34a; font-weight: bold; } /* Hijau */
        .status-bad { color: #dc2626; font-weight: bold; }  /* Merah */
        .status-warn { color: #d97706; font-weight: bold; } /* Orange */
        
        .footer { margin-top: 40px; text-align: right; font-size: 11px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>HM COMPANY OFFICIAL</h2>
        <h3>LAPORAN INVENTARIS ALAT</h3>
        <p>Dicetak Tanggal: {{ now()->format('d M Y, H:i') }} oleh {{ auth()->user()->name }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 15%;">Kode Alat</th>
                <th style="width: 30%;">Nama Alat</th>
                <th style="width: 20%;">Kategori</th>
                <th style="width: 15%;">Kondisi</th>
                <th style="width: 15%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tools as $index => $tool)
                <tr>
                    <td style="text-align: center">{{ $index + 1 }}</td>
                    <td style="font-family: monospace;">{{ $tool->tool_code }}</td>
                    <td>{{ $tool->tool_name }}</td>
                    <td>{{ $tool->category->category_name ?? '-' }}</td>
                    <td>
                        @if($tool->current_condition == 'Baik')
                            <span class="status-good">Baik</span>
                        @else
                            <span class="status-bad">Rusak</span>
                        @endif
                    </td>
                    <td>
                        @if($tool->availability_status == 'available')
                            <span class="status-good">Tersedia</span>
                        @elseif($tool->availability_status == 'borrowed')
                            <span class="status-warn">Dipinjam</span>
                        @elseif($tool->availability_status == 'maintenance')
                            <span class="status-bad">Maintenance</span>
                        @else
                            {{ ucfirst($tool->availability_status) }}
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding: 20px;">
                        Data alat tidak ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Mengetahui,</p>
        <p>Kepala Divisi/Manag</p>
        <br><br><br>
        <p>(........................................)</p>
    </div>
</body>
</html>