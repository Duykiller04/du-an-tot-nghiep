<?php

namespace App\Http\Controllers\Admin;

use App\Events\RevenueUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePrescriptionRequest;
use App\Models\CutDosePrescription;
use App\Models\Disease;
use App\Models\Inventory;
use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\PrescriptionDetail;
use App\Models\Shift;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $data = Prescription::with('prescriptionDetails')->latest('id');

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
                    return $row->gender == 0 ? 'Nam' : 'Nữ'; // Chuyển đổi giới tính
                })
                ->addColumn('total_price', function ($row) {
                    return number_format($row->total_price) . ' VND';  // Format price
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d/m/Y') : '';
                })
                ->addColumn('action', function ($row) {
                    $deleteUrl = route('admin.prescriptions.destroy', $row->id);
                    return '
                        <a href="' . route('admin.prescriptions.show', $row->id) . '" class="btn btn-info">Xem</a>
                        <a href="' . route('admin.prescriptions.edit', $row->id) . '" class="btn btn-warning">Sửa</a>
                        
                        <form action="' . $deleteUrl . '" method="post" style="display:inline;" class="delete-form">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="button" class="btn btn-danger btn-delete" data-id="' . $row->id . '">Xóa</button>
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
        return view(self::PATH_VIEW . __FUNCTION__, compact('medicines', 'units', 'diseases', 'unitsSelectMedicine', 'cutDosePrescription'));
    }

    /**
     * Store a newly created resource in Prescription.
     */
    public function store(Request $request)
    {
        // Bắt đầu giao dịch
        DB::beginTransaction();

        try {
            // Tạo một bản ghi mới trong bảng prescriptions
            $activeShift = Shift::where('status', 'đang mở')->first();
            $shiftId = $activeShift ? $activeShift->id : null;

            $prescription = Prescription::create([
                'total_price' => $request->total_price,
                'customer_name' => $request->customer_name,
                'shift_id' => $shiftId,
                'seller' => Auth::user()->name,
                'note' => $request->note,
                'dosage' => $request->dosage
            ]);

            foreach ($request->unit_id as $key => $value) {
                PrescriptionDetail::create([
                    'batch_id' => $key,
                    'unit_id' => $value,
                    'prescription_id' => $prescription->id,
                    'quantity' => $request->quantity[$key],
                    'current_price' => $request->batch_total_price[$key],
                ]);
                
                $inventory = Inventory::where('batch_id', $key)->first();
                $inventory->update([
                    'quantity' => $inventory->quantity - $request->quantity[$key],
                ]);
            }

            if ($shiftId) {
                $shift = Shift::find($shiftId);

                $shift->revenue_summary += $request->total_price;
                $shift->save();
                broadcast(new RevenueUpdated($shiftId, $shift->revenue_summary))->toOthers();
                // event(new TransactionCreated($cutDoseOrder));
            }
            DB::commit();

            // Redirect với thông báo thành công
            return redirect()->route('admin.sell.index')->with('success', 'Tạo đơn thuốc thành công');

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
                'customer_name' => $request->customer_name,
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
        $data = Prescription::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
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
