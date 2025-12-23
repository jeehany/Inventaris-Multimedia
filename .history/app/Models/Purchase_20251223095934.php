<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_date',
        'vendor_id',
        'total_cost',
        'status',
        'created_by', // Asumsi ada kolom ini sesuai ERD/Migration
        // 'approval_by' // Opsional jika belum dipakai
    ];

    // Relasi ke Vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    // Relasi ke User pembuat
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi ke Barang-barang yang dibeli
    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}