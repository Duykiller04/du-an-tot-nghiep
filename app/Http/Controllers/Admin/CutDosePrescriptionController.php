<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCutDosePrescriptionRequest;
use App\Models\CutDosePrescription;
use App\Models\CutDosePrescriptionDetail;
use App\Models\Disease;
use App\Models\Inventory;
use App\Models\Medicine;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CutDosePrescriptionController extends Controller
{
    const PATH_VIEW = 'admin.cutdoseprescription.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = CutDosePrescription::query()->with('disease')->latest('id')->paginate(5);

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
    public function store(StoreCutDosePrescriptionRequest $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $total = 0;
            //duyetừng thuốc
            foreach ($request->medicines as $medicine) {
                $subTotal = $medicine['quantity'] * $medicine['current_price'];
                $total += $subTotal;
            }
            $cutDosePrescription = CutDosePrescription::query()->create([
                'disease_id' => $request->disease_id,
                'name_hospital' => $request->name_hospital,
                'name_doctor' => $request->name_doctor,
                'age' => $request->age,
                'phone_doctor' => $request->phone_doctor,
                'total' => $total,
            ]);
            foreach ($request->medicines as $medicine) {
                CutDosePrescriptionDetail::query()->create([
                    'medicine_id' => $medicine['medicine_id'],
                    'cut_dose_prescription_id' => $cutDosePrescription->id,
                    'unit_id' => $medicine['unit_id'],
                    'quantity' => $medicine['quantity'],
                    'current_price' => $medicine['current_price'],
                    'dosage' => $medicine['dosage'],
                ]);
            }
            DB::commit();
            return redirect()->route('admin.cutDosePrescriptions.index')
                ->with('success', 'Thêm đơn thuốc thành công');
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
            Log::error('Lỗi thêm đơn thuốc ' . $exception->getMessage());
            return back()->with('error', 'Lỗi thêm đơn thuốc');
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
