<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpirationNotification extends Model
{
    use HasFactory;
    protected $table = 'expiration_notifications';

    // Các cột có thể được fill
    protected $fillable = [
        'medicine_id',
        'batch_id',
        'notified_at',
        'notification_sent',
        'message',
        'expiration_date',
    ];

    /**
     * Quan hệ belongsTo với bảng medicines
     */
    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id');
    }
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
