<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    use HasFactory;

    // Tambahkan 'category_id' di sini supaya bisa disimpan
    protected $fillable = [
        'tool_code', 
        'tool_name', 
        'current_condition', 
        'availability_status',
        'category_id' // <--- INI PENTING!
    ];

    // Relasi ke Category (agar nanti bisa panggil $tool->category->name)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}