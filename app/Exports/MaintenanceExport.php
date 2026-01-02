<?php

namespace App\Exports;

use App\Models\Maintenance;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class MaintenanceExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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

    public function map($maintenance): array
    {
        // Translate Status
        $status = match ($maintenance->status) {
            'pending' => 'Menunggu',
            'in_progress' => 'Sedang Dikerjakan',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($maintenance->status),
        };

        // Jenis Kerusakan: Gabungan Type dan Note (Sesuai Index)
        $type = $maintenance->type ? $maintenance->type->name : 'Umum';
        $note = $maintenance->note ?? '-';
        $issue = $type . ' - ' . $note;

        return [
            $maintenance->start_date ? \Carbon\Carbon::parse($maintenance->start_date)->translatedFormat('d F Y') : '-',
            $maintenance->tool ? $maintenance->tool->tool_name : '-',
            $issue, // Jenis Kerusakan
            $maintenance->action_taken ?? '-',
            'Rp ' . number_format($maintenance->cost ?? 0, 0, ',', '.'),
            $status,
        ];
    }

    public function headings(): array
    {
        return [
            ['LAPORAN PERAWATAN (MAINTENANCE)'],
            ['Tanggal Unduh: ' . now()->translatedFormat('d F Y')],
            [''], // Spasi baris kosong
            [
                'Tanggal Servis',
                'Nama Alat',
                'Jenis Kerusakan',
                'Tindakan',
                'Biaya Servis',
                'Status',
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // 1. Merge Title (Baris 1 & 2) -> Sampai Kolom F
        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');

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
        $sheet->getStyle('A4:F4')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F59E0B'], // Amber 500 (Warna Maintenance/Warning)
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // 5. Border Table
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A4:F' . $highestRow)->applyFromArray([
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

        // 6. Alignment
        // A=Tanggal (Center), E=Biaya (Right), F=Status (Center)
        $sheet->getStyle('A5:A' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E5:E' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT); // Biaya rata kanan
        $sheet->getStyle('F5:F' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [];
    }
}
