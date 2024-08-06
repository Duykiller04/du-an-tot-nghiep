<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalIntrument extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'supplier_id',
        'storage_id',
        'unit_id',
        'name',
        'price_import',
        'price_sale'
    ];
    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
    public function storage(){
        return $this->belongsTo(Storage::class);
    }
    public function unit(){
        return $this->belongsTo(Unit::class);
    }
}
