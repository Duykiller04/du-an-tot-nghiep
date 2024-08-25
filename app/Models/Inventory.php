<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'storage_id',
        'medicine_id',
        'unit_id',
        'quantity',
    ];

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
