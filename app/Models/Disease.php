<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disease extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'diseases';
    protected $fillable = [
        'disease_name',
        'symptom',
        'user_id',
        'verify_date',

    ];
}
