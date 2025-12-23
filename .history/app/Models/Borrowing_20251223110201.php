<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    // $guarded = [] berarti semua kolom boleh diisi (Mass Assignment)
    // Ini cocok dengan Controller kamu yang pakai create([...])
    protected $guarded = [];

    // Relasi: Peminjaman milik satu Peminjam (Siswa/Guru)
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