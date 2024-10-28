<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStorageRequest;
use App\Http\Requests\UpdateStorageRequest;
use App\Models\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Storage::query()->withCount('medicines'); // Thêm withCount để đếm số lượng thuốc

            // Lọc theo ngày tháng nếu có
            if (request()->has('startDate') && request()->has('endDate')) {
                $startDate = request()->get('startDate');
                $endDate = request()->get('endDate');

                if ($startDate && $endDate) {
                    $startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
                    $endDate = \Carbon\Carbon::parse($endDate)->endOfDay();

                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }

            return DataTables::of($query)
                ->addIndexColumn() // Thêm số thứ tự
                ->addColumn('action', function ($row) {
                    $viewUrl = route('admin.storage.show', $row->id);
                    $editUrl = route('admin.storage.edit', $row->id);
                    $deleteUrl = route('admin.storage.destroy', $row->id);

                    return '
                        <a href="' . $viewUrl . '" class="btn btn-primary">Xem</a>
                        <a href="' . $editUrl . '" class="btn btn-warning">Sửa</a>
                        <form action="' . $deleteUrl . '" method="post" style="display:inline;">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger" onclick="return confirm(\'Bạn có chắc chắn muốn xóa?\')">Xóa</button>
                        </form>
                    ';
                })
                ->addColumn('created_at', function ($row) {
                    return \Carbon\Carbon::parse($row->created_at)->format('d-m-Y'); // Định dạng ngày
                })
                ->addColumn('medicine_count', function ($row) {
                    return $row->medicines_count; // Sử dụng tên cột chính xác
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // Nếu không phải yêu cầu AJAX, trả về view
        $data = Storage::query()->latest('id')->paginate(5);
        return view('admin.storage.index', compact('data'));
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

    public function getRestore()
    {
        $data = Storage::onlyTrashed()->get();
        return view('admin.storage.restore', compact('data'));
    }
    public function restore(Request $request)
    {
        try {
            $storageIds = $request->input('ids');
            if ($storageIds) {
                Storage::onlyTrashed()->whereIn('id', $storageIds)->restore();
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
