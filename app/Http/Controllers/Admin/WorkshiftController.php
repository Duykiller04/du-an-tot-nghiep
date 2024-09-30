<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkshiftRequest;
use App\Http\Requests\UpdateWorkshiftRequest;
use App\Models\Workshift;
use Illuminate\Http\Request;
use App\Models\User;

class WorkshiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $workshifts = Workshift::with('user')->latest('id')->paginate(10);
    return view('admin.workshifts.index', compact('workshifts'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all(); // Lấy danh sách tất cả người dùng
        return view('admin.workshifts.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkshiftRequest $request)
    {
        try {
            Workshift::create($request->validated());
            return redirect()->route('admin.workshifts.index')->with('success', 'Ca làm việc đã được tạo thành công.');
        } catch (\Exception $exception) {
            return back()->withErrors(['error' => 'Đã xảy ra lỗi: ' . $exception->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $workshift = Workshift::with('user')->findOrFail($id);
    return view('admin.workshifts.show', compact('workshift'));
}

    


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $workshift = Workshift::findOrFail($id); // Tìm workshift theo id, nếu không tìm thấy sẽ trả về lỗi 404
    $users = User::all(); // Lấy danh sách tất cả người dùng để có thể chọn lại nếu cần
    return view('admin.workshifts.edit', compact('workshift', 'users'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkshiftRequest $request, Workshift $workshift)
    {
        try {
            $workshift->update($request->validated());
            return redirect()->route('admin.workshifts.index')->with('success', 'Ca làm việc đã được cập nhật thành công.');
        } catch (\Exception $exception) {
            return back()->withErrors(['error' => 'Đã xảy ra lỗi: ' . $exception->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workshift $workshift)
    {
        try {
            $workshift->delete();
            return redirect()->route('admin.workshifts.index')->with('success', 'Ca làm việc đã được xóa thành công.');
        } catch (\Exception $exception) {
            return back()->withErrors(['error' => 'Đã xảy ra lỗi: ' . $exception->getMessage()]);
        }
    }
}
