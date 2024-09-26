<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImportOrderRequest;
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
            $query = ImportOrder::query()->with(['user', 'storage', 'supplier']);

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
                ->addColumn('user_name', function ($row) {
                    return $row->user->name ?? '';  // Lấy tên từ bảng user
                })
                ->addColumn('storage_location', function ($row) {
                    return $row->storage->location ?? '';  // Lấy vị trí từ bảng storage
                })
                ->addColumn('supplier_name', function ($row) {
                    return $row->supplier->name ?? '';  // Lấy tên từ bảng supplier
                })
                ->addColumn('action', function ($row) {
                    $viewUrl = route('admin.importorder.show', $row->id);
                    $deleteUrl = route('admin.importorder.destroy', $row->id);

                    return '
                <a href="' . $viewUrl . '" class="btn btn-primary">Xem</a>
                <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button type="submit" class="btn btn-danger" onclick="return confirm(\'Bạn có chắc chắn muốn xóa?\')">Xóa</button>
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
        dd($request->all());
        $data = $request->all();

        $quantities = [];
        $units = [];

        // Duyệt qua từng detail
        if (isset($data['details']) && is_array($data['details'])) {
            foreach ($data['details'] as $key => $detail) {
                // Khởi tạo mảng con cho từng detail
                $quantities[$key] = [];
                $units[$key] = [];
    
                if (isset($detail['units']) && is_array($detail['units'])) {
                    foreach ($detail['units'] as $unitDetail) {
                        // Lấy quantity và unit, thêm vào mảng con
                        if (isset($unitDetail['quantity']) && isset($unitDetail['unit'])) {
                            $quantities[$key][] = $unitDetail['quantity'];
                            $units[$key][] = $unitDetail['unit'];
                        }
                    }
                }
            }
        }

        // Debug: kiểm tra xem quantities và units đã lấy đúng chưa
        dd($quantities, $units);

        try {
            DB::beginTransaction();

            // Tạo đơn nhập kho
            $importOrder = ImportOrder::query()->create($request->all());

            // Tạo chi tiết đơn nhập kho
            foreach ($request->details as $detail) {
                // Kiểm tra xem units có tồn tại không
                if (!isset($detail['units']) || empty($detail['units'])) {
                    throw new \Exception('Thiếu thông tin đơn vị cho thuốc: ' . json_encode($detail));
                }

                // Lấy đơn vị đầu tiên làm unit_id
                $detail['unit_id'] = $detail['units'][0]['unit']; // Lấy đơn vị đầu tiên

                // Kiểm tra xem quantity có tồn tại không
                if (!isset($detail['quantity'])) {
                    // Gán giá trị mặc định nếu không có quantity
                    $detail['quantity'] = 1; // Hoặc một giá trị mặc định khác
                }

                // Lấy tên thuốc từ chi tiết
                $medicineCode = $detail['medicine_code'];

                // Kiểm tra thuốc đã tồn tại
                $existingMedicine = Medicine::where('medicine_code', $medicineCode)->first();

                // Xử lý hình ảnh nếu có
                if (isset($detail['image']) && $detail['image']) {
                    $image = $detail['image'];
                    $imagePath = $image->store('medicine', 'public'); // Lưu vào thư mục public/storage/medicine
                    $detail['image'] = $imagePath; // Gán đường dẫn hình ảnh vào trường detail
                } else {
                    $detail['image'] = null; // Nếu không có hình ảnh, gán null
                }

                if ($existingMedicine) {
                    // Nếu thuốc đã tồn tại
                    $medicineId = $existingMedicine->id;
                    $detail['name'] = $existingMedicine->name . ' ' . now()->format('d/m/Y');
                } else {
                    // Nếu thuốc chưa tồn tại, kiểm tra giá nhập
                    $priceImport = $detail['price_import'] ?? 0; // Giá nhập từ chi tiết
                    if ($priceImport <= 0) {
                        throw new \Exception('Giá nhập không hợp lệ.');
                    }
                    // Tạo thuốc mới
                    $newMedicine = Medicine::query()->create($detail);
                    $medicineId = $newMedicine->id; // Lưu ID thuốc mới
                    $newMedicine->suppliers()->attach($request->supplier_id); // Gắn nhà cung cấp cho thuốc mới

                    // Lưu đơn vị và tỷ lệ chuyển đổi cho thuốc
                    foreach ($detail['units'] as $unit) {
                        UnitConversion::create([
                            'medicine_id' => $medicineId,
                            'unit_id' => $unit['unit'],
                            'proportion' => $unit['quantity']
                        ]);
                    }
                }

                // Tính số lượng tổng theo đơn vị bé nhất
                $conversion = UnitConversion::where('medicine_id', $medicineId)
                    ->where('unit_id', $detail['unit_id'])
                    ->first();

                if ($conversion) {
                    $smallestUnitQuantity = $detail['quantity'] * $conversion->proportion;
                } else {
                    throw new \Exception('Không tìm thấy tỷ lệ chuyển đổi cho thuốc này.');
                }

                // Lưu thông tin vào bảng Inventory
                Inventory::create([
                    'storage_id' => $request->storage_id,
                    'medicine_id' => $medicineId,
                    'unit_id' => $detail['unit_id'],
                    'quantity' => $smallestUnitQuantity // Lưu số lượng theo đơn vị nhỏ nhất
                ]);

                // Tạo chi tiết đơn nhập kho
                ImportOrderDetail::query()->create([
                    'import_order_id' => $importOrder->id,
                    'unit_id' => $detail['unit_id'],
                    'medicine_id' => $medicineId, // Lưu ID thuốc
                    'date_added' => $detail['date_added'],
                    'quantity' => $detail['quantity'],
                    'import_price' => $detail['price_import'], // Lưu giá nhập vào bảng ImportOrderDetail
                    'total' => $detail['total'],
                    'medication_name' => isset($newMedicine) ? $newMedicine->name : $existingMedicine->name, // Lưu tên thuốc
                    'expiration_date' => $detail['expiration_date'],
                ]);
            }

            DB::commit();
            return redirect()->route('admin.importorder.index')->with('success', 'Đơn nhập kho đã được tạo thành công!');
        } catch (\Exception $e) {
            Log::error("Lỗi nhập kho: " . $e->getMessage());
            DB::rollback();
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
    public function destroy($id)
    {
        // Tìm kiếm bản ghi theo ID
        $importOrder = ImportOrder::find($id);

        if ($importOrder) {
            // Xóa tất cả các chi tiết liên quan trước
            DB::table('import_order_details')->where('import_order_id', $id)->delete();

            // Xóa bản ghi chính
            $importOrder->delete();

            // Đưa người dùng trở lại trang danh sách với thông báo thành công
            return redirect()->route('admin.importorder.index')->with('success', 'Đơn hàng đã được xóa thành công.');
        }

        // Nếu không tìm thấy bản ghi, quay lại với thông báo lỗi
        return redirect()->route('admin.importorder.index')->with('error', 'Đơn hàng không tồn tại.');
    }
}
