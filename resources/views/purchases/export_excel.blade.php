<table>
    {{-- TABLE 1: SUKSES / REALISASI --}}
    <thead>
        <tr>
            <th colspan="11" style="font-weight: bold; font-size: 16px; text-align: center;">LAPORAN REALISASI PENGADAAN (DIBELI)</th>
        </tr>
        <tr>
            <th colspan="11" style="font-style: italic; text-align: center;">Tanggal Unduh: {{ now()->translatedFormat('d F Y') }}</th>
        </tr>
        <tr></tr> {{-- Spacer --}}
        <tr>
            <th style="font-weight: bold; text-align: center; background-color: #8B5CF6; color: white; border: 1px solid black; width: 20px;">Tanggal Selesai</th>
            <th style="font-weight: bold; text-align: center; background-color: #8B5CF6; color: white; border: 1px solid black; width: 20px;">Kode Transaksi</th>
            <th style="font-weight: bold; text-align: center; background-color: #8B5CF6; color: white; border: 1px solid black; width: 25px;">Nama Aset</th>
            <th style="font-weight: bold; text-align: center; background-color: #8B5CF6; color: white; border: 1px solid black; width: 20px;">Vendor</th>
            <th style="font-weight: bold; text-align: center; background-color: #8B5CF6; color: white; border: 1px solid black; width: 20px;">Kategori</th>
            <th style="font-weight: bold; text-align: center; background-color: #8B5CF6; color: white; border: 1px solid black; width: 10px;">Qty</th>
            <th style="font-weight: bold; text-align: center; background-color: #8B5CF6; color: white; border: 1px solid black; width: 20px;">Harga Satuan (Budget)</th>
            <th style="font-weight: bold; text-align: center; background-color: #8B5CF6; color: white; border: 1px solid black; width: 20px;">Total Budget</th>
            <th style="font-weight: bold; text-align: center; background-color: #8B5CF6; color: white; border: 1px solid black; width: 20px;">Harga Satuan (Asli)</th>
            <th style="font-weight: bold; text-align: center; background-color: #8B5CF6; color: white; border: 1px solid black; width: 20px;">Total Realisasi</th>
            <th style="font-weight: bold; text-align: center; background-color: #8B5CF6; color: white; border: 1px solid black; width: 20px;">Selisih (Hemat/Boros)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($completed as $p)
        @php
            $qty = $p->quantity;
            $budget = $p->unit_price;
            $actual = $p->actual_unit_price ?? $p->unit_price;
            $totalBudget = $budget * $qty;
            $totalActual = $actual * $qty;
            $diff = $totalBudget - $totalActual;
        @endphp
        <tr>
            <td style="text-align: center; border: 1px solid black;">{{ \Carbon\Carbon::parse($p->updated_at)->translatedFormat('d F Y') }}</td>
            <td style="text-align: left; border: 1px solid black;">{{ $p->purchase_code }}</td>
            <td style="text-align: left; border: 1px solid black;">{{ $p->tool_name }}</td>
            <td style="text-align: left; border: 1px solid black;">{{ $p->vendor->name ?? '-' }}</td>
            <td style="text-align: left; border: 1px solid black;">{{ $p->category->category_name ?? '-' }}</td>
            <td style="text-align: center; border: 1px solid black;">{{ $qty }}</td>
            <td style="text-align: right; border: 1px solid black;">Rp {{ number_format($budget, 0, ',', '.') }}</td>
            <td style="text-align: right; border: 1px solid black;">Rp {{ number_format($totalBudget, 0, ',', '.') }}</td>
            <td style="text-align: right; border: 1px solid black;">Rp {{ number_format($actual, 0, ',', '.') }}</td>
            <td style="text-align: right; border: 1px solid black;">Rp {{ number_format($totalActual, 0, ',', '.') }}</td>
            <td style="text-align: right; border: 1px solid black;">Rp {{ number_format($diff, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>
<br>

<table>
    {{-- TABLE 2: DITOLAK / REJECTED --}}
    <thead>
        <tr>
            <th colspan="9" style="font-weight: bold; font-size: 16px; text-align: center;">LAPORAN PENGAJUAN DITOLAK</th>
        </tr>
        <tr></tr>
        <tr>
            <th style="font-weight: bold; text-align: center; background-color: #E11D48; color: white; border: 1px solid black;">Tanggal Ditolak</th>
            <th style="font-weight: bold; text-align: center; background-color: #E11D48; color: white; border: 1px solid black;">Kode Transaksi</th>
            <th style="font-weight: bold; text-align: center; background-color: #E11D48; color: white; border: 1px solid black;">Nama Aset</th>
            <th style="font-weight: bold; text-align: center; background-color: #E11D48; color: white; border: 1px solid black;">Vendor</th>
            <th style="font-weight: bold; text-align: center; background-color: #E11D48; color: white; border: 1px solid black;">Kategori</th>
            <th style="font-weight: bold; text-align: center; background-color: #E11D48; color: white; border: 1px solid black;">Qty</th>
            <th style="font-weight: bold; text-align: center; background-color: #E11D48; color: white; border: 1px solid black;">Harga Satuan (Rencana)</th>
            <th style="font-weight: bold; text-align: center; background-color: #E11D48; color: white; border: 1px solid black;">Total Budget</th>
            <th style="font-weight: bold; text-align: center; background-color: #E11D48; color: white; border: 1px solid black;">Alasan Penolakan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rejected as $p)
        @php
            $qty = $p->quantity;
            $budget = $p->unit_price;
            $totalBudget = $budget * $qty;
        @endphp
        <tr>
            <td style="text-align: center; border: 1px solid black;">{{ \Carbon\Carbon::parse($p->updated_at)->translatedFormat('d F Y') }}</td>
            <td style="text-align: left; border: 1px solid black;">{{ $p->purchase_code }}</td>
            <td style="text-align: left; border: 1px solid black;">{{ $p->tool_name }}</td>
            <td style="text-align: left; border: 1px solid black;">{{ $p->vendor->name ?? '-' }}</td>
            <td style="text-align: left; border: 1px solid black;">{{ $p->category->category_name ?? '-' }}</td>
            <td style="text-align: center; border: 1px solid black;">{{ $qty }}</td>
            <td style="text-align: right; border: 1px solid black;">Rp {{ number_format($budget, 0, ',', '.') }}</td>
            <td style="text-align: right; border: 1px solid black;">Rp {{ number_format($totalBudget, 0, ',', '.') }}</td>
            <td style="text-align: left; border: 1px solid black; color: #E11D48; font-style: italic;">{{ $p->rejection_note ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
