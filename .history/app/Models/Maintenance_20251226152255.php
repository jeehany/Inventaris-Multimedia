<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi: Maintenance milik satu Alat
    public function tool()
    {
        return $this->belongsTo(Tool::class)->withTrashed();
    }

    // Relasi: Dilaporkan oleh User (Admin/Teknisi)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(MaintenanceType::class, 'maintenance_type_id');
    }
}