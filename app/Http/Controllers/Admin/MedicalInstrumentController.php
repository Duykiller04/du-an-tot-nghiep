<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
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
use Illuminate\Support\Str;

class MedicalInstrumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Medicine::query()
                ->with(['suppliers', 'category', 'storage', 'inventory'])
                ->where('type_product', 1);

            // Lọc theo ngày tháng nếu có
            if (request()->has('startDate') && request()->has('endDate')) {
                $startDate = request()->get('startDate');
                $endDate = request()->get('endDate');

                // Kiểm tra định dạng ngày và lọc
                if ($startDate && $endDate) {
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
                ->addColumn('storage_location', function ($row) {
                    return $row->storage->location ?? '';  // Lấy vị trí từ bảng storage
                })
                ->addColumn('inventory_stock', function ($row) {
                    return $row->inventory->stock ?? '';  // Lấy số lượng từ bảng inventory
                })
                ->addColumn('expiration_date', function ($row) {
                    return $row->expiration_date ? $row->expiration_date->format('d/m/Y') : '';
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
                    $url = \Illuminate\Support\Facades\Storage::url($row->image);
                    return '<img src="' . asset($url) . '" alt="image" width="50" height="50">';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.medicalInstruments.edit', $row->id);
                    $deleteUrl = route('admin.medicalInstruments.destroy', $row->id);

                    return '
                        <a href="' . $editUrl . '" class="btn btn btn-warning">Sửa</a>
                        <form action="' . $deleteUrl . '" method="post" style="display:inline;" class="delete-form">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="button" class="btn btn-danger btn-delete" data-id="' . $row->id . '">Xóa</button>
                        </form>
                    ';
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        return view('admin.medicalInstrument.index');
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
        return view('admin.medicalInstrument.create', compact('categories','storages','donvis','suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     // dd($request->all());

    //     $priceImport = $request->input('medicine.price_import');
    //     $priceSale = $request->input('medicine.price_sale');

    //     if ($priceSale < $priceImport) {
    //         return redirect()->back()->withErrors([
    //             'medicine.price_sale' => 'Giá bán không thể nhỏ hơn giá nhập'
    //         ])->withInput();
    //     }

    //     try {
    //         DB::beginTransaction();

    //         if ($request->hasFile('image')) {
    //             $image = $request->file('image');
    //             $imagePath = $image->store('medicalInstruments', 'public');
    //         } else {
    //             $imagePath = null;
    //         }

    //         $medicineData = $request->input('medicine');

    //         $medicineData['type_product'] = 1;

    //         $medicineData['image'] = $imagePath;

    //         $inventories = [];
    //         $units = $request->don_vi;
    //         $quantityByUnit = array_slice($request->so_luong, 0);

    //         $medicine = Medicine::create($medicineData);

    //         $inventories['medicine_id'] = $medicine->id;

    //         $inventories['storage_id'] = $request->storage_id;

    //         $inventories['quantity'] = array_product($request->so_luong);

    //         $inventories['unit_id'] = end($units);

    //         Inventory::create($inventories);

    //         foreach ($units as $id => $unit_id_2) {
    //             if ($unit_id_2 != $inventories['unit_id']) {

    //                 UnitConversion::create([
    //                     'medicine_id' => $inventories['medicine_id'],
    //                     'unit_id_1' => $inventories['unit_id'],
    //                     'unit_id_2' => $unit_id_2,
    //                     'proportion' => $inventories['quantity'] / $quantityByUnit[$id]
    //                 ]);
    //             }
    //         }

    //         $medicine->suppliers()->attach($request->supplier_id);

    //         DB::commit();
    //         return redirect()->route('admin.medicalInstruments.index')->with('success', 'Thêm thành công');
    //     } catch (\Exception $exception) {
    //         DB::rollback();
    //         return back()->with('error' . $exception->getMessage());
    //     }
    // }
    public function store(StoreProductRequest $request)
    {
        // dd($request->all());

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

            $medicineData['storage_id'] = $request->storage_id;

            $inventories = [];

            $units = $request->don_vi;
            $quantities = $request->so_luong;

            $quantityByUnit = array_slice($request->so_luong, 0);


            $medicine = Medicine::create($medicineData);

            $inventories['medicine_id'] = $medicine->id;

            $inventories['storage_id'] = $request->storage_id;

            $inventories['quantity'] = array_product($request->so_luong); //Số lượng tổng theo đơn vị bé nhất

            $inventories['unit_id'] = end($units); // ID đơn vị bé nhất

            Inventory::create($inventories);

            foreach ($units as $i => $unit){
                UnitConversion::create([
                    'medicine_id' => $inventories['medicine_id'],
                    'unit_id' => $unit,
                    'proportion' => $quantities[$i]
                ]);
            }

            $medicine->suppliers()->attach($request->supplier_id);

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $medicine = Medicine::findOrFail($id);//trả về 404
        return view('admin.medicine.edit',compact('medicine'));
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
    public function destroy(Medicine $medicalInstrument)
    {
       $medicalInstrument->delete();
       return back()->with('success', 'Xóa dụng cụ thành công');
    }
    public function getRestore()
    {
        $data = Medicine::onlyTrashed()->where('type_product', 1)->get();
        return view('admin.medicine.restore', compact('data'));
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
