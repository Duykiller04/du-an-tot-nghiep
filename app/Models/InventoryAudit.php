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
        'user_id',
    ];
    protected function detail(){
        return $this->hasMany(InventoryCheckDetail::class,'inventory_audit_id','id');
    }
    protected function storage(){
        return $this->belongsTo(Storage::class,'storage_id','id');
    }
    protected function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
