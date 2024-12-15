<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportOrderRequest;
use App\Http\Requests\StoreImportOrderRequest;
use App\Models\Batch;
use App\Models\Category;
use App\Models\ImportOrder;
use App\Models\ImportOrderDetail;
use App\Models\Inventory;
use App\Models\Medicine;
use App\Models\Storage;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\UnitConversion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ImportOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = ImportOrder::query()->with(['user', 'storage', 'supplier'])->latest('id');

            // Lọc theo ngày tháng nếu có
            if (request()->has('startDate') && request()->has('endDate')) {
                $startDate = request()->get('startDate');
                $endDate = request()->get('endDate');

                // Kiểm tra định dạng ngày và lọc
                if ($startDate && $endDate) {
                    // Chuyển đổi sang datetime để bao gồm cả ngày
                    $startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
                    $endDate = \Carbon\Carbon::parse($endDate)->endOfDay();

                    // Lọc theo trường date_added thay vì created_at
                    $query->whereBetween('date_added', [$startDate, $endDate]);
                }
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('user_name', function ($row) {
                    return $row->user->name ?? '';  // Lấy tên từ bảng user
                })
                ->addColumn('storage_location', function ($row) {
                    return $row->storage->location ?? '';  // Lấy vị trí từ bảng storage
                })
                ->addColumn('supplier_name', function ($row) {
                    return $row->supplier->name ?? '';  // Lấy tên từ bảng supplier
                })
                ->addColumn('total', function ($row) {
                    return number_format($row->total) . ' VND';  // Format price
                })
                ->addColumn('action', function ($row) {
                    $viewUrl = route('admin.importorder.show', $row->id);
                    $deleteUrl = route('admin.importorder.destroy', $row->id);

                    return '
                <a href="' . $viewUrl . '" class="btn btn-primary">Xem</a>
                <form action="' . $deleteUrl . '" method="post" style="display:inline;" class="delete-form">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button type="button" class="btn btn-danger btn-delete" data-id="' . $row->id . '">Xóa</button>
                </form>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $importOrders = ImportOrder::with(['user', 'storage', 'supplier'])
            ->latest('id')
            ->get();

        return view('admin.importorder.index', compact('importOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Lấy danh sách các nhà cung cấp, kho, hoặc các dữ liệu khác nếu cần
        $suppliers = Supplier::query()->get();
        $storages = Storage::query()->get();
        $medicines = Medicine::query()->get(); // Nếu cần để chọn thuốc
        $users = User::query()->get(); // Nếu cần để chọn người dùng
        $units = Unit::query()->get();
        $categories = Category::query()->get(); // Lấy danh sách danh mục thuốc

        return view('admin.importorder.create', compact('suppliers', 'storages', 'medicines', 'users', 'units', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // Phương thức lưu đơn nhập kho

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            DB::beginTransaction();

            // Tạo đơn nhập kho
            $importOrder = ImportOrder::create([
                'user_id' => $data['user_id'],
                'note' => $data['note'],
                'total' => array_sum(array_column($data['details'], 'total')),
                'date_added' => now(),
            ]);

            // Tạo chi tiết đơn nhập kho
            foreach ($data['details'] as $detail) {

                $batch = Batch::create([
                    'medicine_id' => $detail['medicine_id'],
                    'supplier_id' => $detail['supplier_id'],
                    'storage_id' => $detail['storage_id'],
                    'registration_number' => $detail['registration_number'],
                    'origin' => $detail['origin'],
                    'price_import' => $detail['price_import'],
                    'price_sale' => $detail['price_sale'],
                    'status_expiry' => 0,
                    'expiration_date' => $detail['expiration_date'],
                    'packaging_specification' => $detail['packaging_specification'],
                    'price_in_smallest_unit' => $detail['price_sale'] / $detail['largest_proportion'],
                ]);

                Inventory::create([
                    'batch_id' => $batch->id,
                    'storage_id' => $detail['storage_id'],
                    'quantity' => $detail['quantity'] * $detail['proportion'],
                    'unit_id' => $detail['smallest_unit_id'],
                ]);

                ImportOrderDetail::create([
                    'medication_name' => $detail['name_medicine'],
                    'unit_id' => $detail['unit_id'],
                    'medicine_id' => $detail['medicine_id'],
                    'import_order_id' => $importOrder->id,
                    'date_added' => now(),
                    'quantity' => $detail['quantity'],
                    'import_price' => $detail['price_import'],
                    'total' => $detail['total'],
                    'expiration_date' => $detail['expiration_date'],
                ]);
            }

            DB::commit();
            return redirect()->route('admin.importorder.index')->with('success', 'Đơn nhập kho đã được tạo thành công!');
        } catch (\Exception $e) {
            Log::error("Lỗi nhập kho: " . $e->getMessage());
            DB::rollback();
            dd($e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Lấy đơn hàng nhập kho và các chi tiết của nó
        $importOrder = ImportOrder::with('details.unit', 'details.medicine')->findOrFail($id);

        return view('admin.importorder.show', compact('importOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd( $id);
        $importOrder = ImportOrder::withTrashed()->find($id);
        if ($importOrder) {
            // Xóa tất cả các chi tiết liên quan trước
            DB::table('import_order_details')->where('import_order_id', $id)->delete();

            // Xóa bản ghi chính
            $importOrder->delete();

            // Đưa người dùng trở lại trang danh sách với thông báo thành công
            return redirect()->route('admin.importorder.index')->with('success', 'Phiếu nhập thuốc đã được xóa thành công.');
        }

        // Nếu không tìm thấy bản ghi, quay lại với thông báo lỗi
        return redirect()->route('admin.importorder.index')->with('error', 'Phiếu nhập thuốc không tồn tại.');
    }

    public function getRestore()
    {
        $data = ImportOrder::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('admin.importorder.restore', compact('data'));
    }

    public function restore(Request $request)
    {
        try {
            $importorderIds = $request->input('ids');
            if ($importorderIds) {
                ImportOrder::onlyTrashed()->whereIn('id', $importorderIds)->restore();
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
