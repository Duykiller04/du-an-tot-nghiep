<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryAudit extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'storage_id',
        'time',
        'date_recorded',
        'id_customer',
    ];
}
