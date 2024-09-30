<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workshift extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'target',
        'is_applied',
        'start_time',
        'end_time',
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}
    
}
