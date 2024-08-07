<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory_audit_detail extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'inventory_check_details';
    protected $fillable = [
        'inventory_audit_id',
        'medicine_id',
        'quantity',
        'status',
        'medical_instrument_id',

    ];
}
