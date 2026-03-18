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
                'categories.category_name',
                'purchase_items.unit_price as initial_price'
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
            $t->total_investment = ($t->initial_price ?? 0) + $totalMaintenanceCost;
            
            // Contoh sederhana depresiasi: Harga Beli - (Sebagian biaya servis? atau Depresiasi umur?)
            // Karena permintaan adalah Harga beli vs total beban, kita tampilkan itu saja.
            $t->current_valuation = ($t->initial_price ?? 0) - ($totalMaintenanceCost * 0.5); // Penurunan nilai estimasi
            if ($t->current_valuation < 0) $t->current_valuation = 0;
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

        $categories = Category::withCount('tools')->get();

        foreach ($categories as $cat) {
            $query = DB::table('maintenances')
                ->join('tools', 'maintenances.tool_id', '=', 'tools.id')
                ->where('tools.category_id', $cat->id);

            if ($startDate) $query->whereDate('maintenances.start_date', '>=', $startDate);
            if ($endDate) $query->whereDate('maintenances.start_date', '<=', $endDate);

            $cat->maintenance_count = $query->count();
            $cat->total_repair_cost = $query->sum('maintenances.cost');
        }

        $categories = $categories->sortByDesc('maintenance_count');

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

            if ($startDate) $query->whereDate('purchase_date', '>=', $startDate);
            if ($endDate) $query->whereDate('purchase_date', '<=', $endDate);

            $vendor->total_transactions = $query->count();
            $vendor->total_spent = $query->sum('total_amount');
        }

        $vendors = $vendors->sortByDesc('total_spent');

        $pdf = Pdf::loadView('reports.vendor_recap_pdf', compact('vendors', 'startDate', 'endDate'));
        return $pdf->stream('Laporan_Rekap_Vendor.pdf');
    }
}
