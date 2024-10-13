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
        ],[
            'title.required' => 'Tiêu đề là bắt buộc.',
            'title.string' => 'Tiêu đề phải là chuỗi ký tự.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            
            'storage_id.required' => 'Kho là bắt buộc.',
            'storage_id.exists' => 'Kho không hợp lệ.',
            
            'check_date.required' => 'Ngày kiểm tra là bắt buộc.',
            'check_date.date' => 'Ngày kiểm tra không hợp lệ (phải là ngày).',
            
            'check_by.required' => 'Người kiểm tra là bắt buộc.',
            'check_by.string' => 'Người kiểm tra phải là chuỗi ký tự.',
            'check_by.max' => 'Người kiểm tra không được vượt quá 255 ký tự.',
            
            'remarks.string' => 'Ghi chú phải là chuỗi ký tự.',
            
            'details.*.medicine_id.required' => 'Mã thuốc là bắt buộc.',
            'details.*.medicine_id.exists' => 'Mã thuốc không hợp lệ.',
            
            'details.*.expected_quantity.required' => 'Số lượng dự kiến là bắt buộc.',
            'details.*.expected_quantity.integer' => 'Số lượng dự kiến phải là số nguyên.',
            'details.*.expected_quantity.min' => 'Số lượng dự kiến phải lớn hơn hoặc bằng 0.',
            
            'details.*.actual_quantity.required' => 'Số lượng thực tế là bắt buộc.',
            'details.*.actual_quantity.integer' => 'Số lượng thực tế phải là số nguyên.',
            'details.*.actual_quantity.min' => 'Số lượng thực tế phải lớn hơn hoặc bằng 0.',
            
            'details.*.difference.required' => 'Chênh lệch là bắt buộc.',
            'details.*.difference.integer' => 'Chênh lệch phải là số nguyên.',
            'details.*.difference.min' => 'Chênh lệch phải lớn hơn hoặc bằng 0.',
            
            'details.*.remarks.string' => 'Ghi chú phải là chuỗi ký tự.',
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
