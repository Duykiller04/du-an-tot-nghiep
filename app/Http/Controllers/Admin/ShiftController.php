<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CutDoseOrder;
use App\Models\Shift;
use App\Models\ShiftUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date = $request->input('date');
        $status = $request->input('status', 'all');

        $query = Shift::with('users');

        if ($date) {
            $dates = explode(' to ', $date);
            if (count($dates) == 2) {
                $query->whereBetween('start_time', [$dates[0], $dates[1]]);
            }
        }

        if ($status != 'all') {
            $query->where('status', $status);
        }

        $shifts = $query->orderBy('start_time', 'asc')->get();
        $getStatusClass = function ($status) {
            switch ($status) {
                case 'kế hoạch':
                    return 'bg-warning text-dark'; // Màu vàng cho 'kế hoạch'
                case 'đang mở':
                    return 'bg-success text-white'; // Màu xanh cho 'đang mở'
                case 'tạm dừng':
                    return 'bg-secondary text-white'; // Màu xám cho 'tạm dừng'
                case 'đã chốt':
                    return 'bg-primary text-white'; // Màu xanh dương cho 'đã chốt'
                case 'đã hủy':
                    return 'bg-danger text-white'; // Màu đỏ cho 'đã hủy'
                default:
                    return ''; // Mặc định không có màu
            }
        };

        return view('admin.shift.index', compact('shifts', 'getStatusClass'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::where('type', 'staff')->get();
        //$user = User::all();
        //dd($user);
        return view('admin.shift.add', ['user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'start_time' => 'required|date|after_or_equal:today',
            'end_time' => 'required|date|after:start_time',
            'details.*.user_id' => 'required|exists:users,id',
        ],[
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'title.string' => 'Tiêu đề phải là một chuỗi.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            
            'start_time.required' => 'Vui lòng nhập thời gian bắt đầu.',
            'start_time.date' => 'Thời gian bắt đầu không hợp lệ.',
            'start_time.after_or_equal' => 'Thời gian bắt đầu phải là ngày hôm nay hoặc sau đó.',
            
            'end_time.required' => 'Vui lòng nhập thời gian kết thúc.',
            'end_time.date' => 'Thời gian kết thúc không hợp lệ.',
            'end_time.after' => 'Thời gian kết thúc phải sau thời gian bắt đầu.',
            
            'details.*.user_id.required' => 'Vui lòng chọn người dùng.',
            'details.*.user_id.exists' => 'Người dùng không tồn tại.',
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $shift = Shift::create([
            'shift_name' => $request->title,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'Kế hoạch',
            'revenue_summary' => 0,
        ]);

        foreach ($request->details as $detail) {
            ShiftUser::create([
                'users_id' => $detail['user_id'],
                'shift_id' => $shift->id,
            ]);
        }

        return redirect()->route('admin.shifts.index')->with('success', 'Tạo ca làm thành công.');
    }


    public function edit($id)
    {
        $shift = Shift::with('shiftuser.user')->findOrFail($id);

        $statusOptions = ['kế hoạch', 'đang mở', 'tạm dừng', 'đã chốt', 'đã hủy'];

        $users = User::all();

        // Lấy ID của những nhân viên trong ca làm hiện tại
        $checkedUsers = $shift->shiftuser->pluck('users_id')->toArray();

        $orders = CutDoseOrder::all();
        //dd($checkedUsers);
        return view('admin.shift.edit', compact('shift', 'statusOptions', 'users', 'orders', 'checkedUsers'));
    }



    public function update(Request $request, $id)
    {
        // Xác thực dữ liệu
        $request->validate([
            'shift_name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'details' => 'required|array',
            'details.*.user_id' => 'required|exists:users,id',
        ],[
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'title.string' => 'Tiêu đề phải là một chuỗi.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            
            'start_time.required' => 'Vui lòng nhập thời gian bắt đầu.',
            'start_time.date' => 'Thời gian bắt đầu không hợp lệ.',
            'start_time.after_or_equal' => 'Thời gian bắt đầu phải là ngày hôm nay hoặc sau đó.',
            
            'end_time.required' => 'Vui lòng nhập thời gian kết thúc.',
            'end_time.date' => 'Thời gian kết thúc không hợp lệ.',
            'end_time.after' => 'Thời gian kết thúc phải sau thời gian bắt đầu.',
            
            'details.*.user_id.required' => 'Vui lòng chọn người dùng.',
            'details.*.user_id.exists' => 'Người dùng không tồn tại.',
        ]);

        // Tìm ca làm theo ID
        $shift = Shift::findOrFail($id);
        if (!in_array($shift->status, ['kế hoạch', 'đã hủy'])) {
            return back()->with('error', 'Chỉ có thể cập nhật ca làm ở trạng thái "kế hoạch" hoặc "đã hủy".')->withInput();
        }

        // Cập nhật thông tin ca làm
        $shift->shift_name = $request->input('shift_name');
        $shift->start_time = $request->input('start_time');
        $shift->end_time = $request->input('end_time');

        // Lưu ca làm
        $shift->save();

        // Xóa các nhân viên cũ liên quan đến ca làm
        $shift->shiftuser()->delete();

        // Thêm lại các nhân viên mới
        foreach ($request->input('details') as $detail) {
            $shift->shiftuser()->create(['users_id' => $detail['user_id']]);
        }

        // Thông báo thành công và chuyển hướng
        return redirect()->route('admin.shifts.index')->with('success', 'Cập nhật ca làm thành công!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       
        $shift = Shift::find($id);

        
        if (!$shift) {
            return redirect()->route('admin.shifts.index')->with('error', 'Ca làm việc không tồn tại.');
        }

       
        if ($shift->status !== 'kế hoạch' && $shift->status !== 'đã hủy') {
            return redirect()->route('admin.shifts.index')->with('error', 'Chỉ có thể xóa ca làm việc ở trạng thái "kế hoạch" hoặc "đã hủy".');
        }

        
        $shift->delete();

        return redirect()->route('admin.shifts.index')->with('success', 'Ca làm việc đã được xóa thành công.');
    }
}
