<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStorageRequest;
use App\Http\Requests\UpdateStorageRequest;
use App\Models\Storage;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Storage::query(); // Sử dụng Storage thay vì User

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
                ->addColumn('action', function ($row) {
                    $viewUrl = route('admin.storage.show', $row->id);  // Sửa đường dẫn cho storage
                    $editUrl = route('admin.storage.edit', $row->id);  // Sửa đường dẫn cho storage
                    $deleteUrl = route('admin.storage.destroy', $row->id);  // Sửa đường dẫn cho storage

                    return '
                        <a href="' . $viewUrl . '" class="btn btn-sm btn-primary">Xem</a>
                        <a href="' . $editUrl . '" class="btn btn-sm btn-warning">Sửa</a>
                        <form action="' . $deleteUrl  . '" method="post" style="display:inline;">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Bạn có chắc chắn muốn xóa?\')">Xóa</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $data = Storage::query()->latest('id')->paginate(5); // Giữ lại phần paginate nếu không có yêu cầu AJAX
        return view('admin.storage.index', compact('data')); // Chỉnh sửa lại tên view
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.storage.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStorageRequest $request)
    {
        try {
            $data = $request->all();
            Storage::create($data);
            return redirect()->route('admin.storage.index')->with('success', 'Thêm Thành công');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
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
    public function edit(Storage $storage)
    {
        return view('admin.storage.edit', compact('storage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStorageRequest $request, string $id)
    {
        try {
            $model = Storage::query()->findOrFail($id);

            $data = $request->all();
            $model->update($data);

            return back()->with('success', 'Sửa Thành công');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = Storage::query()->findOrFail($id);

        $model->delete();

        return back()->with('success', 'Xóa Thành công');
    }
}
