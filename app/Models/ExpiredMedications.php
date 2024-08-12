<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpiredMedications extends Model
{
    use HasFactory;

    protected $fillable = [
        'storage_id',
        'quantity',
        'expiration_date',
        'medicine_id',
        'medical_instrument_id',
    ];

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function medical_instruments()
    {
        return $this->hasMany(MedicalInstrument::class);
    }
}
