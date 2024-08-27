<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medicine extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'category_id',
        'storage_id',
        'unit_id',
        'medicine_code',
        'name',
        'image',
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
    public function category()
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
    public function inventoryCheckDetails()
    {
        return $this->hasMany(InventoryCheckDetail::class, 'medicine_id', 'id');
    }
}
