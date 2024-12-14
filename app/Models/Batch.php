<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $table = 'batches';

    protected $fillable = [
        'medicine_id',
        'supplier_id',
        'registration_number',
        'origin',
        'packaging_specification',
        'price_import',
        'price_sale',
        'expiration_date',
        'storage_id',
        'status_expiry',
        'price_in_smallest_unit',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }
    public function inventoryCheckDetails()
    {
        return $this->hasMany(InventoryCheckDetail::class, 'medicine_id', 'id');
    }
    public function inventory(){
        return $this->hasOne(Inventory::class);
    }
}
