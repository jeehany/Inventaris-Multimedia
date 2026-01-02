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

class ToolsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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
        // Translate Status
        $status = match ($tool->availability_status) {
            'available' => 'Tersedia',
            'borrowed' => 'Dipinjam',
            'maintenance' => 'Maintenance',
            'missing' => 'Hilang/Rusak',
            'disposed' => 'Dihapus',
            default => ucfirst($tool->availability_status),
        };

        // Logic Sumber
        $source = $tool->purchase_item_id ? 'Pengadaan' : 'Input Manual / Hibah';

        return [
            $tool->tool_code,
            $tool->tool_name,
            $tool->category ? $tool->category->category_name : '-',
            $tool->brand ?? '-',
            $tool->current_condition,
            $tool->purchase_date ? \Carbon\Carbon::parse($tool->purchase_date)->translatedFormat('d F Y') : '-',
            $source,
            $status,
        ];
    }

    public function headings(): array
    {
        return [
            ['LAPORAN DAFTAR INVENTARIS ASET'],
            ['Tanggal Unduh: ' . now()->translatedFormat('d F Y')],
            [''], // Spasi baris kosong
            [
                'Kode Aset',
                'Nama Barang',
                'Kategori',
                'Merk/Tipe',
                'Kondisi',
                'Tanggal Perolehan',
                'Sumber',
                'Status',
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // 1. Merge Title (Baris 1 & 2) -> Sampai Kolom H
        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:H2');

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

        // 4. Style Header Tabel (Baris 4) -> Sampai Kolom H
        $sheet->getStyle('A4:H4')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5'], // Indigo 600
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // 5. Border Table (Data mulai dari A4 sampai baris terakhir)
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A4:H' . $highestRow)->applyFromArray([
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

        // 6. Center alignment untuk kolom tertentu
        // A=Kode, E=Kondisi, F=Tanggal, G=Sumber, H=Status
        $sheet->getStyle('A5:A' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E5:H' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [];
    }
}
