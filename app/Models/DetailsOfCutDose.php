<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsOfCutDose extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'cut_dose_prescription_id',
        'medical_instruments_id',
        'unit_id',
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

    public function cutDosePrescription()
    {
        return $this->belongsTo(CutDosePrescription::class);
    }

    public function medicalInstrument()
    {
        return $this->belongsTo(MedicalInstrument::class);
    }
}
