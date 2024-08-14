<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicine extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'storage_id',
        'unit_id',
        'medicine_code',
        'price_import',
        'price_sale',
        'packaging_specification',
        'registration_number',
        'active_ingredient',
        'concentration',
        'dosage',
        'administration_route',
        'origin',
        'is_active',
        'expiration_date',
    ];
    public function categories()
    {
        return $this->belongsTo(Category::class);
    }
    public function CutDoseOrderDetails()
    {
        return $this->belongsTo(CutDoseOrderDetails::class);
    }
    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class);
    }
}
