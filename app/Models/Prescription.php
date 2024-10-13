<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prescription extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'id',
        'total',
        'age',
        'type_sell',
        'name_customer',
        'phone',
        'address',
        'email',
        'weight',
        'gender',
    ];
    public function prescriptionDetails(){
        return $this->hasMany(PrescriptionDetail::class);
    }
}
