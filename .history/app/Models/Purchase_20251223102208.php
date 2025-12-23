<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_code',  // <-- Tadi belum ada
        'purchase_date',
        'vendor_id',
        'total_amount',   // <-- Ubah dari total_cost jadi total_amount
        'status',
        'user_id',        // <-- Ubah dari created_by jadi user_id
        'notes'           // Tambahan jika ada catatan
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}