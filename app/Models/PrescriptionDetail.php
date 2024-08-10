<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'unit_id',
        'prescription_id',
        'medical_instruments_id',
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

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function medicalInstrument()
    {
        return $this->belongsTo(MedicalInstrument::class);
    }
}
