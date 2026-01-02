<?php

namespace App\Exports;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PurchaseRejectedSheet implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Purchase::with(['vendor', 'user', 'category'])
                         ->where('status', 'rejected');

        // Apply shared filters
        // 1. Check Status Filter: Jika user filter 'completed', Sheet Rejected harusnya KOSONG
        if (!empty($this->filters['status']) && $this->filters['status'] == 'completed') {
            $query->whereRaw('1 = 0'); // Force Empty
        }

        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('purchase_code', 'LIKE', "%{$search}%")
                  ->orWhere('tool_name', 'LIKE', "%{$search}%")
                  ->orWhereHas('vendor', function($v) use ($search) {
                      $v->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }
        if (!empty($this->filters['month'])) {
            $query->whereMonth('updated_at', $this->filters['month']);
        }
        if (!empty($this->filters['year'])) {
            $query->whereYear('updated_at', $this->filters['year']);
        }

        return $query->orderBy('updated_at', 'desc');
    }

    public function map($purchase): array
    {
        $qty = $purchase->quantity;
        $budgetPrice = $purchase->unit_price;
        $totalBudget = $budgetPrice * $qty;

        return [
            \Carbon\Carbon::parse($purchase->updated_at)->translatedFormat('d F Y'),
            $purchase->purchase_code,
            $purchase->tool_name,
            $purchase->vendor ? $purchase->vendor->name : '-',
            $qty,
            "Rp " . number_format($budgetPrice, 0, ',', '.'),
            "Rp " . number_format($totalBudget, 0, ',', '.'),
            $purchase->rejection_note ?? '-',
            'Ditolak'
        ];
    }

    public function headings(): array
    {
        return [
            ['LAPORAN PENGAJUAN DITOLAK'],
            ['Tanggal Unduh: ' . now()->translatedFormat('d F Y')],
            [''],
            [
                'Tanggal Ditolak',
                'Kode Transaksi',
                'Nama Barang',
                'Vendor',
                'Qty',
                'Harga Satuan (Rencana)',
                'Total Budget',
                'Alasan Penolakan',
                'Status',
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');

        // Title Style
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1E293B']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true, 'size' => 11, 'color' => ['rgb' => '64748B']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Header Style (ROSE/RED)
        $sheet->getStyle('A4:I4')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E11D48']], // Rose 600
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);

        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A4:I' . $highestRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        $sheet->getStyle('F5:G' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('A5:A' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E5:E' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('I5:I' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [];
    }

    public function title(): string
    {
        return 'Ditolak (Rejected)';
    }
}
