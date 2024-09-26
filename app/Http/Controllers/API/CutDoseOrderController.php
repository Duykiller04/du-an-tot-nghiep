<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\UnitConversion;

class CutDoseOrderController extends Controller
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

        // Tỷ lệ
        $proportion = UnitConversion::where('medicine_id', $medicineId)
        ->get()
        ->pluck('proportion')
        ->filter()
        ->values()
        ->toArray();

        //Lấy số lượng còn lại trong kho
        $quantitySave =  $quantity = Inventory::where('medicine_id', $medicineId)
        ->firstOrFail()
        ->quantity;

        $newQuantity = [];

        $proportion[0] = 1; //Thay thế tỉ lệ đầu tiên = 1 để tính giá

        $reversedProportion = array_reverse($proportion);

        foreach ($reversedProportion as $value) {
            $quantity /= $value; // Chia quantity cho giá trị hiện tại
            $newQuantity[] = floor($quantity); // Thêm vào mảng mới
        }

        // Loại bỏ phần tử cuối cùng trong mảng
        array_pop($newQuantity);

        // Thêm quantitySave vào đầu mảng
        array_unshift($newQuantity, floor($quantitySave));

        $newQuantity = array_reverse($newQuantity);

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
            'newPrices' => $newPrices,
            'quantity' => $newQuantity
        ]);
    }
}
