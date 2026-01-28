<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Aset Terhapus</title>
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
        th { background-color: #fff0f0; font-weight: bold; text-align: center; color: #990000; }
        
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
                    <img src="{{ public_path('images/logo.png') }}" style="height: 60px; width: auto;">
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
                <td style="color: red;"><strong>Aset Terhapus (Trash)</strong></td>
                <td style="width: 15%"><strong>Dicetak Oleh</strong></td>
                <td style="width: 2%">:</td>
                <td>{{ optional(auth()->user())->name ?? 'Admin' }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Cetak</strong></td>
                <td>:</td>
                <td>{{ now()->translatedFormat('d F Y, H:i') }}</td>
                <td><strong>Total Item</strong></td>
                <td>:</td>
                <td>{{ $tools->count() }} Item</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Kode Aset</th>
                <th width="30%">Nama Barang & Merk</th>
                <th width="20%">Kategori</th>
                <th width="15%">Tanggal Dihapus</th>
                <th width="15%">Kondisi Terakhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tools as $index => $tool)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $tool->tool_code }}</td>
                <td>
                    <strong>{{ $tool->tool_name }}</strong><br>
                    <small>{{ $tool->brand ?? '-' }}</small>
                </td>
                <td class="text-center">{{ $tool->category->category_name ?? '-' }}</td>
                <td class="text-center">{{ $tool->deleted_at ? \Carbon\Carbon::parse($tool->deleted_at)->translatedFormat('d/m/Y H:i') : '-' }}</td>
                <td class="text-center">{{ $tool->current_condition }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data aset terhapus.</td>
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
