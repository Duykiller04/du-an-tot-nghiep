<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = NotificationSetting::first();
        //dd($settings);
        return view('admin.config_notice', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //dd($request);
        // Validate dữ liệu từ form
        $validated = $request->validate([
            'expiration_notification_days' => 'required|integer|min:1',
            'email' => 'required|email',
            'close_after_minutes' => 'nullable|integer|min:1'
        ]);

        // Lấy thông tin cấu hình hiện tại
        $settings = NotificationSetting::findOrFail($id);

        // Xử lý giá trị của các checkbox
        $notification_enabled = $request->input('notification_enabled') === 'on' ? true : false;
        $receive_email_notifications = $request->input('receive_email_notifications') === '1' ? true : false;
        $auto_open_shift = $request->input('auto_open_shift') === '1';
        $auto_close_shift = $request->input('auto_close_shift') === '1';

        // Cập nhật dữ liệu
        $settings->update([
            'notification_enabled' => $notification_enabled,
            'expiration_notification_days' => $validated['expiration_notification_days'],
            'email'=> $validated['email'],
            'receive_email_notifications' => $receive_email_notifications,
            'auto_open_shift' => $auto_open_shift,
            'auto_close_shift' => $auto_close_shift,
            'close_after_minutes' => $validated['close_after_minutes'],
        ]);

        // Điều hướng lại trang cấu hình với thông báo thành công
        return redirect()->route('admin.setting.index')->with('success', 'Cấu hình đã được cập nhật thành công.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
