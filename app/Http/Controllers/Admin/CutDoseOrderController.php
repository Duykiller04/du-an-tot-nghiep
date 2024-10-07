<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CutDoseOrderRequest;
use App\Models\Customer;
use App\Models\CutDoseOrder;
use App\Models\CutDoseOrderDetails;
use App\Models\Disease;
use App\Models\Medicine;
use App\Models\Unit;
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
            $data = CutDoseOrder::with('cutDoseOrderDetails')->get();

            return DataTables::of($data)
                ->addColumn('gender', function ($row) {
                    return $row->gender == 0 ? 'Nam' : 'Nữ';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route('admin.cutDoseOrders.show', $row->id) . '" class="btn btn-info">Show</a>
                        <form action="' . route('admin.cutDoseOrders.destroy', $row->id) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>
                    ';
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
        return view(self::PATH_VIEW . __FUNCTION__, compact('medicines', 'units', 'diseases','unitsSelectMedicine'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CutDoseOrderRequest $request)
    {
        DB::beginTransaction();

        try {
            // Kiểm tra xem khách hàng đã tồn tại hay chưa
            $customer = Customer::where('email', $request->input('email'))
                                ->orWhere('phone', $request->input('phone'))
                                ->first();

            // Nếu khách hàng chưa tồn tại, tạo mới
            if (!$customer) {
                $customer = Customer::create([
                    'name' => $request->input('customer_name'),
                    'age' => $request->input('age'),
                    'phone' => $request->input('phone'),
                    'address' => $request->input('address'),
                    'weight' => $request->input('weight'),
                    'gender' => $request->input('gender'),
                    'email' => $request->input('email'),
                ]);
            }

            $customerId = $customer->id;

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
            ]);

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
        $cutDoseOrder = CutDoseOrder::with(['cutDoseOrderDetails.medicines', 'cutDoseOrderDetails.unit'])->findOrFail($id);

        return view(self::PATH_VIEW . __FUNCTION__, compact('cutDoseOrder'));
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
        //
    }

    public function getRestore()
    {
        $data = CutDoseOrder::onlyTrashed()->get();
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
