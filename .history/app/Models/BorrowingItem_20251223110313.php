<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowingItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi ke Alat (Penting untuk update status alat di Controller)
    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    // Relasi ke Induk Peminjaman (Tambahan, biar lengkap)
    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }
}