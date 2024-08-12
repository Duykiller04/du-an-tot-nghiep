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
        'customer_id',
    ];
    protected function detail(){
        return $this->hasMany(InventoryCheckDetail::class,'inventory_audit_id','id');
    }
    protected function storage(){
        return $this->belongsTo(Storage::class,'storage_id','id');
    }
    protected function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
}
