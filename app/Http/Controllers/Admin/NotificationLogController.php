<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationLog;
use Illuminate\Http\Request;

class NotificationLogController extends Controller
{
    public function index()
    {
        $notification_log = NotificationLog::all(); 
        return view('admin.notification_log', compact('notification_log'));
    }
    public function deleteMultiple(Request $request)
    {
        $notificationIds = $request->input('notification_ids');
        if ($notificationIds) {
            NotificationLog::whereIn('id', $notificationIds)->delete();
            return redirect()->route('admin.notification_log.index')->with('success', 'Đã xóa các thông báo được chọn.');
        }
        return redirect()->route('admin.notification_log.index')->with('error', 'Vui lòng chọn ít nhất một thông báo.');
    }
}
