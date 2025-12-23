<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;

    // Tidak butuh timestamps di tabel detail biasanya, tapi kalau di migrasi ada, biarkan true
    public $timestamps = false; 

    protected $fillable = [
        'purchase_id',
        'tool_name',
        'specification',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}