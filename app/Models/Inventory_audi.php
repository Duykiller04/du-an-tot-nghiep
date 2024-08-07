<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory_audi extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'inventory_audit';
    protected $fillable = [
        'storage_id',
        'time',
        'date_recorded',
        'id_customer',
    ];
}
