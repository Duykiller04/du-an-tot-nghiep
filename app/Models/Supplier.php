<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'tax_code',
        'name',
        'address',
        'phone',
        'email',
    ];

    public function medicines() {
        return $this->belongsToMany(Medicine::class);
    }
    public function medicalInstruments() {
        return $this->belongsToMany(MedicalIntrument::class);
    }
}
