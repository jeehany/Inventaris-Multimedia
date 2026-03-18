<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    protected $fillable = [
        'purchase_id',
        'category_id',
        'tool_name',
        'specification',
        'brand',
        'quantity',
        'unit_price',
        'subtotal'
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function category() // if it refers to ToolCategory
    {
        return $this->belongsTo(Category::class);
    }
}
