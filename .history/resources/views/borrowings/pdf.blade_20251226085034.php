<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman Alat</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .header p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
        .status-active { color: #d97706; font-weight: bold; } /* Orange */
        .status-returned { color: #16a34a; font-weight: bold; } /* Green */
        .footer { margin-top: 30px; text-align: right; font-size: 11px; }
    </style>
</head>
<body>
    <div class="header">
        <h3>LAPORAN PEMINJAMAN ALAT MULTIMEDIA</h3>
        <h4>HM COMPANY OFFICIAL</h4>
        <p>Dicetak Tanggal: {{ now()->format('d M Y, H:i') }} oleh {{ auth()->user()->name }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th>Peminjam</th>
                <th>Daftar Alat</th>
                <th>Tgl Pinjam</th>
                <th>Rencana Kembali</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($borrowings as $index => $item)
                <tr>
                    <td style="text-align: center">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item->borrower->name }}</strong><br>
                        <span style="color:#666; font-size:10px">{{ $item->borrower->code }}</span>
                    </td>
                    <td>
                        @foreach($item->items as $detail)
                            - {{ $detail->tool->name }} <br>
                        @endforeach
                    </td>
                    <td>{{ \Carbon\Carbon::parse($item->borrow_date)->format('d/m/y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->planned_return_date)->format('d/m/y') }}</td>
                    <td>
                        @if($item->actual_return_date)
                            {{ \Carbon\Carbon::parse($item->actual_return_date)->format('d/m/y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($item->borrowing_status == 'active')
                            <span class="status-active">Dipinjam</span>
                        @else
                            <span class="status-returned">Kembali</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding: 20px;">
                        Tidak ada data peminjaman untuk periode/filter ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Mengetahui,<br>Kepala Laboratorium/Bengkel</p>
        <br><br><br>
        <p>(........................................)</p>
    </div>
</body>
</html>