<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    use HasFactory;
    protected $fillable = [
        'inventory_code',
        'medicine_id',
        'location',
        'quantity',
        'unit_id',
        'medical_instruments_id',
    ];

    public function medicine()
    {
        return $this->hasMany(Medicine::class);
    }

    public function unit()
    {
        return $this->hasMany(Unit::class);
    }

    public function medical_instruments()
    {
        return $this->hasMany(MedicalInstrument::class);
    }
}
