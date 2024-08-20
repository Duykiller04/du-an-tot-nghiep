<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UnitController extends Controller
{
    const PATH_VIEW = 'admin.units.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Unit::query()->with(['children.parent'])->latest('id')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentUnits = Unit::query()->with(['children'])->whereNull('parent_id')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('parentUnits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnitRequest $request)
    {
        try {
            Unit::query()->create($request->all());
            return redirect()->route('admin.units.index')->with('success', 'Thêm đơn vị thành công');
        } catch (\Exception $exception) {
            Log::error('Lỗi thêm đơn vị ' . $exception->getMessage());
            return back()->with('error', 'Lỗi thêm đơn vị');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        $parentUnits = Unit::query()->with(['children'])->whereNull('parent_id')->get();
        return view(self::PATH_VIEW . __FUNCTION__, compact('parentUnits','unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitRequest $request, Unit $unit)
    {
        try {
            $unit->update($request->all());
            return back()->with('success', 'Cập nhật đơn vị thành công');
        } catch (\Exception $e) {
            Log::error('Lỗi cập nhật danh mục sản phẩm ' . $e->getMessage());
            return back()->with('error', 'Lỗi cập nhật đơn vị thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        try {
            $unit->delete();
            return back()->with('success', 'Xóa đơn vị thành công');
        } catch (\Exception $e) {
            Log::error('Lỗi xóa danh mục sản phẩm ' . $e->getMessage());
            return back()->with('error', 'Lỗi xóa đơn vị');
        }

    }
}
