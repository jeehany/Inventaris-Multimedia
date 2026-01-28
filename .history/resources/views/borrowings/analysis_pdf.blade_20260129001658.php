<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Analisa Peminjaman</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 12px; }
        
        .meta { margin-bottom: 15px; font-size: 11px; }
        .meta table { border: none; width: 100%; margin: 0; }
        .meta td { border: none; padding: 2px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; vertical-align: top; }
        th { background-color: #fce7f3; font-weight: bold; text-align: center; color: #831843; }
        
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
                <td>Analisa Peminjaman</td>
                <td style="width: 15%"><strong>Dicetak Oleh</strong></td>
                <td style="width: 2%">:</td>
                <td>{{ optional(auth()->user())->name ?? 'Admin' }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Cetak</strong></td>
                <td>:</td>
                <td>{{ now()->translatedFormat('d F Y, H:i') }}</td>
                <td><strong>Periode</strong></td>
                <td>:</td>
                <td>{{ request('start_date') }} s/d {{ request('end_date') }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Kode Pinjam</th>
                <th width="15%">Peminjam</th>
                <th width="15%">Tanggal Pinjam</th>
                <th width="15%">Tanggal Kembali</th>
                <th width="15%">Item Dipinjam</th>
                <th width="10%">Status</th>
                <th width="15%">Analisa Waktu</th>
            </tr>
        </thead>
        <tbody>
            @forelse($borrowings as $index => $b)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $b->borrowing_code }}</td>
                <td>
                    <strong>{{ $b->borrower->name ?? 'Umum' }}</strong><br>
                    <small>{{ $b->borrower->department ?? '-' }}</small>
                </td>
                <td class="text-center">{{ \Carbon\Carbon::parse($b->borrow_date)->translatedFormat('d M Y') }}</td>
                <td class="text-center">
                    {{ $b->return_date ? \Carbon\Carbon::parse($b->return_date)->translatedFormat('d M Y') : '-' }}
                </td>
                <td>
                   <ul style="margin: 0; padding-left: 15px;">
                       @foreach($b->items as $item)
                        <li>{{ $item->tool->tool_name ?? '?' }} <small>({{ $item->tool->tool_code ?? '' }})</small></li>
                       @endforeach
                   </ul>
                </td>
                <td class="text-center">
                    @if($b->borrowing_status == 'active') <span style="color: blue; font-weight:bold;">Aktif</span>
                    @elseif($b->borrowing_status == 'returned') <span style="color: green; font-weight:bold;">Kembali</span>
                    @elseif($b->borrowing_status == 'overdue') <span style="color: red; font-weight:bold;">Terlambat</span>
                    @else {{ $b->borrowing_status }}
                    @endif
                </td>
                <td class="text-center">
                    @php
                        $planned = \Carbon\Carbon::parse($b->planned_return_date);
                        $actual = $b->actual_return_date ? \Carbon\Carbon::parse($b->actual_return_date) : now();
                        $diff = $planned->diffInDays($actual, false); // Positif = Telat, Negatif = Early/OnTime
                    @endphp

                    @if($b->borrowing_status == 'returned')
                        @if($diff > 0)
                            <span style="color: red;">Telat {{ $diff }} Hari</span>
                        @else
                            <span style="color: green;">Tepat Waktu</span>
                        @endif
                    @else
                        {{-- ACTIVE --}}
                        @if($diff > 0)
                            <span style="color: red;">Telat {{ $diff }} Hari</span><br>
                            <span style="font-size: 9px; color: #555;">(Belum Kembali)</span>
                        @else
                            <span style="color: blue;">Sisa {{ abs($diff) }} Hari</span>
                        @endif
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
            <p>Kepala Laboratorium</p>
            <div class="signature-line">{{ auth()->user()->name ?? '(..........................)' }}</div>
            <p>NIP. ..........................</p>
        </div>
    </div>
</body>
</html>
