<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutDoseOrderDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'medicine_id',
        'cut_dose_order_id',
        'medical_instrument_id',
        'unit_id',
        'quantity',
        'dosage',
    ];

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }

    public function cutDoseOrder()
    {
        return $this->belongsTo(CutDoseOrder::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function medicalInstrument()
    {
        return $this->belongsTo(MedicalInstrument::class);
    }
}
