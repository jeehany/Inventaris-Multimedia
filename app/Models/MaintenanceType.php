<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceType extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Relasi: Satu tipe bisa dipakai di banyak maintenance
    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }
}