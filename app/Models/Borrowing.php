<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $guarded = [];

    // Relasi: Peminjaman milik satu Peminjam
    public function borrower()
    {
        return $this->belongsTo(Borrower::class);
    }

    // Relasi: Peminjaman dilayani oleh satu Admin/User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Peminjaman punya banyak Item Alat
    public function items()
    {
        return $this->hasMany(BorrowingItem::class);
    }
}