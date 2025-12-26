<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman Alat</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; font-size: 18px; }
        .header h3 { margin: 5px 0; font-size: 14px; }
        .header p { margin: 5px 0; font-size: 10px; font-style: italic;}
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; vertical-align: top; }
        th { background-color: #e0e0e0; }
        .status-active { color: #d97706; font-weight: bold; }
        .status-returned { color: #16a34a; font-weight: bold; }
        .footer { margin-top: 40px; text-align: right; font-size: 11px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>HM COMPANY OFFICIAL</h2>
        <h3>LAPORAN PEMINJAMAN ALAT MULTIMEDIA</h3>
        <p>Dicetak Tanggal: {{ now()->format('d M Y, H:i') }} oleh {{ auth()->user()->name }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 20%;">Peminjam</th>
                <th style="width: 25%;">Daftar Alat</th>
                <th style="width: 12%;">Tgl Pinjam</th>
                <th style="width: 12%;">Rencana Kembali</th>
                <th style="width: 12%;">Tgl Kembali</th>
                <th style="width: 14%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($borrowings as $index => $item)
                <tr>
                    <td style="text-align: center">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item->borrower->name }}</strong><br>
                        <span style="color:#555; font-size:10px">ID: {{ $item->borrower->code ?? '-' }}</span>
                    </td>
                    <td>
                        @if($item->items && $item->items->count() > 0)
                            <ul style="margin: 0; padding-left: 15px;">
                                @foreach($item->items as $detail)
                                    <li>
                                        {{ $detail->tool->tool_name ?? $detail->tool->name ?? 'Nama Alat Tidak Ditemukan' }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            -
                        @endif
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
                        Tidak ada data peminjaman.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Mengetahui,</p>
        <p>Kepala Divisi/Manajer</p>
        <br><br><br>
        <p>(........................................)</p>
    </div>
</body>
</html>