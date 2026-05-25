<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;
use App\Models\Category;
use App\Models\Vendor;
use App\Models\Purchase;
use App\Models\Maintenance;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Menampilkan Halaman Indeks Laporan (8 Modul)
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * 1. Laporan Peminjaman (History Sirkulasi)
     */
    public function borrowingHistory(Request $request)
    {
        return redirect()->route('borrowings.exportPdf', $request->all());
    }

    /**
     * 2. Laporan Riwayat Maintenance
     */
    public function maintenanceHistory(Request $request)
    {
        return redirect()->route('maintenances.exportPdf', $request->all());
    }

    /**
     * 3. Laporan Pengadaan Barang (RAB & Bukti Beli)
     */
    public function purchaseHistory(Request $request)
    {
        return redirect()->route('purchases.history.exportPdf', $request->all());
    }

    /**
     * 4. Laporan Analisis Penggunaan Aset (Heatmap/Sering dipakai)
     */
    public function assetUsage(Request $request)
    {
        return redirect()->route('borrowings.analysis_pdf', $request->all());
    }

    /**
     * 5. Laporan Kondisi Barang Terkini
     */
    public function assetCondition(Request $request)
    {
        return redirect()->route('tools.exportPdf', $request->all());
    }

    /**
     * 6. Laporan Nilai Aset / Depresiasi
     * Menghitung Harga Beli Awal vs Total Beban Servis
     */
    public function assetDepreciation(Request $request)
    {
        // Join dengan Purchase Item untuk mendapatkan Harga Beli
        $tools = DB::table('tools')
            ->leftJoin('purchase_items', 'tools.purchase_item_id', '=', 'purchase_items.id')
            ->leftJoin('categories', 'tools.category_id', '=', 'categories.id')
            ->select(
                'tools.id',
                'tools.tool_code',
                'tools.tool_name',
                'tools.purchase_date',
                'categories.category_name',
                DB::raw('COALESCE(tools.purchase_price, purchase_items.unit_price) as initial_price')
            )
            ->whereNull('tools.deleted_at')
            ->orderBy('tools.tool_name')
            ->get();

        foreach ($tools as $t) {
            // Hitung total beban perbaikan untuk alat ini
            $totalMaintenanceCost = DB::table('maintenances')
                ->where('tool_id', $t->id)
                ->sum('cost');

            $t->total_maintenance_cost = $totalMaintenanceCost;

            // Perhitungan Depresiasi (Metode Garis Lurus)
            $initialPrice = $t->initial_price ?? 0;
            $t->initial_price = $initialPrice;
            $t->total_investment = $initialPrice + $totalMaintenanceCost;

            $usefulLife = 5; // Masa manfaat 5 tahun
            $salvageValue = $initialPrice * 0.10; // Nilai residu 10%

            // Hitung selisih tahun perolehan
            $purchaseYear = $t->purchase_date ? date('Y', strtotime($t->purchase_date)) : date('Y');
            $currentYear = date('Y');
            $yearsElapsed = max(0, $currentYear - $purchaseYear);

            if ($yearsElapsed >= $usefulLife) {
                // Nilai buku telah menyusut ke nilai residu
                $accumulatedDepreciation = $initialPrice - $salvageValue;
            } else {
                $yearlyDepreciation = ($initialPrice - $salvageValue) / $usefulLife;
                $accumulatedDepreciation = $yearlyDepreciation * $yearsElapsed;
            }

            $t->years_elapsed = $yearsElapsed;
            $t->accumulated_depreciation = $accumulatedDepreciation;
            $t->current_valuation = max($salvageValue, $initialPrice - $accumulatedDepreciation);
        }

        $pdf = Pdf::loadView('reports.asset_depreciation_pdf', compact('tools', 'request'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('Laporan_Nilai_Aset_Depresiasi.pdf');
    }

    /**
     * 7. Laporan Kerusakan per Kategori
     * Analisis Kategori Aset yang paling rengkih / sering diservis
     */
    public function damagePerCategory(Request $request)
    {
        $startDate = $request->start_date ?? null;
        $endDate = $request->end_date ?? null;

        $queryBuilder = DB::table('tool_categories')
            ->leftJoin('tools', 'tool_categories.id', '=', 'tools.category_id')
            ->leftJoin('maintenances', 'tools.id', '=', 'maintenances.tool_id');

        if ($startDate) $queryBuilder->whereDate('maintenances.start_date', '>=', $startDate);
        if ($endDate) $queryBuilder->whereDate('maintenances.start_date', '<=', $endDate);

        $categoriesData = $queryBuilder->select(
                'tool_categories.id',
                'tool_categories.category_name',
                DB::raw('COUNT(maintenances.id) as maintenance_count'),
                DB::raw('COALESCE(SUM(maintenances.cost), 0) as total_repair_cost')
            )
            ->groupBy('tool_categories.id', 'tool_categories.category_name')
            ->orderByDesc('maintenance_count')
            ->get();
            
        // Map as Category models to keep compatibility with blade view
        $categories = $categoriesData->map(function ($item) {
            $cat = new Category();
            $cat->id = $item->id;
            $cat->category_name = $item->category_name;
            $cat->maintenance_count = $item->maintenance_count;
            $cat->total_repair_cost = $item->total_repair_cost;
            return $cat;
        });

        $pdf = Pdf::loadView('reports.damage_category_pdf', compact('categories', 'startDate', 'endDate'));
        return $pdf->stream('Laporan_Kerusakan_Kategori.pdf');
    }

    /**
     * 8. Laporan Rekapitulasi Vendor
     * Daftar vendor langganan
     */
    public function vendorRecap(Request $request)
    {
        $startDate = $request->start_date ?? null;
        $endDate = $request->end_date ?? null;

        $vendors = Vendor::orderBy('name')->get();

        foreach ($vendors as $vendor) {
            $query = Purchase::where('vendor_id', $vendor->id)
                ->where('status', 'completed');

            if ($startDate) $query->whereDate('date', '>=', $startDate);
            if ($endDate) $query->whereDate('date', '<=', $endDate);

            $vendor->total_transactions = $query->count();
            $vendor->total_spent = $query->sum('total_amount');
        }

        $vendors = $vendors->sortByDesc('total_spent');

        $pdf = Pdf::loadView('reports.vendor_recap_pdf', compact('vendors', 'startDate', 'endDate'));
        return $pdf->stream('Laporan_Rekap_Vendor.pdf');
    }
}
