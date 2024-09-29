<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CutDoseOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'disease_id ',
        'weight',
        'age',
        'gender',
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
