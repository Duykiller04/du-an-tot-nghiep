<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'unit_id',
        'prescription_id',
        'quantity',
        'current_price',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}
