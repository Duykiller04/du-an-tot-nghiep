<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    const TYPE_ADMIN = 'admin';
    const TYPE_STAFF = 'staff';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'address',
        'birth',
        'image',
        'description',
        'email',
        'password',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function importOrder()
    {
        return $this->hasMany(ImportOrder::class);
    }
    public function inventoryAudit(){
        return $this->hasMany(InventoryAudit::class);
    }

    public function isAdmin()
    {
        return $this->type === self::TYPE_ADMIN;
    }

    public function isStaff()
    {
        return $this->type === self::TYPE_STAFF;
    }


    // public function getTypeAttribute($value)
    // {
    //     return $value ? self::TYPE_ADMIN : self::TYPE_STAFF;
    // }

    //Tùy chỉnh việc trả về giá trị của thuộc tính "type".
    //Trả về self::TYPE_ADMIN nếu giá trị gốc là true, ngược lại trả về self::TYPE_STAFF

    // public function setTypeAttribute($value)
    // {
    //     $this->attributes['type'] = $value ? self::TYPE_ADMIN : self::TYPE_STAFF;
    // }

    //Tùy chỉnh việc gán giá trị cho thuộc tính "type".
    //Gán self::TYPE_ADMIN nếu giá trị mới là true, ngược lại gán self::TYPE_STAFF.
}
