<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Unit;
use App\Models\UnitConversion;
use Illuminate\Http\Request;

class GetMedicineDetail extends Controller
{
    public function getMedicineDetail($medicineId)
    {
        $unitConver = UnitConversion::where('medicine_id', $medicineId)->latest('id')->first();
        $unitId  = $unitConver->unit_id;
        $unit = Unit::findOrFail($unitId);
        $unitName = $unit->name;
        return response()->json([
            'unitName' => $unitName
        ]);
    }
}
