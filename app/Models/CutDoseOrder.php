<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutDoseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'weight',
        'age_min',
        'age_max',
        'gender',
        'name_diseases'
    ];
}


