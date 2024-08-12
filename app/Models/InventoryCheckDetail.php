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
    protected function inventoryaudit(){
        return $this->belongsTo(InventoryAudit::class,'inventory_audit_id','id');
    }
    protected function medicine(){
        return $this->belongsTo(Medicine::class,'medicine_id','id');
    }
    protected function medicalinstrument(){
        return $this->belongsTo(MedicalInstrument::class,'medical_instrument_id','id');
    }
}
