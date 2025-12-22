<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    // 1. Tentukan nama tabel secara manual (Sesuai ERD)
    protected $table = 'tool_categories';

    // 2. Sesuaikan fillable dengan nama kolom di ERD
    protected $fillable = ['category_name', 'description'];

    // Relasi
    public function tools()
    {
        return $this->hasMany(Tool::class);
    }
}