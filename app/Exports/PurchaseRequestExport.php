<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PurchaseRequestExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
    }

    public function map($purchase): array
    {
        $qty = $purchase->items ? $purchase->items->sum('quantity') : 0;
        $subtotal = $purchase->total_amount;
        $toolNames = $purchase->items ? implode("\n", $purchase->items->map(fn($i) => "- " . $i->tool_name . " (" . $i->quantity . " unit)")->toArray()) : '-';

        // Translate Status
        $status = match($purchase->status) {
            'pending' => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'completed' => 'Selesai',
            default => $purchase->status
        };

        return [
            \Carbon\Carbon::parse($purchase->date)->translatedFormat('d F Y'),
            $purchase->purchase_code,
            $toolNames,
            $purchase->vendor ? $purchase->vendor->name : '-',
            $qty,
            "-", // Harga Satuan (Estimasi) is mixed
            "Rp " . number_format($subtotal, 0, ',', '.'),
            $status,
            $purchase->status == 'rejected' ? ($purchase->rejection_note ?? '-') : '-'
        ];
    }

    public function headings(): array
    {
        return [
            ['LAPORAN PENGAJUAN PENGADAAN (REQUEST)'],
            ['Tanggal Unduh: ' . now()->translatedFormat('d F Y')],
            [''],
            [
                'Tanggal Pengajuan',
                'Kode Transaksi',
                'Nama Barang',
                'Vendor',
                'Qty',
                'Harga Satuan (Estimasi)',
                'Total Estimasi',
                'Status Saat Ini',
                'Catatan (Jika Ditolak)',
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');

        // Title
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1E293B']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true, 'size' => 11, 'color' => ['rgb' => '64748B']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Header (BLUE THEME)
        $sheet->getStyle('A4:I4')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2563EB']], // Blue 600
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);

        // Borders
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A4:I' . $highestRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        // Alignment
        $sheet->getStyle('F5:G' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('A5:A' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E5:E' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('H5:H' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [];
    }
}
