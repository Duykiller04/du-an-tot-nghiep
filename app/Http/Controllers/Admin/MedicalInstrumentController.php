<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Batch;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Medicine;
use App\Models\Storage;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\UnitConversion;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MedicalInstrumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Medicine::query()
                ->with(['category'])
                ->where('type_product', 1)
                ->latest('id');

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
                ->addIndexColumn()
                ->addColumn('category_name', function ($row) {
                    return $row->category->name ?? '';  // Lấy tên từ bảng category
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d/m/Y') : '';
                })
                ->addColumn('price_import', function ($row) {
                    return number_format($row->price_import) . ' VND';  // Format price
                })
                ->addColumn('price_sale', function ($row) {
                    return number_format($row->price_sale) . ' VND';  // Format price
                })
                ->addColumn('image', function ($row) {
                    if ($row->image) {
                        $url = \Illuminate\Support\Facades\Storage::url($row->image);
                        return '<a data-fancybox data-src="' . asset($url) . '" data-caption="Ảnh thuốc" ><img src="' . asset($url) . '" width="200" height="150" alt="" /></a>';
                    } else {
                        $defaultImage = asset('theme/admin/assets/images/no-img-avatar.png');
                        return '<img src="' . $defaultImage . '" width="200" height="150" alt="" />';
                    }
                })
                ->addColumn('action', function ($row) {
                    $viewUrl = route('admin.medicalInstruments.show', $row->id);
                    $editUrl = route('admin.medicalInstruments.edit', $row->id);
                    $deleteUrl = route('admin.medicalInstruments.destroy', $row->id);

                    return '
                <a href="' . $viewUrl . '" class="btn btn-info">Xem</a>
                <a href="' . $editUrl . '" class="btn btn-warning">Sửa</a>
                <form action="' . $deleteUrl . '" method="post" style="display:inline;" class="delete-form">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button type="button" class="btn btn-danger btn-delete" data-id="' . $row->id . '">Xóa</button>
                </form>
            ';
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        $medicines = Medicine::with(['category'])->where('type_product', 1)->latest('id')->get();
        return view('admin.medicalInstrument.index', compact('medicines'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $donvis = Unit::query()->get();
        $categories = Category::query()->get();
        $storages = Storage::query()->get();
        $suppliers = Supplier::query()->get();
        return view('admin.medicalInstrument.create', compact('categories', 'storages', 'donvis', 'suppliers'));
    }

    public function store(StoreProductRequest $request)
    {
        $priceImport = $request->input('medicine.price_import');
        $priceSale = $request->input('medicine.price_sale');

        if ($priceSale < $priceImport) {
            return redirect()->back()->withErrors([
                'medicine.price_sale' => 'Giá bán không thể nhỏ hơn giá nhập'
            ])->withInput();
        }

        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('medicalInstruments', 'public');
            } else {
                $imagePath = null;
            }

            $medicineData = $request->input('medicine');

            $medicineData['type_product'] = 1;

            $medicineData['image'] = $imagePath;

            $batchData = $request->input('batch');

            $batchData['storage_id'] = $request->storage_id;

            $batchData['supplier_id'] = $request->supplier_id;

            $inventories = [];

            $units = $request->don_vi;
            $quantities = $request->so_luong;

            $total_quantity = 1;

            foreach ($units as $i => $unit) {
                $total_quantity *= $quantities[$i];
            }
            
            $price_in_smallest_unit = $request->batch['price_sale'] / $total_quantity;

            $batchData['price_in_smallest_unit'] = $price_in_smallest_unit;

            $medicine = Medicine::create($medicineData);

            $batchData['medicine_id'] = $medicine->id;

            $batchData['supplier_id'] = $request->supplier_id;

            
            $batch = Batch::create($batchData);
            
            // dd($batch->id);
            $inventories['batch_id'] = $batch->id;

            $inventories['storage_id'] = $request->storage_id;

            $inventories['quantity'] = array_product($request->so_luong); //Số lượng tổng theo đơn vị bé nhất

            $inventories['unit_id'] = end($units); // ID đơn vị bé nhất

            Inventory::create($inventories);

            foreach ($units as $i => $unit) {
                UnitConversion::create([
                    'medicine_id' => $medicine->id,
                    'unit_id' => $unit,
                    'proportion' => $quantities[$i]
                ]);
            }

            // $batch->supplier()->attach($request->supplier_id);

            DB::commit();
            return redirect()->route('admin.medicalInstruments.index')->with('success', 'Thêm thành công');
        } catch (\Exception $exception) {
            DB::rollback();
            dd($exception->getMessage());
            return back()->with('error' . $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $medicine = Medicine::with(['batches.supplier','batches.storage','category', 'batches.inventory.unit'])->findOrFail($id);
        return view('admin.medicalInstrument.show', compact('medicine'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $medicine = Medicine::with(['category', 'unitConversions.unit'])->findOrFail($id);
        $packaging_specification = Batch::where('medicine_id', $id)->pluck('packaging_specification')->first();
        $categories = Category::all();
        $storages = Storage::all();
        $suppliers = Supplier::all();
        $donvis = Unit::all();
        return view('admin.medicalInstrument.edit', compact('medicine', 'categories', 'storages', 'suppliers', 'donvis', 'packaging_specification'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $medicine = Medicine::findOrFail($id);

        try {
            DB::beginTransaction();

            // Kiểm tra và cập nhật hình ảnh nếu có
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('medicalInstruments', 'public');
                $medicine->image = $imagePath;
            }

            // Cập nhật thông tin thuốc
            $medicineData = $request->medicine;
            $medicine->update($medicineData);

            DB::commit();

            return redirect()->route('admin.medicalInstruments.index')->with('success', 'Cập nhật thành công');
        } catch (\Exception $exception) {
            DB::rollback();
            dd($exception->getMessage());
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medicine $medicalInstrument)
    {
        $medicalInstrument->delete();
        return back()->with('success', 'Xóa dụng cụ thành công');
    }
    public function getRestore()
    {
        $data = Medicine::onlyTrashed()->where('type_product', 1)->orderBy('deleted_at', 'desc')->get();
        return view('admin.medicalInstrument.restore', compact('data'));
    }
    public function restore(Request $request)
    {
        // dd($request->all());
        try {
            $medicalInstrumentIds = $request->input('ids');
            if ($medicalInstrumentIds) {
                Medicine::onlyTrashed()->whereIn('id', $medicalInstrumentIds)->restore();
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
