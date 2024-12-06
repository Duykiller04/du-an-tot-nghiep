<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CutDosePrescription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'disease_id',
        'name_hospital',
        'name_doctor',
        'age',
        'phone_doctor',
        'total',
    ];

    public function disease()
    {
        return $this->belongsTo(Disease::class);
    }
    public function cutDosePrescriptionDetails()
    {
        return $this->hasMany(CutDosePrescriptionDetail::class);
    }
    
}
