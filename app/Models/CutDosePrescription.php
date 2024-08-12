<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutDosePrescription extends Model
{
    use HasFactory;

    protected $fillable = [
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
    public function cutDosePrescriptionDetail(){
        return $this->hasOne(CutDosePrescriptionDetail::class);
    }
}
