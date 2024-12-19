<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitConversion extends Model
{
    use HasFactory;
    protected $fillable = [
        'medicine_id',
        'unit_id',
        'proportion',
    ];
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
    
}
