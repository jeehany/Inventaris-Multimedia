<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\{Category, Vendor, MaintenanceType, Tool, Borrowing, Purchase, PurchaseItem, Maintenance, User};
use Illuminate\Support\Facades\DB;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Kategori Aset
        $categories = [
             Category::create(['category_name' => 'Kamera', 'description' => 'Kamera DSLR, Mirrorless, Video', 'code' => 'KAM']),
             Category::create(['category_name' => 'Lensa', 'description' => 'Lensa Fix, Zoom, Tele, Wide', 'code' => 'LNS']),
             Category::create(['category_name' => 'Audio', 'description' => 'Microphone, Recorder, Mixer', 'code' => 'AUD']),
             Category::create(['category_name' => 'Lighting', 'description' => 'Lampu Studio, Softbox, LED', 'code' => 'LGT']),
             Category::create(['category_name' => 'Aksesoris', 'description' => 'Tripod, Gimbal, Baterai, Kabel', 'code' => 'AKS'])
        ];

        // 2. Vendor
        $vendors = [
            Vendor::create(['name' => 'PT. Sentra Kamera', 'address' => 'Jl. Kamera Ruko B', 'phone' => '0811223344', 'email' => 'sentra@kamera.com']),
            Vendor::create(['name' => 'Toko Audio Mas', 'address' => 'Jl. Audio No. 20', 'phone' => '0822114455', 'email' => 'mas@audio.com']),
            Vendor::create(['name' => 'Gudang Aksesoris', 'address' => 'Mall IT Block A', 'phone' => '0855223344', 'email' => 'gudang@aksesoris.com']),
        ];

        // 3. Maintenance Type
        $maintenanceTypes = [
            MaintenanceType::create(['name' => 'Servis Rutin', 'description' => 'Pembersihan Sensor, Pengecekan Fungsi']),
            MaintenanceType::create(['name' => 'Perbaikan Lensa', 'description' => 'Servis Jamur, Fokus Macet']),
            MaintenanceType::create(['name' => 'Ganti Sparepart', 'description' => 'Ganti Shutter, Tombol, Layar']),
        ];

        // Users
        $staff = User::where('role', 'staff')->first() ?? User::first();
        $head = User::where('role', 'kepala')->first() ?? User::where('role', 'admin')->first() ?? User::first();

        // 4. Tools (Master Data)
        $tools = [];
        $toolNames = [
            'Kamera' => ['Sony A7III', 'Canon EOS R5', 'Lumix GH5', 'Nikon Z6 II'],
            'Lensa' => ['Sony FE 24-70mm', 'Canon RF 50mm', 'Lumix 12-35mm', 'Sigma 35mm Art'],
            'Audio' => ['Rode Wireless GO', 'Zoom H4n', 'Sennheiser MKE 600', 'Boya BY-M1'],
            'Lighting' => ['Godox SL60W', 'Aputure 120d', 'Amaran 200x', 'Nanlite PavoTube'],
            'Aksesoris' => ['Manfrotto Tripod', 'DJI Ronin S', 'Moza Air 2', 'NP-F970 Battery']
        ];

        for ($i=1; $i<=25; $i++) {
            $cat = $categories[array_rand($categories)];
            $status = ['available', 'available', 'available', 'available', 'borrowed', 'maintenance', 'disposed'][array_rand(['available', 'available', 'available', 'available', 'borrowed', 'maintenance', 'disposed'])];
            
            $condition = 'baik';
            if ($status == 'maintenance') $condition = 'rusak_ringan';
            if ($status == 'disposed') $condition = 'rusak_berat';

            $tName = $toolNames[$cat->category_name][array_rand($toolNames[$cat->category_name])] . ' Unit ' . rand(1, 5);

            $tools[] = Tool::create([
                'category_id' => $cat->id,
                'tool_code' => 'ALT-' . date('Ymd') . '-' . rand(1000, 9999) . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'tool_name' => $tName,
                'brand' => explode(' ', $tName)[0],
                'purchase_date' => Carbon::now()->subDays(rand(10, 365)),
                'current_condition' => $condition,
                'availability_status' => $status
            ]);
        }

        // 4.5 Borrowers
        $borrowers = [];
        for ($i=1; $i<=5; $i++) {
            $borrowers[] = \App\Models\Borrower::create([
                'code' => 'BR-' . rand(1000, 9999) . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'name' => 'Anggota ' . $i,
                'phone' => '0812345678' . $i
            ]);
        }

        // 5. Borrowings
        for ($i=1; $i<=20; $i++) {
            $b_status = ['active', 'returned', 'overdue', 'rejected'][array_rand(['active', 'returned', 'overdue', 'rejected'])];
            
            $borrowing = Borrowing::create([
                'borrowing_code' => 'BRW-' . date('Ymd') . '-' . rand(100, 999) . $i,
                'borrower_id' => $borrowers[array_rand($borrowers)]->id,
                'user_id' => $staff->id,
                'borrow_date' => Carbon::now()->subDays(rand(1, 20)),
                'planned_return_date' => Carbon::now()->subDays(rand(1, 20))->addDays(rand(2, 5)),
                'actual_return_date' => $b_status == 'returned' ? Carbon::now() : null,
                'borrowing_status' => $b_status,
                'notes' => 'Tugas Liputan',
            ]);

            $tool = $tools[array_rand($tools)];
            \App\Models\BorrowingItem::create([
                'borrowing_id' => $borrowing->id,
                'tool_id' => $tool->id,
                'tool_condition_before' => 'baik',
                'tool_condition_after' => $b_status == 'returned' ? 'baik' : null,
            ]);
            
            if ($b_status == 'active') {
                $tool->update(['availability_status' => 'borrowed']);
            }
        }

        // 6. Purchases (Pengajuan RAB)
        for ($i=1; $i<=12; $i++) {
            $p_status = ['pending', 'approved_head', 'rejected_head', 'completed'][array_rand(['pending', 'approved_head', 'rejected_head', 'completed'])];
            
            $purchase = Purchase::create([
                'purchase_code' => 'RAB-' . date('Ymd') . rand(100, 999) . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'user_id' => $staff->id,
                'vendor_id' => $vendors[array_rand($vendors)]->id,
                'date' => Carbon::now()->subDays(rand(1, 30)),
                'total_amount' => 0,
                'status' => $p_status,
            ]);

            $total = 0;
            for ($j=1; $j<=rand(2,4); $j++) {
                $price = rand(10, 150) * 100000;
                $qty = rand(1, 4);
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'category_id' => $categories[array_rand($categories)]->id,
                    'tool_name' => ['Lampu Video', 'Memo Card 128GB', 'Tas Kamera', 'Kabel HDMI 10m', 'Microphone Clip-on'][rand(0,4)],
                    'specification' => 'Spesifikasi standar',
                    'brand' => ['Sony', 'Canon', 'Rode', 'Godox', 'SanDisk'][rand(0,4)],
                    'quantity' => $qty,
                    'unit_price' => $price,
                    'subtotal' => $price * $qty
                ]);
                $total += ($price * $qty);
            }
            $purchase->update(['total_amount' => $total]);
        }

        // 7. Maintenances
        for ($i=1; $i<=10; $i++) {
            $m_status = ['pending', 'in_progress', 'completed'][array_rand(['pending', 'in_progress', 'completed'])];
            
            Maintenance::create([
                'tool_id' => $tools[array_rand($tools)]->id,
                'maintenance_type_id' => $maintenanceTypes[array_rand($maintenanceTypes)]->id,
                'vendor_name' => $vendors[array_rand($vendors)]->name,
                'user_id' => $staff->id,
                'start_date' => Carbon::now()->subDays(rand(5, 15)),
                'end_date' => $m_status == 'completed' ? Carbon::now()->subDays(rand(1, 4)) : null,
                'cost' => $m_status == 'completed' ? rand(5, 50) * 50000 : 0,
                'status' => $m_status,
                'note' => 'Servis kerusakan ringan pada tombol',
                'action_taken' => $m_status == 'completed' ? 'Komponen sudah diganti dan berfungsi normal' : null,
            ]);
        }
    }
}
