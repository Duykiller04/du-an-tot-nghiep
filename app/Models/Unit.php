<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'name',
        'parent_id',
    ];
    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }
    public function parent(){
        return $this->belongsTo(Unit::class, 'parent_id');
    }
    public function children(){
        return $this->hasMany(Unit::class, 'parent_id');
    }
    public function unitConversions()
    {
        return $this->hasMany(UnitConversion::class, 'unit_id');
    }
}
