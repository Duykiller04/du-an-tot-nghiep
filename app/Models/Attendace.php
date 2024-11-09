<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendace extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'shift_id',
        'img_check_in',
        'img_check_out',
        'time_out',
        'reasons',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function shift(){
        return $this->belongsTo(Shift::class);
    }
}
