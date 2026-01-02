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

class PurchaseCompletedSheet implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Purchase::with(['vendor', 'user', 'category'])
                         ->where('is_purchased', true);

        // Apply shared filters
        // 1. Check Status Filter: Jika user filter 'rejected', Sheet Completed harusnya KOSONG
        if (!empty($this->filters['status']) && $this->filters['status'] == 'rejected') {
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
        $actualPrice = $purchase->actual_unit_price ?? $purchase->unit_price;
        
        $totalBudget = $budgetPrice * $qty;
        $totalActual = $actualPrice * $qty;
        $diff = $totalBudget - $totalActual; // Positif = Hemat

        return [
            \Carbon\Carbon::parse($purchase->updated_at)->translatedFormat('d F Y'),
            $purchase->purchase_code,
            $purchase->tool_name,
            $purchase->vendor ? $purchase->vendor->name : '-',
            $qty,
            "Rp " . number_format($budgetPrice, 0, ',', '.'),
            "Rp " . number_format($totalBudget, 0, ',', '.'),
            "Rp " . number_format($actualPrice, 0, ',', '.'),
            "Rp " . number_format($totalActual, 0, ',', '.'),
            "Rp " . number_format($diff, 0, ',', '.'),
            'Selesai'
        ];
    }

    public function headings(): array
    {
        return [
            ['LAPORAN REALISASI PENGADAAN (DIBELI)'],
            ['Tanggal Unduh: ' . now()->translatedFormat('d F Y')],
            [''],
            [
                'Tanggal Selesai',
                'Kode Transaksi',
                'Nama Barang',
                'Vendor',
                'Qty',
                'Harga Satuan (Budget)',
                'Total Budget',
                'Harga Satuan (Asli)',
                'Total Realisasi',
                'Selisih (Hemat/Boros)',
                'Status',
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:K1');
        $sheet->mergeCells('A2:K2');

        // Title Style
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1E293B']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true, 'size' => 11, 'color' => ['rgb' => '64748B']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Header Style (VIOLET)
        $sheet->getStyle('A4:K4')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '8B5CF6']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);

        // Borders & Alignment
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A4:K' . $highestRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        // Right Align Money
        $sheet->getStyle('F5:J' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        // Center Align Others
        $sheet->getStyle('A5:A' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E5:E' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('K5:K' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [];
    }

    public function title(): string
    {
        return 'Realisasi (Succcess)';
    }
}
