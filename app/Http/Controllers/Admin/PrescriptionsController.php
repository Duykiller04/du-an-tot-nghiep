<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrescriptionRequest;
use App\Http\Requests\UpdatePrescriptionRequest;
use App\Models\CutDosePrescription;
use App\Models\Disease;
use App\Models\ImportOrder;
use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\PrescriptionDetail;
use App\Models\Unit;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
                        <a href="' . route('admin.prescriptions.show', $row->id) . '" class="btn btn-info">Xem</a>
                        <a href="' . route('admin.prescriptions.edit', $row->id) . '" class="btn btn-warning">Sửa</a>
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
     * Store a newly created resource in Prescription.
     */
    public function store(PrescriptionRequest $request)
    {
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
        $prescription = Prescription::with('prescriptionDetails.medicine', 'prescriptionDetails.unit')->findOrFail($id);

        // dd($prescription);
        
        $cutDosePrescription = CutDosePrescription::all(); // Lấy danh sách đơn thuốc mẫu
        $medicines = Medicine::all()->pluck('name', 'id'); // Lấy danh sách thuốc
        $units = Unit::all()->pluck('name', 'id'); // Lấy danh sách đơn vị
        return view(self::PATH_VIEW . __FUNCTION__, compact('prescription', 'cutDosePrescription', 'medicines', 'units'));
    }

    /**
     * Update the specified resource in Prescription.
     */
    public function update(UpdatePrescriptionRequest $request, string $id)
    {
        // dd($request->all());
        DB::beginTransaction();

        try {
            $prescription = Prescription::findOrFail($id);
            $prescription->update([
                'age' => $request->age,
                'type_sell' => $request->type_sell,
                'name_customer' => $request->customer_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'email' => $request->email,
                'weight' => $request->weight,
                'gender' => $request->gender,
                'status' => $request->has('status') ? 1 : 0,
            ]);

            DB::commit();
            return redirect()->route('admin.prescriptions.index')->with('success', 'Cập nhật thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from Prescription.
     */
    public function destroy(Prescription $prescription)
    {
        $prescription->delete();
        return back()->with('success', 'Xóa thuốc thành công.');
    }

    public function getRestore()
    {
        $data = Prescription::onlyTrashed()->get();
        return view('admin.Prescription.restore', compact('data'));
    }
    public function restore(Request $request)
    {
        try {
            $PrescriptionIds = $request->input('ids');
            if ($PrescriptionIds) {
                Prescription::onlyTrashed()->whereIn('id', $PrescriptionIds)->restore();
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
