<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Pemeliharaan Aset</title>
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
        th { background-color: #e5e7eb; font-weight: bold; text-align: center; color: #1f2937; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .footer { margin-top: 40px; width: 100%; }
        .signature-box { float: right; width: 250px; text-align: center; }
        .signature-box p { margin: 5px 0; }
        .signature-line { margin-top: 60px; border-bottom: 1px solid #333; font-weight: bold; }

        .status-badge { font-weight: bold; font-size: 10px; padding: 2px 5px; border-radius: 4px; display: inline-block; }
    </style>
</head>
<body>
    <div class="header">
        <table style="width: 100%; border: none; margin-bottom: 0;">
            <tr>
                <td style="width: 60px; border: none; text-align: center; vertical-align: middle;">
                    @php $logoPath = public_path('images/logo.png'); @endphp
                    @if(file_exists($logoPath))
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents($logoPath)) }}" style="height: 60px; width: auto;">
                    @else
                       <span style="font-weight:bold; font-size:12px;">LOGO</span>
                    @endif
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
                <td>Pemeliharaan & Perbaikan Aset (Maintenance)</td>
                <td style="width: 15%"><strong>Dicetak Oleh</strong></td>
                <td style="width: 2%">:</td>
                <td>{{ optional(auth()->user())->name ?? 'Admin' }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Cetak</strong></td>
                <td>:</td>
                <td>{{ now()->translatedFormat('d F Y, H:i') }}</td>
                <td><strong>Filter Status</strong></td>
                <td>:</td>
                <td>{{ request('status') ? (request('status')=='completed'?'Selesai':'Sedang Proses') : 'Semua Status' }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="12%">Tanggal</th>
                <th width="20%">Aset</th>
                <th width="15%">Jenis Pemeliharaan</th>
                <th width="20%">Keluhan</th>
                <th width="15%">Tindakan & Biaya</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($maintenances as $index => $mt)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">
                    {{ \Carbon\Carbon::parse($mt->start_date)->translatedFormat('d M Y') }}
                    @if($mt->end_date)
                    <br><small>s/d {{ \Carbon\Carbon::parse($mt->end_date)->format('d M y') }}</small>
                    @endif
                </td>
                <td>
                    <strong>{{ $mt->tool->tool_name ?? 'Item Terhapus' }}</strong><br>
                    <small>{{ $mt->tool->tool_code ?? '-' }}</small>
                </td>
                <td class="text-center">{{ $mt->type->name ?? '-' }}</td>
                <td>{{ $mt->note }}</td>
                <td>
                    {{ $mt->action_taken ?? '-' }}<br>
                    @if($mt->cost > 0)
                    <strong style="color: #047857;">Rp {{ number_format($mt->cost, 0, ',', '.') }}</strong>
                    @endif
                </td>
                <td class="text-center">
                    @if($mt->status == 'completed')
                        <span style="color: green;">SELESAI</span>
                    @else
                        <span style="color: orange;">PROSES</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data pemeliharaan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-box">
            <p>Mengetahui,</p>
            <p>Kepala Manajemen Inventaris</p>
            <div class="signature-line">{{ auth()->user()->name ?? '(..........................)' }}</div>
            <p>NIP. ..........................</p>
        </div>
    </div>
</body>
</html>
