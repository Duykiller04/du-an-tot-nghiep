<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsOfCuttingDoseMedication extends Model
{
    use HasFactory;
    protected $fillable = [
        'medicine_id',
        'cut_dose_medication_id',
        'medical_instruments_id',
        'unit_id',
        'quantity',
        'dosage',

        

    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
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
