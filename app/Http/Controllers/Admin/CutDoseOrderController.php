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

class CutDoseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH_VIEW = 'admin.cutdoseorder.';
    public function index()
    {
        $data = CutDoseOrder::query()->with('disease')->latest('id')->paginate(5);

        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
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
                    'customer_name' => $request->input('customer_name'),
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

            // Trả về view lỗi
            return back()->with('error' . $e->getMessage());
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
}
