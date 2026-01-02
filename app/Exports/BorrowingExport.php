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

class BorrowingExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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

    public function map($borrowing): array
    {
        // 1. Gabungkan Nama Alat (Comma Separated)
        $toolNames = $borrowing->items->map(function ($item) {
            return $item->tool ? $item->tool->tool_name : 'Item Dihapus';
        })->join(', ');

        // 2. Format Status
        $status = $borrowing->borrowing_status == 'active' ? 'Sedang Dipinjam' : 'Dikembalikan';
        if ($borrowing->final_status) {
            $status .= ' (' . $borrowing->final_status . ')';
        }

        return [
            \Carbon\Carbon::parse($borrowing->borrow_date)->translatedFormat('d F Y'),
            $borrowing->borrower ? $borrowing->borrower->name : '-',
            $toolNames, // Nama Alat (Gabungan)
            \Carbon\Carbon::parse($borrowing->planned_return_date)->translatedFormat('d F Y'),
            $borrowing->actual_return_date ? \Carbon\Carbon::parse($borrowing->actual_return_date)->translatedFormat('d F Y') : '-',
            $borrowing->return_condition ?? 'Masih Dipinjam',
            $status,
        ];
    }

    public function headings(): array
    {
        return [
            ['LAPORAN PEMINJAMAN (SIRKULASI)'],
            ['Tanggal Unduh: ' . now()->translatedFormat('d F Y')],
            [''], // Spasi baris kosong
            [
                'Tanggal Pinjam',
                'Nama Peminjam',
                'Nama Alat',
                'Tgl Harus Kembali',
                'Tgl Realisasi Kembali',
                'Kondisi Saat Kembali',
                'Status Akhir',
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // 1. Merge Title
        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:G2');

        // 2. Style Title
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

        // 3. Style Header Tabel (Baris 4) - BLUE THEME
        $sheet->getStyle('A4:G4')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0EA5E9'], // Sky 500
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // 4. Border & Alignment Content
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A4:G' . $highestRow)->applyFromArray([
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

        // Center Alignment untuk Kolom Tanggal (A, D, E) dan Status (G)
        $sheet->getStyle('A5:A' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D5:E' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G5:G' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [];
    }
}
