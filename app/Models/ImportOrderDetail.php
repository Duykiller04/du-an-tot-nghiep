<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportOrderDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'import_order_id',
        'unit_id',
        'medicine_id',
        'date_added',
        'quantity',
        'import_price',
        'total',
        'note',
        'medication_name',
        'expiration_date',
    ];

    public function import_order()
    {
        return $this->belongsTo(ImportOrder::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
