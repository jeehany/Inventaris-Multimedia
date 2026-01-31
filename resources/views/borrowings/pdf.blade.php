<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Peminjaman</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .header { margin-bottom: 25px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .meta { margin-bottom: 15px; font-size: 11px; }
        .meta table { border: none; width: 100%; margin: 0; }
        .meta td { border: none; padding: 2px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; vertical-align: top; }
        th { background-color: #e5e7eb; font-weight: bold; text-align: center; color: #1f2937; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .footer { margin-top: 40px; width: 100%; }
        .signature-box { float: right; width: 250px; text-align: center; }
        .signature-box p { margin: 5px 0; }
        .signature-line { margin-top: 60px; border-bottom: 1px solid #333; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <table style="width: 100%; border: none; margin-bottom: 0;">
            <tr>
                <td style="width: 60px; border: none; text-align: center; vertical-align: middle;">
                    <img src="{{ $logo }}" style="height: 60px; width: auto;">
                </td>
                <td style="border: none; text-align: center; vertical-align: middle;">
                    <h1 style="margin: 0; font-size: 18px; text-transform: uppercase;">HM COMPANY</h1>
                    <p style="margin: 2px 0; font-size: 12px;">INVENTORY MANAGEMENT SYSTEM</p>
                    <p style="margin: 2px 0; font-size: 12px;">Laporan Resmi Sistem Informasi Inventaris</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="meta">
        <table style="width: 100%">
            <tr>
                <td style="width: 20%"><strong>Laporan</strong></td>
                <td style="width: 2%">:</td>
                <td>Data Peminjaman Aset (Borrowing)</td>
                <td style="width: 15%"><strong>Dicetak Oleh</strong></td>
                <td style="width: 2%">:</td>
                <td>{{ optional(auth()->user())->name ?? 'Admin' }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Cetak</strong></td>
                <td>:</td>
                <td>{{ now()->translatedFormat('d F Y, H:i') }}</td>
                <td><strong>Total Record</strong></td>
                <td>:</td>
                <td>{{ $borrowings->count() }} Data</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Kode Pinjam</th>
                <th width="20%">Peminjam</th>
                <th width="15%">Tanggal Pinjam</th>
                <th width="15%">Rencana Kembali</th>
                <th width="20%">Aset</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($borrowings as $index => $b)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $b->borrowing_code ?? '-' }}</td>
                <td>
                    <strong>{{ $b->borrower->name ?? 'Umum' }}</strong><br>
                    <small>{{ $b->borrower->department ?? '-' }}</small>
                </td>
                <td class="text-center">{{ \Carbon\Carbon::parse($b->borrow_date)->translatedFormat('d M Y') }}</td>
                <td class="text-center">{{ $b->planned_return_date ? \Carbon\Carbon::parse($b->planned_return_date)->translatedFormat('d M Y') : '-' }}</td>
                <td>
                   <ul style="margin: 0; padding-left: 15px;">
                       @foreach($b->items as $item)
                        <li>{{ $item->tool->tool_name ?? '?' }}</li>
                       @endforeach
                   </ul>
                </td>
                <td class="text-center">
                    @if($b->borrowing_status == 'active') <span style="color: blue;">Dipinjam</span>
                    @elseif($b->borrowing_status == 'returned') <span style="color: green;">Kembali</span>
                    @elseif($b->borrowing_status == 'overdue') <span style="color: red;">Terlambat</span>
                    @else {{ $b->borrowing_status }}
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data peminjaman.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-box">
            <p>Mengetahui,</p>
            <p>Kepala Manajemen Inventaris</p>
            <div class="signature-line">{{ optional(auth()->user())->name ?? '(..........................)' }}</div>
            <p>NIP. ..........................</p>
        </div>
    </div>
</body>
</html>
