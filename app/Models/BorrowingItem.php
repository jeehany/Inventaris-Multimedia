<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowingItem extends Model
{
    protected $guarded = [];

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }
}