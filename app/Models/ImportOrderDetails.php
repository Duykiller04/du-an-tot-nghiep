<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportOrderDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'import_order_id',
        'date_added',
        'quantity',
        'unit_id',
        'import_price',
        'total',
        'medicine_id',
        'note',
        'medication_name',
        'expiration_date',
        'medical_instruments_id',
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
    public function memedical_instrumentsdicine()
    {
        return $this->belongsTo(MedicalInstrument::class);
    }
}
