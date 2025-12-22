<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // INI KUNCINYA: Beri tahu Laravel nama tabel aslinya
    protected $table = 'current_category'; 

    // Pastikan fillable sesuai dengan nama kolom di tabel tersebut
    // Saya asumsikan nama kolomnya 'category_name' atau 'name'? 
    // Sesuaikan dengan yang ada di database Anda.
    protected $fillable = ['category_name']; 

    public function tools()
    {
        // Relasi ke tabel tools
        // 'category_id' adalah nama kolom foreign key di tabel tools
        return $this->hasMany(Tool::class, 'category_id', 'id');
    }
}