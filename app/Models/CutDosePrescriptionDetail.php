<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutDosePrescriptionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'cut_dose_prescription_id',
        'unit_id',
        'batch_id',
        'quantity',
        'current_price',
        'dosage',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function cutDosePrescription()
    {
        return $this->belongsTo(CutDosePrescription::class);
    }

    public function inventory()
    {
        return $this->hasOneThrough(Inventory::class, Medicine::class, 'id', 'medicine_id', 'medicine_id', 'id');
    }

}
