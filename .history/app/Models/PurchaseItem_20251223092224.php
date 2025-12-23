<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id', 'category_id', 'item_name', 
        'quantity', 'cost_per_unit', 'total_price'
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Satu item pembelian bisa menghasilkan BANYAK alat di tabel tools
    public function generatedTools()
    {
        return $this->hasMany(Tool::class, 'purchase_item_id');
    }
}