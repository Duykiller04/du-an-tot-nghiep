<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryCheckDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'inventory_audit_id',
        'medicine_id',
        'quantity',
        'status',
        'medical_instrument_id',
    ];
}
