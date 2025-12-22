<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    // Nama tabel sesuai migration
    protected $table = 'tool_categories';

    protected $fillable = ['category_name', 'description', 'code'];

    public function tools()
    {
        return $this->hasMany(Tool::class, 'category_id', 'id');
    }
}
