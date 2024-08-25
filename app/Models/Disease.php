<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disease extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'disease_name',
        'symptom',
        'feature_img',
        'treatment_direction',
        'danger_level',
        'verify_date',
    ];
  
}
