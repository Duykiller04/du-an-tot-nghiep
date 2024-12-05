<?php

namespace App\Http\Controllers\Admin;

use App\Events\RevenueUpdated;
use App\Events\TransactionCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\CutDoseOrderRequest;
use App\Http\Requests\UpdateCutDoseOrderRequest;
use App\Models\Customer;
use App\Models\CutDoseOrder;
use App\Models\CutDoseOrderDetails;
use App\Models\Disease;
use App\Models\Medicine;
use App\Models\Shift;
use App\Models\Unit;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class CutDoseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH_VIEW = 'admin.cutdoseorder.';
    public function index()
    {
        if (request()->ajax()) {
            $data = CutDoseOrder::with('cutDoseOrderDetails')->latest('id');

            if (request()->has('startDate') && request()->has('endDate')) {
                $startDate = request()->get('startDate');
                $endDate = request()->get('endDate');

                if ($startDate && $endDate) {
                    $startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
                    $endDate = \Carbon\Carbon::parse($endDate)->endOfDay();

                    $data->whereBetween('created_at', [$startDate, $endDate]);
                }
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('gender', function ($row) {
                    return $row->gender == 0 ? 'Nam' : 'Nữ';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d/m/Y') : '';
                })
                ->addColumn('action', function ($row) {
                    $deleteUrl = route('admin.cutDoseOrders.destroy', $row->id);
                    return '
                        <a href="' . route('admin.cutDoseOrders.show', $row->id) . '" class="btn btn-info">Xem</a>
                        <a href="' . route('admin.cutDoseOrders.edit', $row->id) . '" class="btn btn-warning">Sửa</a>
                        <form action="' . $deleteUrl . '" method="post" style="display:inline;" class="delete-form">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="button" class="btn btn-danger btn-delete" data-id="' . $row->id . '">Xóa</button>
                        </form>
                    ';
                })
                ->addColumn('total_price', function ($row) {
                    return number_format($row->total_price) . ' VND';  // Format price
                })
                ->make(true);
        }

        return view(self::PATH_VIEW . __FUNCTION__);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medicines = Medicine::query()->pluck('name', 'id');
        $diseases = Disease::query()->pluck('disease_name', 'id');
        $units = Unit::query()->pluck('name', 'id');

        //khởi tạo biến để lưu các đơn vị của thuốc
        $unitsSelectMedicine = [];

        // dd($medicines);
        return view(self::PATH_VIEW . __FUNCTION__, compact('medicines', 'units', 'diseases', 'unitsSelectMedicine'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CutDoseOrderRequest $request)
    {
        DB::beginTransaction();

        try {
            // Kiểm tra xem khách hàng đã tồn tại hay chưa
            $customer = Customer::where('phone', $request->input('phone'))->first();

            // Nếu khách hàng chưa tồn tại, tạo mới
            if (!$customer) {
                $customer = Customer::create([
                    'name' => $request->input('customer_name'),
                    'age' => $request->input('age'),
                    'phone' => $request->input('phone'),
                    'address' => $request->input('address'),
                    'weight' => $request->input('weight'),
                    'gender' => $request->input('gender'),
                    'email' => $request->input('email') ?? null,
                ]);
            }

            $customerId = $customer->id;
            $activeShift = Shift::where('status', 'đang mở')->first();
            $shiftId = $activeShift ? $activeShift->id : null;

            // Lưu thông tin đơn đặt hàng
            $cutDoseOrder = CutDoseOrder::create([
                'disease_id' => $request->input('disease_id'),  // Đảm bảo rằng trường này không phải là null
                'weight' => $request->input('weight'),
                'age' => $request->input('age'),
                'gender' => $request->input('gender'),
                'customer_id' => $customerId,
                'customer_name' => $request->input('customer_name'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'shift_id' => $shiftId,
                'total_price' => $request->input('total_price'),
                'seller' => Auth::user()->name,
            ]);
            // Cập nhật doanh thu cho ca làm việc
            if ($shiftId) {
                $shift = Shift::find($shiftId);
                $shift->revenue_summary += $request->input('total_price');
                $shift->save();
                broadcast(new RevenueUpdated($shiftId, $shift->revenue_summary))->toOthers();
                // event(new TransactionCreated($cutDoseOrder));
            }


            // Lưu thông tin chi tiết đơn đặt hàng
            foreach ($request->input('medicines') as $medicine) {
                CutDoseOrderDetails::create([
                    'cut_dose_order_id' => $cutDoseOrder->id,
                    'medicine_id' => $medicine['medicine_id'],
                    'unit_id' => $medicine['unit_id'],
                    'quantity' => $medicine['quantity'],
                    'dosage' => $medicine['dosage'],
                ]);
            }

            // Commit transaction
            DB::commit();

            // Trả về view thành công
            return redirect()->route('admin.cutDoseOrders.index')->with('success', 'Thêm thành công');
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            DB::rollBack();
            dd($e->getMessage());
            // Trả về view lỗi
            return back()->with('error' . $e->getMessage());
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cutDoseOrder = CutDoseOrder::with(['cutDoseOrderDetails.medicine', 'cutDoseOrderDetails.unit'])->findOrFail($id);

        return view(self::PATH_VIEW . __FUNCTION__, compact('cutDoseOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cutDoseOrder = CutDoseOrder::with('cutDoseOrderDetails.medicine', 'cutDoseOrderDetails.unit')->findOrFail($id);
        $medicines = Medicine::query()->pluck('name', 'id');
        $diseases = Disease::query()->pluck('disease_name', 'id');
        $units = Unit::query()->pluck('name', 'id');

        return view(self::PATH_VIEW . 'edit', compact('cutDoseOrder', 'medicines', 'units', 'diseases'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCutDoseOrderRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            // Tìm đơn thuốc theo ID
            $cutDoseOrder = CutDoseOrder::findOrFail($id);

            // Chỉ cho phép cập nhật các thông tin khách hàng
            $cutDoseOrder->customer_name = $request->input('customer_name');
            $cutDoseOrder->age = $request->input('age');
            $cutDoseOrder->phone = $request->input('phone');
            $cutDoseOrder->address = $request->input('address');
            $cutDoseOrder->weight = $request->input('weight');
            $cutDoseOrder->gender = $request->input('gender');

            $cutDoseOrder->status = $request->has('status') ? 1 : 0;

            // Lưu lại thông tin
            $cutDoseOrder->save();

            // Cập nhật thông tin chi tiết đơn thuốc
            $medicines = $request->input('medicines');

            // Kiểm tra nếu medicines không null và là một mảng
            if (is_array($medicines)) {
                foreach ($medicines as $medicine) {
                    // Nếu có ID của chi tiết đơn thuốc trong request
                    if (isset($medicine['id'])) {
                        $detail = CutDoseOrderDetails::findOrFail($medicine['id']);
                        // Không cập nhật các trường thuốc, đơn vị, số lượng, liều lượng
                        // Bạn có thể thêm logic nếu cần
                    }
                }
            }

            // Commit transaction
            DB::commit();

            return redirect()->route('admin.cutDoseOrders.index')->with('success', 'Cập nhật thành công');
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            DB::rollBack();
            return back()->with('error', 'Cập nhật không thành công: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            // Tìm đơn đặt hàng dựa trên ID
            $cutDoseOrder = CutDoseOrder::findOrFail($id);

            // Xóa mềm đơn đặt hàng
            $cutDoseOrder->delete();

            // Commit transaction
            DB::commit();

            // Trả về view thành công
            return redirect()->route('admin.cutDoseOrders.index')->with('success', 'Xóa thành công');
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function getRestore()
    {
        $data = CutDoseOrder::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('admin.cutdoseorder.restore', compact('data'));
    }
    public function restore(Request $request)
    {
        try {
            $cutDoseOrdersIds = $request->input('ids');
            if ($cutDoseOrdersIds) {
                CutDoseOrder::onlyTrashed()->whereIn('id', $cutDoseOrdersIds)->restore();
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
