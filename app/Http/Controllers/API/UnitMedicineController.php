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
        // Lấy đơn vị nhỏ nhất
        $smallestUnit = Inventory::where('medicine_id', $medicineId)->first();
    
        // Kiểm tra nếu không có đơn vị nào
        if (!$smallestUnit) {
            return response()->json(['units' => [], 'smallestUnit' => null]);
        }
    
        $smallestUnitName = Unit::find($smallestUnit->unit_id)->name;
        $smallestUnitId = $smallestUnit->unit_id;
    
        // Lấy các đơn vị lớn hơn và tỷ lệ chuyển đổi
        $largerUnits = UnitConversion::where('medicine_id', $medicineId)
            ->with('unit2')
            ->get();
            
        $units = [];
        $proportions = [];
        $largestProportion = 1;
        $unitLargest = null;
        // dd($largerUnits->toArray());
    
        foreach ($largerUnits as $conversion) {
            // Lấy đơn vị từ các quan hệ đã được định nghĩa trong model
            $units[$conversion->unit2->id] = $conversion->unit2->name;
    
            // Xác định đơn vị lớn nhất dựa vào tỷ lệ chuyển đổi
            if ($conversion->proportion > $largestProportion) {
                $unitLargest = $conversion->unit2;
                $largestProportion = $conversion->proportion;
                
            }
            
            // Lưu tỷ lệ chuyển đổi từ đơn vị lớn hơn về đơn vị nhỏ nhất
            $proportions[$conversion->unit2->id] = $conversion->proportion;
        }
    
        // Lấy giá bán cho đơn vị lớn nhất (giá hộp)
        $medicine = Medicine::find($medicineId);
        $pricePerLargestUnit = $medicine->price_sale;
    
        // Tính giá cho đơn vị nhỏ nhất (viên) dựa trên tỷ lệ chuyển đổi tổng
        $pricePerSmallestUnit = $pricePerLargestUnit / $largestProportion;
    
        return response()->json([
            'units' => $units,
            'smallestUnit' => $smallestUnit, // Đơn vị nhỏ nhất
            'smallestUnitName' => $smallestUnitName, // Tên đơn vị nhỏ nhất
            'smallestUnitId' => $smallestUnitId, // ID đơn vị nhỏ nhất
            'pricePerSmallestUnit' => $pricePerSmallestUnit, // Giá cho đơn vị nhỏ nhất
            'pricePerLargestUnit' => $pricePerLargestUnit, // Giá cho đơn vị lớn nhất
            'largestUnitId' => $unitLargest ? $unitLargest->id : null, // ID đơn vị lớn nhất
            'proportions' => $proportions // Tỷ lệ chuyển đổi
        ]);
    }
    
}
