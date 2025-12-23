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
    // Menampilkan daftar pembelian
    public function index()
    {
        // Kita load juga relasi 'vendor' dan 'user' biar tidak berat (N+1 Problem)
        $purchases = Purchase::with(['vendor', 'user'])->latest()->get();
        return view('purchases.index', compact('purchases'));
    }

    // Form buat pembelian baru
    public function create()
    {
        // Kita butuh data vendor untuk Dropdown
        $vendors = Vendor::all();
        return view('purchases.create', compact('vendors'));
    }

    // Simpan Pembelian (Header + Items sekaligus)
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'purchase_date' => 'required|date',
            'vendor_id'     => 'required|exists:vendors,id',
            'status'        => 'required|string',
            
            // Validasi Array Items (Baris barang)
            'items'         => 'required|array|min:1',
            'items.*.tool_name' => 'required|string',
            'items.*.quantity'  => 'required|integer|min:1',
            'items.*.unit_price'=> 'required|numeric|min:0',
        ]);

        try {
            // 2. Mulai Transaksi Database
            DB::beginTransaction();

            // Hitung total cost otomatis dari items yang dikirim
            $grandTotal = 0;
            foreach ($request->items as $item) {
                $grandTotal += $item['quantity'] * $item['unit_price'];
            }

            // 3. Simpan Header (Tabel Purchases)
            $purchase = Purchase::create([
                'purchase_date' => $request->purchase_date,
                'vendor_id'     => $request->vendor_id,
                'status'        => $request->status,
                'total_cost'    => $grandTotal,
                'created_by'    => Auth::id(), // Mengambil ID user yang sedang login
            ]);

            // 4. Simpan Detail Items (Tabel Purchase_Items)
            foreach ($request->items as $item) {
                PurchaseItem::create([
                    'purchase_id'   => $purchase->id,
                    'tool_name'     => $item['tool_name'],
                    'specification' => $item['specification'] ?? '-',
                    'quantity'      => $item['quantity'],
                    'unit_price'    => $item['unit_price'],
                    'subtotal'      => $item['quantity'] * $item['unit_price'],
                ]);
            }

            // 5. Commit (Simpan Permanen)
            DB::commit();

            return redirect()->route('purchases.index')
                ->with('success', 'Transaksi pembelian berhasil disimpan!');

        } catch (\Exception $e) {
            // Kalau ada error, batalkan semua perubahan
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Purchase $purchase)
    {
        // Menampilkan detail struk pembelian
        $purchase->load(['vendor', 'user', 'items']);
        return view('purchases.show', compact('purchase'));
    }

    // Kita skip edit/delete dulu biar tidak pusing, fokus create dulu
    public function destroy(Purchase $purchase)
    {
        $purchase->delete(); // Karena pakai constrained di migration, items otomatis terhapus (cascade) atau harus manual
        return redirect()->route('purchases.index')->with('success', 'Data dihapus');
    }
}