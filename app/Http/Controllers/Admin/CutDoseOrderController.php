<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CutDoseOrder;
use App\Models\Disease;
use App\Models\Medicine;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
    public function store(Request $request)
    {
        dd($request->toArray());
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
