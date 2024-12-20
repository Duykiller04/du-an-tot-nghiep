<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CutDoseOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'seller',
        'disease_id',
        'customer_id',
        'weight',
        'age',
        'gender',
        'customer_name',
        'phone',
        'address',
        'shift_id',
        'total_price',
        'dosage',
    ];

    public function disease()
    {
        return $this->belongsTo(Disease::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function cutDoseOrderDetails()
    {
        return $this->hasMany(CutDoseOrderDetails::class);
    }
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
