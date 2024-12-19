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
    public function prescription_details(){
        return $this->hasMany(PrescriptionDetail::class,'prescription_id');
    }
    public function import_order_details(){
        return $this->hasMany(ImportOrderDetail::class,'import_order_id');
    }

    public function cut_dose_order_details(){
        return $this->hasMany(CutDoseOrderDetails::class,'cut_dose_order_id');
    }
    public function cut_dose_prescription_details(){
        return $this->hasMany(CutDosePrescriptionDetail::class,'cut_dose_prescription_id');
    }
    protected $casts = [
        'expiration_date' => 'datetime',
    ];

}
