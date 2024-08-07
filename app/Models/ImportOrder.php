<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'total',
        'price_paid',
        'still_in_debt',
        'storage_id',
        'supplier_id',
        'input_day',
        'note',
        'status',
        'user_id',
    ];

    public function storage()
    {
        return $this->hasMany(Storage::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function supplier()
    {
        return $this->hasMany(Supplier::class);
    }
}
