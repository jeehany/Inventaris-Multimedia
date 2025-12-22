<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    use HasFactory;

    protected $table = 'tools'; // Pastikan ini sesuai nama tabel alat di DB

    protected $fillable = [
        'tool_code', 
        'tool_name', 
        'category_id', 
        'current_condition', 
        'availability_status'
    ];

    public function category()
    {
        // Hubungkan ke model Category yang sudah kita perbaiki di atas
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function borrowingItems()
    {
        return $this->hasMany(\App\Models\BorrowingItem::class, 'tool_id', 'id');
    }
}