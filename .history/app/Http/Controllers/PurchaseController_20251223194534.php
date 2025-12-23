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
use Illuminate\Support\Facades\Auth;

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
        // 1. VALIDASI
        $request->validate([
            'purchase_date' => 'required|date',
            'vendor_id'     => 'required|exists:vendors,id',
            'status'        => 'required|string',
            'items'         => 'required|array|min:1',
            'items.*.tool_name' => 'required|string',
            
            // PERHATIAN: Pastikan nama tabel kategori benar (biasanya 'categories' atau 'tool_categories')
            // Kita coba pakai 'categories' dulu sesuai standar Laravel, kalau error ganti 'tool_categories'
            'items.*.category_id' => 'required|exists:tool_categories,id', 
            
            'items.*.quantity'  => 'required|integer|min:1',
            'items.*.unit_price'=> 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // 2. HITUNG TOTAL
            $grandTotal = 0;
            foreach ($request->items as $item) {
                $grandTotal += $item['quantity'] * $item['unit_price'];
            }

            // 3. SIMPAN HEADER (Perbaikan Nama Kolom di sini)
            $purchase = Purchase::create([
                'purchase_code' => 'PO-' . date('Ymd') . '-' . rand(100, 999),
                'purchase_date' => $request->purchase_date,
                'vendor_id'     => $request->vendor_id,
                'status'        => $request->status,
                'total_amount'  => $grandTotal, // <-- SUDAH DIPERBAIKI (Sesuai Migration)
                'user_id'       => Auth::id(),  // <-- SUDAH DIPERBAIKI (Sesuai Migration)
            ]);

            // 4. SIMPAN ITEMS & GENERATE TOOLS
            foreach ($request->items as $item) {
                
                // A. Simpan Item Pembelian
                $purchaseItem = PurchaseItem::create([
                    'purchase_id'   => $purchase->id,
                    'category_id'   => $item['category_id'],
                    'tool_name'     => $item['tool_name'],
                    'specification' => $item['specification'] ?? '-',
                    'quantity'      => $item['quantity'],
                    'unit_price'    => $item['unit_price'],
                    'subtotal'      => $item['quantity'] * $item['unit_price'],
                ]);

                // B. LOGIKA AUTO CREATE TOOLS (Hanya jika Approved)
                if ($request->status === 'approved') {
                    for ($i = 1; $i <= $item['quantity']; $i++) {
                        
                        // Generate Kode Unik
                        $prefix = strtoupper(substr($item['tool_name'], 0, 3)); 
                        $uniqueCode = $prefix . '-' . date('ymd') . '-' . strtoupper(Str::random(4));

                        Tool::create([
                            'tool_code' => $uniqueCode,
                            'tool_name' => $item['tool_name'] . ' #' . $i, 
                            'category_id' => $item['category_id'],
                            'current_condition' => 'Baik',
                            'availability_status' => 'available',
                            'purchase_item_id' => $purchaseItem->id,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('purchases.index')->with('success', 'Transaksi berhasil disimpan & Stok bertambah!');

        } catch (\Exception $e) {
            DB::rollBack();
            // Pesan error akan muncul di kotak merah di atas form
            return back()->withInput()->withErrors(['msg' => 'Gagal menyimpan: ' . $e->getMessage()]);
        }
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['vendor', 'user', 'items.category']);
        return view('purchases.show', compact('purchase'));
    }

    /**
     * Approve a pending purchase (role: kepala/head only)
     */
    public function approve(Purchase $purchase)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['kepala','head'])) {
            return redirect()->route('purchases.index')->with('error', 'Anda tidak memiliki akses untuk menyetujui permintaan pembelian.');
        }

        if ($purchase->status !== 'pending') {
            return redirect()->back()->with('error', 'Permintaan ini sudah diproses.');
        }

        $purchase->status = 'approved';
        $purchase->save();

        return redirect()->route('purchases.show', $purchase->id)->with('success', 'Permintaan pembelian disetujui.');
    }

    /**
     * Reject a pending purchase (role: kepala/head only)
     */
    public function reject(Purchase $purchase)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['kepala','head'])) {
            return redirect()->route('purchases.index')->with('error', 'Anda tidak memiliki akses untuk menolak permintaan pembelian.');
        }

        if ($purchase->status !== 'pending') {
            return redirect()->back()->with('error', 'Permintaan ini sudah diproses.');
        }

        $purchase->status = 'rejected';
        $purchase->save();

        return redirect()->route('purchases.show', $purchase->id)->with('success', 'Permintaan pembelian ditolak.');
    }

    public function destroy(Purchase $purchase)
    {
        // Hati-hati, kalau dihapus tools yang sudah digenerate jadi yatim piatu (null)
        // Sesuai constraint nullOnDelete di migration
        $purchase->delete();
        return redirect()->route('purchases.index')->with('success', 'Data dihapus');
    }
}