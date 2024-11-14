<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    use HasFactory;
    protected $table = 'notification_settings';

    
    protected $fillable = [
        'notification_enabled',
        'expiration_notification_days',
        'receive_email_notifications',
        'temperature_warning',
        'email',
        'auto_open_shift',
        'auto_close_shift',
        'close_after_minutes',
    ];
}
