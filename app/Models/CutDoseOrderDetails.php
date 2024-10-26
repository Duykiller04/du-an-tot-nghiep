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
        'unit_id',
        'quantity',
        'dosage',
        'status'
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

}
