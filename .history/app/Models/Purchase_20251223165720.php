<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    // Kolom mana saja yang boleh diisi?
    protected $fillable = [
        'item_name', 
        'quantity', 
        'estimated_price', 
        'reason', 
        'status', 
        'user_id'
    ];

    // Relasi: Pengajuan ini milik user siapa?
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}