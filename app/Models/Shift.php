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

    /**
     * Quan hệ nhiều-nhiều với người dùng (users) thông qua bảng shift_users.
     */
    
    public function order()
    {
        return $this->hasMany(CutDoseOrder::class, 'shift_id');
    }
    public function shiftuser()
    {
        return $this->hasMany(shiftUser::class, 'shift_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'shift_users', 'shift_id', 'users_id');
    }
}
