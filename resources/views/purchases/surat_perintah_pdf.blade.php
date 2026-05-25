<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Perintah Pengadaan</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; line-height: 1.5; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 15px; margin-bottom: 25px; }
        .logo-container { width: 100%; text-align: center; margin-bottom: 10px; }
        .logo-container img { max-height: 70px; }
        .title { font-size: 16px; font-weight: bold; margin: 10px 0 5px; text-transform: uppercase; text-decoration: underline; }
        .subtitle { font-size: 12px; margin-bottom: 20px; text-align: center; }
        .content { margin-bottom: 30px; }
        .user-info p { margin: 3px 0; }
        .table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .table th, .table td { border: 1px solid #333; padding: 8px; text-align: left; }
        .table th { background-color: #f4f4f4; text-align: center; }
        .qr-section { margin-top: 40px; text-align: right; }
        .qr-container { display: inline-block; text-align: center; border: 1px dashed #ccc; padding: 10px; }
        .qr-container img { width: 80px; height: 80px; }
        .qr-note { font-size: 10px; color: #666; margin-top: 5px; }
        .grand-total { font-weight: bold; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        @if($logo)
            <div class="logo-container">
                <img src="{{ $logo }}" alt="Logo Instansi">
            </div>
        @else
            <h2>DIVISI MULTIMEDIA & INVENTARIS</h2>
        @endif
        <div class="title">Surat Perintah Pengadaan Aset</div>
        <div class="subtitle">Nomor Pendaftaran: {{ $purchase->purchase_code }}</div>
    </div>

    <div class="content">
        <p>Berdasarkan pengajuan per tanggal <strong>{{ \Carbon\Carbon::parse($purchase->date)->format('d F Y') }}</strong>, maka dengan ini Kepala Divisi secara sah memberi perintah kepada Staf di bawah ini:</p>
        
        <div class="user-info">
            <p><strong>Nama Staf Pelaksana :</strong> {{ $purchase->user->name }}</p>
            <p><strong>Jabatan / Peran :</strong> {{ strtoupper($purchase->user->role) }}</p>
            <p><strong>Email :</strong> {{ $purchase->user->email }}</p>
        </div>

        <p>Untuk melaksanakan pembelian fisik dan berhak atas pencairan dana pada sistem pelaporan keuangan (Bendahara) terkait rincian inventaris berikut:</p>

        <table class="table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="35%">Nama & Kategori Aset</th>
                    <th width="10%">Qty</th>
                    <th width="20%">Estimasi Harga Satuan</th>
                    <th width="30%">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchase->items as $index => $item)
                <tr>
                    <td style="text-align: center">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item->tool_name }}</strong><br>
                        <span style="font-size: 10px">{{ $item->category->category_name ?? '-' }} ({{ $item->specification }})</span>
                    </td>
                    <td style="text-align: center">{{ $item->quantity }}</td>
                    <td style="text-align: right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td style="text-align: right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="4" class="grand-total">GRAND TOTAL ESTIMASI</td>
                    <td style="text-align: right; font-weight: bold; color: #4338ca;">
                        Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>

        <p>Surat ini menjadi landasan absoh agar pencairan uang oleh Bendahara dijalankan kepada Staf terkait secara manual/langsung. Usai barang terbeli atau diserah-terimakan, Staf yang ditugaskan <strong>wajib</strong> mengunggah nota asli kwitansi beserta menginput nominal riil pembelian ke dalam Sistem Inventarisasi Multimedia paling lambat 1x24 jam.</p>
    </div>

    <div class="qr-section">
        <div style="margin-bottom: 5px; font-weight: bold;">Telah Diotorisasi & Disetujui Otomatis Secara Elektronik oleh:</div>
        <div style="margin-bottom: 10px;">Kepala Divisi Multimedia</div>
        <div class="qr-container">
            <img src="{{ $qrUrl }}" alt="QR Code Otorisasi">
            <div class="qr-note">
                VALID SYSTEM TICKET<br>
                Status: {{ strtoupper($purchase->status) }}
            </div>
        </div>
        <div style="font-size: 11px; margin-top: 10px;">
            Terbit: {{ now()->format('d/m/Y H:i:s') }}
        </div>
    </div>
</body>
</html>
