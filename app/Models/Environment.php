<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpParser\Node\Expr\FuncCall;

class Environment extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'storage_id',
        'time',
        'temperature',
        'huminity'
    ];

    protected function storage(){
        return $this->belongsTo(Storage::class,'storage_id','id');
    }
}
