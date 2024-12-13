<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'storage_id',
        'batch_id',
        'unit_id',
        'quantity',
    ];

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
