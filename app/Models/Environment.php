<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Environment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'environments';
    protected $fillable = [
        'storage_id',
        'time',
        'temperature',
        'huminity'
    ];
}
