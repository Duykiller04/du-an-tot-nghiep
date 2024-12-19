<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckInRequest;
use App\Http\Requests\CheckOutRequest;
use App\Models\Attendace;
use App\Models\Shift;
use App\Models\ShiftUser;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shifts = ShiftUser::with('shift')
            ->where('user_id', Auth::user()->id)
            ->whereHas('shift', function ($query) {
                $query->whereIn('status', ['đang mở', 'đã chốt']);
            })
            ->latest('id')
            ->get();
        $getStatusClass = function ($status) {
            switch ($status) {
                case 'đang mở':
                    return 'bg-success text-white'; // Màu xanh cho 'đang mở'
                case 'đã chốt':
                    return 'bg-primary text-white'; // Màu xanh dương cho 'đã chốt'
                default:
                    return ''; // Mặc định không có màu
            }
        };
        return view('admin.attendance.index', compact('shifts', 'getStatusClass'));
    }

    public function checkin(CheckInRequest $request)
    {
        // Lấy dữ liệu ảnh base64 từ input
        $base64Image = $request->input('captured_image');

        // Tách chuỗi base64 để lấy dữ liệu ảnh (loại bỏ tiền tố "data:image/png;base64,")
        list($type, $imageData) = explode(';', $base64Image);
        list(, $imageData) = explode(',', $imageData);

        // Giải mã dữ liệu base64
        $imageData = base64_decode($imageData);

        // Tạo tên file duy nhất để tránh trùng lặp
        $fileName = 'checkin_' . time() . '.png';

        // Lưu ảnh vào thư mục public/checkin_images
        $path = public_path('storage/checkin_images');

        // Kiểm tra nếu thư mục chưa tồn tại thì tạo mới
        if (!file_exists($path)) {
            mkdir($path, 0777, true);  // Tạo thư mục nếu chưa có
        }

        // Đường dẫn đầy đủ tới ảnh
        $filePath = $path . '/' . $fileName;

        // Lưu ảnh vào thư mục
        file_put_contents($filePath, $imageData);

        // Lưu đường dẫn vào cơ sở dữ liệu (chỉ lưu phần đường dẫn có thể truy cập công khai)
        $imageUrl = 'storage/checkin_images/' . $fileName;

        // Tạo bản ghi mới trong bảng Attendace
        Attendace::where('user_id', Auth::user()->id)
            ->where('shift_id', $request->shift_id)
            ->update([
                'img_check_in' => $imageUrl,
                'time_in' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

        // Trả về thông báo thành công
        return back()->with('success', 'Check-in thành công!');
    }

    public function checkout(CheckOutRequest $request)
    {
        // Lấy dữ liệu ảnh base64 từ input
        $base64Image = $request->input('captured_image');

        // Tách chuỗi base64 để lấy dữ liệu ảnh (loại bỏ tiền tố "data:image/png;base64,")
        list($type, $imageData) = explode(';', $base64Image);
        list(, $imageData) = explode(',', $imageData);

        // Giải mã dữ liệu base64
        $imageData = base64_decode($imageData);

        // Tạo tên file duy nhất để tránh trùng lặp
        $fileName = 'checkin_' . time() . '.png';

        // Lưu ảnh vào thư mục public/checkin_images
        $path = public_path('storage/checkin_images');

        // Kiểm tra nếu thư mục chưa tồn tại thì tạo mới
        if (!file_exists($path)) {
            mkdir($path, 0777, true);  // Tạo thư mục nếu chưa có
        }

        // Đường dẫn đầy đủ tới ảnh
        $filePath = $path . '/' . $fileName;

        // Lưu ảnh vào thư mục
        file_put_contents($filePath, $imageData);

        // Lưu đường dẫn vào cơ sở dữ liệu (chỉ lưu phần đường dẫn có thể truy cập công khai)
        $imageUrl = 'storage/checkin_images/' . $fileName;

        // Check out
        $attendace = Attendace::where('shift_id', $request->input('shift_id'))->first();

        if ($request->reasons) {
            //check out lan 2
            $attendace->update([
                'img_check_out' => $imageUrl,
                'time_out_2' => Carbon::now()->format('Y-m-d H:i:s'),
                'reasons' => $request->reasons,
            ]);
            return back()->with('success', 'Check-out thành công!');
        } else {
            $attendace->update([
                'img_check_out' => $imageUrl,
                'time_out' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
            return back()->with('success', 'Check-out thành công!');
        }
    }

    public function listAttendace(Request $request){
        $userId = auth()->id(); // Lấy ID của user đang đăng nhập
        $month = $request->get('month', now()->format('m')); // Lấy tháng hiện tại hoặc từ request
        $year = $request->get('year', now()->format('Y')); // Lấy năm hiện tại hoặc từ request

        $attendances = Attendace::with('shift')->where('user_id', $userId)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderByDesc('created_at')
            ->paginate(10);

        $lateCount = 0;
        $earlyCount = 0;
        $missedDays = 0;
        
        foreach ($attendances as $attendance) {
            $shiftEndTime = Carbon::parse($attendance->shift->end_time);

            // Nếu đã hết ca làm và không có điểm danh
            if (Carbon::now()->gt($shiftEndTime) && !$attendance->time_in) {
                $missedDays++;
                continue; // Bỏ qua các logic khác nếu đã xác định là không đi làm
            }

            // Kiểm tra đi muộn
            $timeIn = Carbon::parse($attendance->time_in);
            $lateTime = Carbon::parse($attendance->shift->start_time)->addMinutes(5);
            if ($timeIn && $timeIn->gt($lateTime)) {
                $lateCount++;
            }

            // Kiểm tra về sớm
            if ($attendance->time_out && Carbon::parse($attendance->time_out)->lt($shiftEndTime)) {
                $earlyCount++;
            }
        }

        return view('admin.attendance.list', compact('attendances', 'month', 'year', 'lateCount', 'earlyCount', 'missedDays'));
    }

    public function listAttendaceUser(Request $request)
    {
        $userId = $request->get('user_id');
        $month = $request->get('month', now()->format('m'));
        $year = $request->get('year', now()->format('Y'));
        $arrUsers = User::where('type', 'staff')->get();

        $attendances = Attendace::with(['shift', 'user'])
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month);

        if ($userId) {
            $attendances = $attendances->where('user_id', $userId);
        }

        $attendances = $attendances->orderByDesc('created_at')->paginate(10);

        $lateCount = 0;
        $earlyCount = 0;
        $missedDays = 0;
        
        foreach ($attendances as $attendance) {
            $shiftEndTime = Carbon::parse($attendance->shift->end_time);

            // Nếu đã hết ca làm và không có điểm danh
            if (Carbon::now()->gt($shiftEndTime) && !$attendance->time_in) {
                $missedDays++;
                continue; // Bỏ qua các logic khác nếu đã xác định là không đi làm
            }

            // Kiểm tra đi muộn
            $timeIn = Carbon::parse($attendance->time_in);
            $lateTime = Carbon::parse($attendance->shift->start_time)->addMinutes(5);
            if ($timeIn && $timeIn->gt($lateTime)) {
                $lateCount++;
            }

            // Kiểm tra về sớm
            if ($attendance->time_out && Carbon::parse($attendance->time_out)->lt($shiftEndTime)) {
                $earlyCount++;
            }
        }

        return view('admin.attendance.list_user', compact('attendances', 'month', 'year', 'arrUsers', 'userId','lateCount', 'earlyCount', 'missedDays'));
    }
}
