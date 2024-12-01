<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\SendMailToUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    const PATH_VIEW = 'admin.users.';
    public function index()
    {
        if (request()->ajax()) {
            $query = User::query()->latest('id');
            // Lọc theo ngày tháng nếu có
            if (request()->has('startDate') && request()->has('endDate')) {
                $startDate = request()->get('startDate');
                $endDate = request()->get('endDate');

                // Kiểm tra định dạng ngày và lọc
                if ($startDate && $endDate) {
                    // Convert to datetime to include the full day
                    $startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
                    $endDate = \Carbon\Carbon::parse($endDate)->endOfDay();

                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    if ($row->image) {
                        $url = Storage::url($row->image);
                        return '<a data-fancybox data-src="' . asset($url) . '" data-caption="Ảnh thuốc" ><img src="' . asset($url) . '" class="rounded-circle" width="50" height="50" alt="" /></a>';
                    } else {
                        $defaultImage = asset('theme/admin/assets/images/no-img-avatar.png');
                        return '<img src="' . $defaultImage . '" class="rounded-circle" width="50" height="50" alt="" />';
                    }
                })
                ->addColumn('created_at', function ($row) {
                    // Kiểm tra nếu có deleted_at, nếu không thì trả về null hoặc dấu -
                    return $row->created_at ? \Carbon\Carbon::parse($row->created_at)->format('d/m/Y') : '-';
                })
                ->addColumn('action', function ($row) {
                    $viewUrl = route('admin.users.show', $row->id);
                    $editUrl = route('admin.users.edit', $row->id);
                    $deleteUrl = route('admin.users.destroy', $row->id);

                    $actionHtml = '<a href="' . $viewUrl . '" class="btn btn-primary me-2">Xem</a>';
                    
                    // Nếu người dùng đăng nhập là 'staff', chỉ hiển thị nút sửa tài khoản của họ
                    if (Auth::user()->type === 'staff') {
                        if (Auth::id() === $row->id) {
                            $actionHtml .= '<a href="' . $editUrl . '" class="btn btn-warning">Sửa</a>';
                        }
                    } else {
                        // Với admin, hiển thị cả nút sửa và xóa
                        $actionHtml .= '
                            <a href="' . $editUrl . '" class="btn btn-warning me-2">Sửa</a>
                            <form action="' . $deleteUrl . '" method="post" style="display:inline;" class="delete-form">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="button" class="btn btn-danger btn-delete" data-id="' . $row->id . '">Xóa</button>
                            </form>
                        ';
                    }

                    return $actionHtml;
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $data = $request->except('image');

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $data['image'] = $image->store('users', 'public');
            } else {
                $data['image'] = null;
            }

            User::create($data);

            return redirect()->route('admin.users.index')->with('success', 'Thành công');
        } catch (\Exception $exception) {
            return back()->with('error' . $exception->getMessage());
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        try {
            $model = User::findOrFail($id);

            if (Auth::user()->type === 'staff' && Auth::id() != $id) {
                return back()->withErrors(['error' => 'Bạn không có quyền sửa tài khoản này.']);
            }

            // Lấy toàn bộ dữ liệu trừ 'image' và các trường mật khẩu
            $data = $request->except(['image', 'old_password', 'new_password', 'confirm_password']);
            $password = $request->new_password;
            // Lấy ảnh hiện tại của người dùng
            $currentImgThumb = $model->image;
            $currentEmail = $model->email;

            // Nếu người dùng tải lên ảnh mới
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $data['image'] = $image->store('users', 'public'); // Lưu ảnh mới
            } else {
                // Không thay đổi ảnh thì giữ ảnh cũ
                $data['image'] = $currentImgThumb;
            }

            // Kiểm tra và cập nhật mật khẩu nếu có nhập mật khẩu cũ, mới, và xác nhận mật khẩu
            if ($request->filled('old_password') || $request->filled('new_password') || $request->filled('confirm_password')) {
                // Kiểm tra mật khẩu cũ
                if (!Hash::check($request->old_password, $model->password)) {
                    return back()->withErrors(['old_password' => 'Mật khẩu cũ không chính xác.']);
                }

                // Kiểm tra mật khẩu mới và xác nhận mật khẩu
                $request->validate([
                    'new_password' => 'required|min:8',
                    'confirm_password' => 'same:new_password',
                ]);

                // Cập nhật mật khẩu mới
                $data['password'] = Hash::make($request->new_password);
            }

            // Cập nhật dữ liệu người dùng
            $model->update($data);

            // Xóa ảnh cũ nếu có ảnh mới và ảnh cũ tồn tại
            if ($request->hasFile('image') && $currentImgThumb && Storage::disk('public')->exists($currentImgThumb)) {
                Storage::disk('public')->delete($currentImgThumb);
            }
            Mail::to($currentEmail)->send(new SendMailToUser($model, $password));
            return back()->with('success', 'Cập nhật thành công');
        } catch (\Exception $exception) {
            Log::error('Lỗi cập nhật tài khoản ' . $exception->getMessage());
            return back()->with('error', 'Cập nhật thất bại: ' . $exception->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = User::query()->findOrFail($id);

        if (Auth::user()->type === 'staff') {
            return back()->withErrors(['error' => 'Bạn không có quyền xóa tài khoản.']);
        }

        $data->delete();

        if ($data->image && Storage::exists($data->image)) {
            Storage::delete($data->image);
        }

        return back()->with('success', 'Thành công');
    }
    public function getRestore()
    {
        $data = User::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('admin.users.restore', compact('data'));
    }
    public function restore(Request $request)
    {
        // dd($request->all());
        try {
            $userIds = $request->input('ids');
            if ($userIds) {
                User::onlyTrashed()->whereIn('id', $userIds)->restore();
                return back()->with('success', 'Khôi phục bản ghi thành công.');
            } else {
                return back()->with('error', 'Không bản ghi nào cần khôi phục.');
            }
        } catch (\Exception $exception) {
            Log::error('Lỗi xảy ra: ' . $exception->getMessage());
            return back()->with('error', 'Khôi phục bản ghi thất bại.');
        }
    }
}


// đâye code