<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShiftUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'shift_id',
    ];

    /**
     * Quan hệ với model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quan hệ với model Shift.
     */
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
