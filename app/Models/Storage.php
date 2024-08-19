<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    use HasFactory;
    protected $fillable = [
        'inventory_code',
        'location',
        'quantity',
        'unit_id',
    ];

    public function inventory()
    {
        return $this->hasMany(Medicine::class);
    }

    public function medicine()
    {
        return $this->hasMany(Medicine::class);
    }

    public function unit()
    {
        return $this->hasMany(Unit::class);
    }

    public function medicalInstruments()
    {
        return $this->hasMany(MedicalInstrument::class);
    }
}
