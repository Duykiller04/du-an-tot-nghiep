<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Storage extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'location',
    ];

    public function inventoryAudits()
    {
        return $this->hasMany(InventoryAudit::class, 'storage_id', 'id');
    }

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }

    public function unit()
    {
        return $this->hasMany(Unit::class);
    }
    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }
}
