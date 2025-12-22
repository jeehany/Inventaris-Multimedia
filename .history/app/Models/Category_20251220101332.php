<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // INI PERBAIKANNYA: Arahkan ke nama tabel yang benar
    protected $table = 'current_category'; 

    // Sesuaikan nama kolom di tabel Anda (biasanya 'category_name' atau 'name')
    protected $fillable = ['category_name']; 

    public function tools()
    {
        return $this->hasMany(Tool::class, 'category_id', 'id');
    }
}