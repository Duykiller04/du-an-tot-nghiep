<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'phone',
        'address',
        'email',
        'age',
        'weight',
    ];
    
    public function diseases(){
        return $this->hasMany(Disease::class);
    }
    public function prescription(){
        return $this->hasMany(Prescription::class);
    }
}
