<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Medicine;
use App\Models\Storage;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\UnitConversion;
use DB;
use Illuminate\Http\Request;

class MedicalInstrumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicalInstrument = Medicine::query()->with(['suppliers', 'category','storage', 'inventory'])->where('type_product' , 1)->latest('id')->get();
        // dd($medicines->toArray());
        return view('admin.medicalInstrument.index', compact('medicalInstrument'));
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
    public function store(Request $request)
    {
        // dd($request->all());

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

            $inventories = [];
            $units = $request->don_vi;
            $quantityByUnit = array_slice($request->so_luong, 0);

            $medicine = Medicine::create($medicineData);

            $inventories['medicine_id'] = $medicine->id;

            $inventories['storage_id'] = $request->storage_id;

            $inventories['quantity'] = array_product($request->so_luong);

            $inventories['unit_id'] = end($units);

            Inventory::create($inventories);

            foreach ($units as $id => $unit_id_2) {
                if ($unit_id_2 != $inventories['unit_id']) {
                    
                    UnitConversion::create([
                        'medicine_id' => $inventories['medicine_id'],
                        'unit_id_1' => $inventories['unit_id'],
                        'unit_id_2' => $unit_id_2,
                        'proportion' => $inventories['quantity'] / $quantityByUnit[$id]
                    ]);
                }
            }

            $medicine->suppliers()->attach($request->supplier_id);

            DB::commit();
            dd('Thêm thành công');
        } catch (\Exception $exception) {
            DB::rollback();
            dd($exception->getMessage());
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
    public function destroy(string $id)
    {
        //
    }
}
