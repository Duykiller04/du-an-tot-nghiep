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
        'batch_id',
        'expected_quantity',
        'actual_quantity',
        'difference',
        'remarks',
    ];
    public function inventoryAudit()
    {
        return $this->belongsTo(InventoryAudit::class);
    }
    public function batch_id()
    {
        return $this->belongsTo(Batch::class);
    }
}
