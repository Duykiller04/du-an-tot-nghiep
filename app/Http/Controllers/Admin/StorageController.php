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
            $query = Storage::query()
                ->select('storages.*')
                ->selectSub(function ($query) {
                    $query->from('batches')
                        ->selectRaw('COUNT(DISTINCT medicine_id)')
                        ->whereColumn('batches.storage_id', 'storages.id');
                }, 'medicines_count')
                ->latest('id');

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
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $viewUrl = route('admin.storage.show', $row->id);
                    $deleteUrl = route('admin.storage.destroy', $row->id);
                    return '
                    <a href="' . $viewUrl . '" class="btn btn-info view-btn">Xem</a>
                    <button class="btn btn-warning edit-btn" 
                            data-id="' . $row->id . '" 
                            data-name="' . $row->name . '" 
                            data-location="' . $row->location . '">Sửa</button>
                    <form action="' . $deleteUrl . '" method="post" style="display:inline;" class="delete-form">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="button" class="btn btn-danger btn-delete" data-id="' . $row->id . '">Xóa</button>
                    </form>
                ';
                })
                ->addColumn('created_at', function ($row) {
                    return \Carbon\Carbon::parse($row->created_at)->format('d-m-Y');
                })
                ->addColumn('medicine_count', function ($row) {
                    return $row->medicines_count;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $totalMedicines = Storage::query()
            ->select('storages.*')
            ->selectSub(function ($query) {
                $query->from('batches')
                    ->selectRaw('COUNT(DISTINCT medicine_id)')
                    ->whereColumn('batches.storage_id', 'storages.id');
            }, 'medicines_count')
            ->latest('id');

        // Nếu không phải yêu cầu AJAX, trả về view
        $data = Storage::query()->latest('id')->paginate(5);
        return view('admin.storage.index', compact('data', 'totalMedicines'));
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
            // Gán thủ công các giá trị từ request với tên trường đúng trong DB
            $data = [
                'name' => $request->input('nameCreate'), // Lấy từ form 'nameCreate' và gán vào trường 'name'
                'location' => $request->input('locationCreate') // Lấy từ form 'locationCreate' và gán vào trường 'location'
            ];

            Storage::create($data);

            return redirect()->route('admin.storage.index')->with('success', 'Thêm Thành công');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Lấy thông tin kho theo ID
        $storage = Storage::with('batches.medicine', 'batches.inventory.unit')->findOrFail($id);

        // Lấy danh sách thuốc liên quan đến các lô trong kho
        $medicines = $storage->batches
            ->map(function ($batch) {
                $medicine = $batch->medicine;
                if ($medicine) {
                    $medicine->batch_info = $batch;
                    $medicine->inventory_info = $batch->inventory;
                }
                return $medicine;
            })
            ->filter(); // Loại bỏ null trong trường hợp không có thuốc liên quan

        return view('admin.storage.show', compact('storage', 'medicines'));
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

            $data = [
                'name' => $request->input('edit-name'), // Gán đúng tên trong DB
                'location' => $request->input('edit-location'), // Gán đúng tên trong DB
            ];
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
        $data = Storage::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(5);
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
