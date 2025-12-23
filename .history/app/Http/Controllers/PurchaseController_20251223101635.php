<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Vendor;
use App\Models\Category; // <--- Import Category
use App\Models\Tool;     // <--- Import Tool
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // Untuk generate kode acak

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['vendor', 'user'])->latest()->get();
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $vendors = Vendor::all();
        $categories = Category::all(); // <--- Ambil data kategori
        return view('purchases.create', compact('vendors', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'purchase_date' => 'required|date',
            'vendor_id'     => 'required|exists:vendors,id',
            'status'        => 'required|string',
            'items'         => 'required|array|min:1',
            'items.*.tool_name' => 'required|string',
            'items.*.category_id' => 'required|exists:tool_categories,id', // Validasi Kategori
            'items.*.quantity'  => 'required|integer|min:1',
            'items.*.unit_price'=> 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // 1. Hitung Total & Simpan Header
            $grandTotal = 0;
            foreach ($request->items as $item) {
                $grandTotal += $item['quantity'] * $item['unit_price'];
            }

            $purchase = Purchase::create([
                'purchase_code' => 'PO-' . date('Ymd') . '-' . rand(100, 999), // Generate No Transaksi
                'purchase_date' => $request->purchase_date,
                'vendor_id'     => $request->vendor_id,
                'status'        => $request->status,
                'total_cost'    => $grandTotal,
                'created_by'    => Auth::id(),
                'user_id'       => Auth::id(), // Jaga-jaga kalau nama kolom di DB user_id
            ]);

            // 2. Simpan Items & Generate Tools
            foreach ($request->items as $item) {
                
                // A. Simpan Item Pembelian
                $purchaseItem = PurchaseItem::create([
                    'purchase_id'   => $purchase->id,
                    'category_id'   => $item['category_id'], // Simpan kategori
                    'tool_name'     => $item['tool_name'],
                    'specification' => $item['specification'] ?? '-',
                    'quantity'      => $item['quantity'],
                    'unit_price'    => $item['unit_price'],
                    'subtotal'      => $item['quantity'] * $item['unit_price'],
                ]);

                // B. LOGIKA BARU: AUTO CREATE TOOLS (Jika Approved)
                if ($request->status === 'approved') {
                    // Loop sebanyak Quantity. Beli 5 = Buat 5 Baris Data Tool
                    for ($i = 1; $i <= $item['quantity']; $i++) {
                        
                        // Buat Kode Aset Unik: KODE-TGL-ACAK
                        // Contoh: BOR-20231223-X7Z
                        $prefix = strtoupper(substr($item['tool_name'], 0, 3)); 
                        $uniqueCode = $prefix . '-' . date('ymd') . '-' . strtoupper(Str::random(4));

                        Tool::create([
                            'tool_code' => $uniqueCode,
                            'tool_name' => $item['tool_name'] . ' #' . $i, // Kasih penanda nomor
                            'category_id' => $item['category_id'],
                            'current_condition' => 'Baik', // Default kondisi
                            'availability_status' => 'available', // Siap dipinjam
                            'purchase_item_id' => $purchaseItem->id, // Link ke asal usul pembelian
                        ]);
                    }
                }
            }

            DB::commit();

            $msg = 'Transaksi berhasil disimpan!';
            if ($request->status === 'approved') {
                $msg .= ' Stok alat di gudang otomatis bertambah.';
            }

            return redirect()->route('purchases.index')->with('success', $msg);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['vendor', 'user', 'items.category']);
        return view('purchases.show', compact('purchase'));
    }

    public function destroy(Purchase $purchase)
    {
        // Hati-hati, kalau dihapus tools yang sudah digenerate jadi yatim piatu (null)
        // Sesuai constraint nullOnDelete di migration
        $purchase->delete();
        return redirect()->route('purchases.index')->with('success', 'Data dihapus');
    }
}