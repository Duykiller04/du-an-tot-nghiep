<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CutDosePrescription;
use App\Models\Disease;
use App\Models\ImportOrder;
use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\PrescriptionDetail;
use App\Models\Unit;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PrescriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH_VIEW = 'admin.prescription.';
    public function index()
    {
        if (request()->ajax()) {
            $data = Prescription::with('prescriptionDetails')->get();
            return DataTables::of($data)
                ->addColumn('gender', function ($row) {
                    return $row->gender == 0 ? 'Nam' : 'Nữ'; // Chuyển đổi giới tính
                })
                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route('admin.prescriptions.show', $row->id) . '" class="btn btn-info">Show</a>
                        <form action="' . route('admin.prescriptions.destroy', $row->id) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger" onclick="return confirm(\'Bạn có muốn xóa không ?\')">Xóa</button>
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
        $cutDosePrescription = CutDosePrescription::query()->with(['disease', 'cutDosePrescriptionDetails'])->get();
        $medicines = Medicine::query()->pluck('name', 'id');
        $diseases = Disease::query()->pluck('disease_name', 'id');
        $units = Unit::query()->pluck('name', 'id');

        //khởi tạo biến để lưu các đơn vị của thuốc
        $unitsSelectMedicine = [];

        // dd($cutDosePrescription);
        return view(self::PATH_VIEW . __FUNCTION__, compact('medicines', 'units', 'diseases','unitsSelectMedicine', 'cutDosePrescription'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'customer_name' => 'required|string',
            'age' => 'required|integer',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'email' => 'nullable|email',
            'weight' => 'nullable|integer',
            'gender' => 'nullable|boolean',
            'type_sell' => 'required|string|in:Bán lẻ,Bán giá nhập,Trả lại nhà cung cấp,Xuất,Hủy',
            'medicines' => 'required|array',
            'medicines.*.medicine_id' => 'required|integer',
            'medicines.*.unit_id' => 'required|integer',
            'medicines.*.quantity' => 'required|numeric',
            'medicines.*.dosage' => 'required|string',
            'medicines.*.current_price' => 'required|numeric',
        ]);

        // Bắt đầu giao dịch
        DB::beginTransaction();

        try {
            // Tạo một bản ghi mới trong bảng prescriptions
            $prescription = Prescription::create([
                'total' => $request->total_price, // Chắc chắn rằng total_price được gửi lên
                'age' => $request->age,
                'type_sell' => $request->type_sell,
                'name_customer' => $request->customer_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'email' => $request->email,
                'weight' => $request->weight,
                'gender' => $request->gender,
            ]);

            // Tạo các bản ghi mới trong bảng prescription_details
            foreach ($request->medicines as $medicine) {
                PrescriptionDetail::create([
                    'medicine_id' => $medicine['medicine_id'],
                    'unit_id' => $medicine['unit_id'],
                    'prescription_id' => $prescription->id,
                    'quantity' => $medicine['quantity'],
                    'current_price' => $medicine['current_price'],
                    'dosage' => $medicine['dosage'],
                ]);
            }

            // Cam kết giao dịch
            DB::commit();

            // Redirect với thông báo thành công
            return redirect()->route('admin.prescriptions.index')->with('success', 'Thêm thành công');

        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            DB::rollBack();
            dd($e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prescription = Prescription::with(['prescriptionDetails.medicine', 'prescriptionDetails.unit'])->findOrFail($id);
    
        return view(self::PATH_VIEW . __FUNCTION__, compact('prescription'));
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
    public function destroy(Prescription $prescription)
    {
        $prescription->delete();
        return back()->with('success', 'Xóa thuốc thành công.');
    }

}
