<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutDoseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'disease_id',
        'customer_id',
        'weight',
        'age',
        'gender',
        'customer_name',
        'phone',
        'address',
    ];

    public function disease()
    {
        return $this->belongsTo(Disease::class);
    }
    public function cutDoseOrderDetail()
    {
        return $this->hasOne(CutDoseOrderDetails::class);
    }
}
