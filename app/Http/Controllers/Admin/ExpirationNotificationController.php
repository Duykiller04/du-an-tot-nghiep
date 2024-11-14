<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpirationNotification;
use App\Models\Medicine;
use Illuminate\Http\Request;

class ExpirationNotificationController extends Controller
{
    public function index()
    {
        $notifications = ExpirationNotification::with('medicine')->get(); 
        return view('admin.notification', compact('notifications'));
    }
    public function deleteMultiple(Request $request)
    {
        $notificationIds = $request->input('notification_ids');
        if ($notificationIds) {
            ExpirationNotification::whereIn('id', $notificationIds)->delete();
            return redirect()->route('admin.notifications.index')->with('success', 'Đã xóa các thông báo được chọn.');
        }
        return redirect()->route('admin.notifications.index')->with('error', 'Vui lòng chọn ít nhất một thông báo.');
    }
}
