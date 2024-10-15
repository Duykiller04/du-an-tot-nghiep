<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CutDosePrescription;
use App\Models\Inventory;
use App\Models\UnitConversion;
use Illuminate\Http\Request;

class PrescriptionsController extends Controller
{
    // Lấy thông tin chi tiết đơn thuốc
    public function getPrescriptionDetails(Request $request)
{
    $prescriptionId = $request->input('id');

    // Lấy đơn thuốc cùng với chi tiết đơn thuốc, thuốc, đơn vị và số lượng trong kho
    $cutDosePrescription = CutDosePrescription::with([
        'cutDosePrescriptionDetails.medicine.inventory', // Thêm mối quan hệ inventory
        'cutDosePrescriptionDetails.unit'
    ])->find($prescriptionId);

    if ($cutDosePrescription) {
        // Lấy chi tiết đơn thuốc
        $prescriptionDetails = $cutDosePrescription->cutDosePrescriptionDetails;

        // Lấy tất cả $medicineId từ các chi tiết đơn thuốc
        $medicineIds = $prescriptionDetails->pluck('medicine_id')->unique()->toArray();

        // Khởi tạo mảng để chứa số lượng tồn kho theo từng đơn vị
        $quantities = [];

        foreach ($medicineIds as $medicineId) {
            // Lấy số lượng tồn kho từ bảng inventories
            $inventory = Inventory::where('medicine_id', $medicineId)->firstOrFail();
            $quantitySave = $inventory->quantity;

            // Lấy tỷ lệ quy đổi từ bảng unit_conversions
            $unitConversions = UnitConversion::where('medicine_id', $medicineId)->get();
            $proportions = $unitConversions->pluck('proportion')->toArray();

            $newQuantity = [];
            $proportions[0] = 1; // Thay thế tỉ lệ đầu tiên = 1 để tính giá
            $reversedProportions = array_reverse($proportions);

            // Tính toán số lượng theo từng đơn vị
            foreach ($reversedProportions as $value) {
                $quantitySave /= $value; // Chia quantity cho giá trị hiện tại
                $newQuantity[] = floor($quantitySave); // Thêm vào mảng mới
            }

            // Loại bỏ phần tử cuối cùng trong mảng
            array_pop($newQuantity);

            // Thêm quantitySave vào đầu mảng
            array_unshift($newQuantity, floor($inventory->quantity));

            $newQuantity = array_reverse($newQuantity);

            // Lưu trữ số lượng theo từng medicine_id
            $quantities[$medicineId] = $newQuantity;
        }
        return response()->json([
            'prescriptionDetails' => $prescriptionDetails,
            'quantities' => $quantities // Trả về số lượng tồn kho theo từng đơn vị
        ]);
    }

    return response()->json([
        'message' => 'Không tìm thấy đơn thuốc.',
        'prescriptionDetails' => [],
    ]);
}





    
}
