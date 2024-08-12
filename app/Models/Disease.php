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
        'user_id',
        'verify_date',

    ];
    protected function customer(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
