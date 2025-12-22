<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // KITA ARAHKAN KE NAMA TABEL YANG PALING UMUM
    protected $table = 'category'; 

    // Ini agar kolom nama bisa dibaca
    protected $fillable = ['category_name']; 

    public function tools()
    {
        return $this->hasMany(Tool::class, 'category_id', 'id');
    }
}