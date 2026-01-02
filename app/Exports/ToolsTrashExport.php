<?php

namespace App\Exports;

use App\Models\Tool;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ToolsTrashExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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

    public function map($tool): array
    {
        return [
            $tool->tool_code,
            $tool->tool_name,
            $tool->deleted_at ? \Carbon\Carbon::parse($tool->deleted_at)->translatedFormat('d F Y') : '-',
            $tool->disposal_reason ?? 'Tidak ada alasan',
        ];
    }

    public function headings(): array
    {
        return [
            ['LAPORAN ITEM TERHAPUS (SAMPAH)'],
            ['Tanggal Unduh: ' . now()->translatedFormat('d F Y')],
            [''], // Spasi baris kosong
            [
                'Kode Aset',
                'Nama Barang',
                'Tanggal Dihapus',
                'Alasan Musnah',
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // 1. Merge Title (Baris 1 & 2) -> Sampai Kolom D
        $sheet->mergeCells('A1:D1');
        $sheet->mergeCells('A2:D2');

        // 2. Style Title (Header Utama)
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
                'color' => ['rgb' => '1E293B'], // Slate 800
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // 3. Style Tanggal (Sub Header)
        $sheet->getStyle('A2')->applyFromArray([
            'font' => [
                'italic' => true,
                'size' => 11,
                'color' => ['rgb' => '64748B'], // Slate 500
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // 4. Style Header Tabel (Baris 4)
        $sheet->getStyle('A4:D4')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E11D48'], // Rose 600 (Tetap Merah untuk Sampah)
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // 5. Border Table
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A4:D' . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // 6. Center alignment untuk Kode dan Tanggal
        // A=Kode, C=Tanggal
        $sheet->getStyle('A5:A' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C5:C' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [];
    }
}
