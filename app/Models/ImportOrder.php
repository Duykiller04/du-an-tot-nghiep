<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'storage_id',
        'supplier_id',
        'total',
        'price_paid',
        'still_in_debt',
        'date_added',
        'note',
        'status',
    ];

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
