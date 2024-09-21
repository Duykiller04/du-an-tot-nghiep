<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitConversion extends Model
{
    use HasFactory;
    protected $fillable = [
        'medicine_id',
        'unit_id_1',
        'unit_id_2',
        'proportion',
    ];
    public function unit1()
    {
        return $this->belongsTo(Unit::class, 'unit_id_1');
    }
    public function unit2()
    {
        return $this->belongsTo(Unit::class, 'unit_id_2');
    }
}
