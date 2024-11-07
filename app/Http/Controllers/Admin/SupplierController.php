<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class SupplierController extends Controller
{
    const PATH_VIEW = 'admin.suppliers.';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Supplier::query();
            // Lọc theo ngày tháng nếu có
            if (request()->has('startDate') && request()->has('endDate')) {
                $startDate = request()->get('startDate');
                $endDate = request()->get('endDate');

                // Kiểm tra định dạng ngày và lọc
                if ($startDate && $endDate) {
                    // Convert to datetime to include the full day
                    $startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
                    $endDate = \Carbon\Carbon::parse($endDate)->endOfDay();

                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }
            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    $viewUrl = route('admin.suppliers.show', $row->id);
                    $editUrl = route('admin.suppliers.edit', $row->id);
                    $deleteUrl = route('admin.suppliers.destroy', $row->id);

                    return '
                <a href="' . $viewUrl . '" class="btn btn btn-primary">Xem</a>
                <button class="btn btn-warning edit-btn" data-id="' . $row->id . '"  data-tax_code="' . $row->tax_code . '"   data-name="' . $row->name . '" data-email="' . $row->email . '" data-phone="' . $row->phone . '" data-address="' . $row->address . '">Sửa</button>
                <form action="' . $deleteUrl  . '" method="post" style="display:inline;">
                ' . csrf_field() . method_field('DELETE') . '
                <button type="submit" class="btn btn btn-danger" onclick="return confirm(\'Bạn có chắc chắn muốn xóa?\')">Xóa</button>
                </form>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        try {
            Supplier::query()->create($request->all());
            return redirect()->route('admin.suppliers.index')->with('success', 'Thành công');
        } catch (\Exception $exception) {
            return back()->with('error' . $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        try {
            $supplier->update([
                'tax_code'   => $request->tax_code_edit,
                'name'   => $request->name_edit,
                'email'  => $request->email_edit,
                'phone'   => $request->phone_edit,
                'address' => $request->address_edit,
            ]);
            return back()->with('success', 'Thành công');
        } catch (\Exception $exception) {
            return back()->with('error' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return back()->with('success', 'Thành công');
    }
    public function getRestore()
    {
        $data = Supplier::onlyTrashed()->get();
        return view('admin.suppliers.restore', compact('data'));
    }
    public function restore(Request $request)
    {
        // dd($request->all());
        try {
            $supplierIds = $request->input('ids');
            if ($supplierIds) {
                Supplier::onlyTrashed()->whereIn('id', $supplierIds)->restore();
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
