<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Tambahkan jika perlu

class Category extends Model
{
    use HasFactory;

    // INI KUNCINYA: Izinkan kolom 'name' diisi data
    protected $fillable = ['name'];
    
    // Relasi ke tools (opsional, untuk masa depan)
    public function tools()
    {
        return $this->hasMany(Tool::class);
    }
}