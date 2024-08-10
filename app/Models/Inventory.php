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
        'quantity',
        'medical_instrument_id',
    ];

    public function storage()
    {
        return $this->hasMany(Storage::class);
    }

    public function medicine()
    {
        return $this->hasMany(Medicine::class);
    }

    public function medical_instruments()
    {
        return $this->hasMany(MedicalInstrument::class);
    }
}
