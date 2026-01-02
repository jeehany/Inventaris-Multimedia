<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\PurchaseCompletedSheet;
use App\Exports\PurchaseRejectedSheet;

class PurchaseHistoryExport implements WithMultipleSheets
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function sheets(): array
    {
        $sheets = [];

        // Sheet 1: Transaksi Selesai (Budget vs Realisasi)
        $sheets[] = new PurchaseCompletedSheet($this->filters);

        // Sheet 2: Transaksi Ditolak (Alasan Penolakan)
        $sheets[] = new PurchaseRejectedSheet($this->filters);

        return $sheets;
    }
}
