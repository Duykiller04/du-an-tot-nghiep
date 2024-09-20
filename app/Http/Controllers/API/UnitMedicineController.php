<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Medicine;
use App\Models\Unit;
use App\Models\UnitConversion;
use Illuminate\Http\Request;

class UnitMedicineController extends Controller
{
    public function getUnits($medicineId)
    {
        $units = UnitConversion::with('unit')
        ->where('medicine_id', $medicineId)
        ->get()
        ->pluck('unit')
        ->filter()
        ->values();

        $price_sale = Medicine::findOrFail($medicineId)->price_sale;

        $proportion = UnitConversion::where('medicine_id', $medicineId)
        ->get()
        ->pluck('proportion')
        ->filter()
        ->values();

        $proportion[0] = 1; //Thay thế tỉ lệ đầu tiên = 1 để tính giá

        // Khởi tạo mảng mới
        $newPrices = [];
        $product = 1; // Biến để giữ tích

        // Tính toán cho newPrices
        foreach ($proportion as $value) {
            $product *= $value; // Cập nhật tích
            $newPrices[] = $price_sale / $product; // Tính giá mới
        }

        return response()->json([
            'units' => $units,
            'price_sale' => $price_sale,
            'proportion' => $proportion,
            'newPrices' => $newPrices
        ]);
    }

}
