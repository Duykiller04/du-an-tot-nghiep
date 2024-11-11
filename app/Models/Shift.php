<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shift extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'shift_name',
        'start_time',
        'end_time',
        'status',
        'revenue_summary',
    ];

 
    
    public function orders()
    {
        return $this->hasMany(CutDoseOrder::class, 'shift_id');
    }
    public function Prescription()
    {
        return $this->hasMany(Prescription::class, 'shift_id');
    }
    public function shiftuser()
    {
        return $this->hasMany(shiftUser::class, 'shift_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'shift_users', 'shift_id', 'user_id');
    }
    public function attendace(){
        return $this->hasOne(Attendace::class);
    }
}
