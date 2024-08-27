<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryAudit extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'storage_id',
        'check_date',
        'checked_by',
        'status',
        'remarks'
    ];
    public function details()
    {
        return $this->hasMany(InventoryCheckDetail::class);
    }
    public function storage()
    {
        return $this->belongsTo(Storage::class, 'storage_id', 'id');
    }
    
}
