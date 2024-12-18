<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpParser\Node\Expr\FuncCall;

class Medicine extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'category_id',
        'medicine_code',
        'name',
        'image',
        'active_ingredient',
        'concentration',
        'dosage',
        'administration_route',
        'type_product',
        'temperature',
        'moisture',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function CutDoseOrderDetails()
    {
        return $this->hasMany(CutDoseOrderDetails::class);
    }
    public function expirationNotifications()
    {
        return $this->hasMany(ExpirationNotification::class);
    }
    public function batches()
    {
        return $this->hasMany(Batch::class);
    }
    public function unitConversions()
    {
        return $this->hasMany(UnitConversion::class);
    }
    protected $casts = [
        'expiration_date' => 'datetime',
    ];

}
