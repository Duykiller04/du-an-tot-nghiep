<?php

namespace App\Http\Controllers\Admin;

use App\Events\RevenueUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCutDosePrescriptionRequest;
use App\Http\Requests\UpdateCutDosePresciptionRequest;
use App\Models\Batch;
use App\Models\CutDosePrescription;
use App\Models\CutDosePrescriptionDetail;
use App\Models\Disease;
use App\Models\Inventory;
use App\Models\Medicine;
use App\Models\Shift;
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
        $batchs = Batch::query()->pluck('created_at', 'id');

        return view(self::PATH_VIEW . __FUNCTION__, compact('medicines', 'diseases','batchs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCutDosePrescriptionRequest $request)
    {
        try {
            DB::beginTransaction();
            $total = 0;
            //duyệt từng thuốc
            foreach ($request->medicines as $medicine) {
                $subTotal = $medicine['quantity'] * $medicine['current_price'];
                $total += $subTotal;
            }
            $cutDosePrescription = CutDosePrescription::query()->create([
                'name' =>  $request->name,
                'description' =>  $request->description,
                'disease_id' => $request->disease_id,
                'name_hospital' => $request->name_hospital,
                'name_doctor' => $request->name_doctor,
                'age' => $request->age,
                'phone_doctor' => $request->phone_doctor,
                'total' => $total,
            ]);
            foreach ($request->medicines as $medicine) {
                $inventory = Inventory::where('batch_id', $medicine['batch_id'])->first();
                $unit_id = $inventory->unit_id;
                CutDosePrescriptionDetail::query()->create([
                    'medicine_id' => $medicine['medicine_id'],
                    'cut_dose_prescription_id' => $cutDosePrescription->id,
                    'unit_id' => $unit_id,
                    'batch_id' => $medicine['batch_id'],
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
            Log::error('Lỗi thêm đơn thuốc ' . $exception->getMessage());
            return back()->with('error', 'Lỗi thêm đơn thuốc');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CutDosePrescription $cutDosePrescription)
    {
        $diseases = Disease::query()->pluck('disease_name', 'id');
        $medicines = Medicine::query()->pluck('name', 'id');
        $units = Unit::query()->pluck('name', 'id');
        $batchs = Batch::query()->pluck('created_at', 'id');

        return view(self::PATH_VIEW . __FUNCTION__, compact('cutDosePrescription', 'diseases', 'medicines', 'units','batchs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CutDosePrescription $cutDosePrescription)
    {
        $diseases = Disease::query()->pluck('disease_name', 'id');
        $medicines = Medicine::query()->pluck('name', 'id');
        $batchs = Batch::query()->pluck('created_at', 'id');

        return view(self::PATH_VIEW . __FUNCTION__, compact('cutDosePrescription', 'diseases', 'medicines', 'batchs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCutDosePresciptionRequest $request, CutDosePrescription $cutDosePrescription)
    {
        try {
            DB::beginTransaction();
            $data = $request->except('medicines');
            $cutDosePrescription->update($data);
            foreach ($request->medicines as $item) {
                if (!isset($item['medicine_id'])) {
                    // Bỏ qua item nếu không có medicine_id
                    continue;
                }
                if (isset($item['id'])) {
                    $detail = CutDosePrescriptionDetail::find($item['id']);
                    if ($detail) {
                        $inventory = Inventory::where('batch_id', $item['batch_id'])->first();
                        $unit_id = $inventory->unit_id;
                        $detail->update([
                            'medicine_id' => $item['medicine_id'],
                            'unit_id' => $unit_id,
                            'batch_id' => $item['batch_id'],
                            'quantity' => $item['quantity'],
                            'current_price' => $item['current_price'],
                            'dosage' => $item['dosage'],
                        ]);
                    }
                } else {
                    $inventory = Inventory::where('batch_id', $item['batch_id'])->first();
                    $unit_id = $inventory->unit_id;
                    $detail = $cutDosePrescription->cutDosePrescriptionDetails()->create([
                        'medicine_id' => $item['medicine_id'],
                        'unit_id' => $unit_id,
                        'batch_id' => $item['batch_id'],
                        'quantity' => $item['quantity'],
                        'current_price' => $item['current_price'],
                        'dosage' => $item['dosage'],
                    ]);
                }
            }
            if ($request->has('delete_medicines')) {
                foreach ($request->delete_medicines as $cutDoseDetailId) {
                    $cutDoseDetail = CutDosePrescriptionDetail::find($cutDoseDetailId);
                    $cutDoseDetail->delete();
                }
            }
            DB::commit();
            return back()->with('success', 'Cập nhật đơn thuốc mẫu thành công');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Lỗi cập nhật đơn thuốc ' . $exception->getMessage());
            return back()->with('error', 'Lỗi cập nhật đơn thuốc ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CutDosePrescription $cutDosePrescription)
    {
        $cutDosePrescription->delete();
        return back()->with('success', 'Xóa đơn thuôc mẫu thành công');
    }


    public function getRestore()
    {
        $data = CutDosePrescription::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(5);
        return view('admin.cutDosePrescription.restore', compact('data'));
    }
    public function restore(Request $request)
    {
        // dd($request->all());
        try {
            $cutDosePrescriptionsIds = $request->input('ids');
            if ($cutDosePrescriptionsIds) {
                CutDosePrescription::onlyTrashed()->whereIn('id', $cutDosePrescriptionsIds)->restore();
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
