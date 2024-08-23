<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalInstrument extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'category_id',
        'storage_id',
        'unit_id',
        'name',
        'image',
        'price_import',
        'price_sale'
    ];
    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class,'medical_instruments_supplier');
    }
    public function storage(){
        return $this->belongsTo(Storage::class);
    }
    public function unit(){
        return $this->belongsTo(Unit::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
