<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryAudit;
use App\Models\InventoryCheckDetail;
use App\Models\Medicine;
use App\Models\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InventoryAuditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $storages = Storage::all();

        // Truy vấn phiếu kiểm kho
        $query = InventoryAudit::query();

        // Lọc theo ngày kiểm kho
        if ($request->has('date') && !empty($request->date)) {
            $dateRange = explode('to', $request->date);
            $startDate = \Carbon\Carbon::createFromFormat('d-m-Y', trim($dateRange[0]))->startOfDay();
            $endDate = \Carbon\Carbon::createFromFormat('d-m-Y', trim($dateRange[1]))->endOfDay();
            $query->whereBetween('check_date', [$startDate, $endDate]);
        }

        // Lọc theo kho lưu trữ
        if ($request->has('storage_id') && $request->storage_id !== 'all') {
            $query->where('storage_id', $request->storage_id);
        }

        // Lấy danh sách phiếu kiểm kho với các điều kiện lọc
        $inventoryAudits = $query->with('storage')->get();

        // Trả về view với dữ liệu
        return view('admin.inventoryAudit.index', compact('inventoryAudits', 'storages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $storages = Storage::all();
        $medicines = Medicine::all();

        return view('admin.inventoryAudit.add', compact('storages', 'medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'storage_id' => 'required|exists:storages,id',
            'check_date' => 'required|date',
            'check_by' => 'required|string|max:255',
            'remarks' => 'nullable|string',
            'details.*.medicine_id' => 'required|exists:medicines,id',
            'details.*.expected_quantity' => 'required|integer|min:0',
            'details.*.actual_quantity' => 'required|integer|min:0',
            'details.*.difference' => 'required|integer|min:0',
            'details.*.remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            // Tạo phiếu kiểm kho
            $inventoryAudit = InventoryAudit::create([
                'title' => $request->input('title'),
                'storage_id' => $request->input('storage_id'),
                'check_date' => $request->input('check_date'),
                'checked_by' => $request->input('check_by'),
                'remarks' => $request->input('remarks'),
                'status' => 1
            ]);

            // Tạo chi tiết phiếu kiểm kho
            foreach ($request->input('details') as $detail) {
                InventoryCheckDetail::create([
                    'inventory_audit_id' => $inventoryAudit->id,
                    'medicine_id' => $detail['medicine_id'],
                    'expected_quantity' => $detail['expected_quantity'],
                    'actual_quantity' => $detail['actual_quantity'],
                    'difference' => $detail['difference'],
                    'remarks' => $detail['remarks'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.inventoryaudit.index')->with('success', 'Phiếu kiểm kho đã được tạo thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại.')->withInput();
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Tìm phiếu kiểm theo ID
        $inventoryAudit = InventoryAudit::findOrFail($id);
        
        // Lấy tất cả các chi tiết kiểm tra liên quan đến phiếu kiểm
        $auditDetails = $inventoryAudit->details()->with('medicine')->get(); // 'details' là quan hệ đã định nghĩa trong model InventoryAudit
        //dd($auditDetails->all());
        // Tính toán tổng số lượng dự kiến và thực tế
        $totalExpectedQuantity = $auditDetails->sum('expected_quantity');
        $totalActualQuantity = $auditDetails->sum('actual_quantity');

        // Trả về view với dữ liệu
        return view('admin.inventoryAudit.show', [
            'inventoryAudit' => $inventoryAudit,
            'auditDetails' => $auditDetails,
            'totalExpectedQuantity' => $totalExpectedQuantity,
            'totalActualQuantity' => $totalActualQuantity,
        ]);
    }

   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    { 
        $inventoryAudit = InventoryAudit::findOrFail($id);

        DB::transaction(function () use ($inventoryAudit) {
            // Xóa tất cả các chi tiết liên quan
            $inventoryAudit->details()->delete();
            // Xóa phiếu kiểm kho
            $inventoryAudit->delete();
        });

        return redirect()->route('admin.inventoryaudit.index')->with('success', 'Phiếu kiểm kho đã được xóa thành công.');
    }
}
