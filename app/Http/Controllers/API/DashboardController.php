<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CutDoseOrder;
use App\Models\Medicine;
use App\Models\Storage;
use App\Models\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}


    public function getTotalCustomers()
    {
        $totalCustomers = Customer::count();
        // dd($totalCustomers);
        return response()->json(['totalCustomers' => $totalCustomers]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function getTotalCategory()
    {
        // Lấy danh sách danh mục thuốc và số lượng thuốc trong từng danh mục
        $categories = Category::withCount('medicines')->get();
        // Tính tổng số tên thuốc thuộc cach danh mục
        $totalMedicines = $categories->sum('medicines_count');

        // Tạo mảng dữ liệu để lưu thông tin danh mục và tỷ lệ phần trăm
        $data = [];
        foreach ($categories as $category) {
            $percentage = ($totalMedicines > 0) ? ($category->medicines_count / $totalMedicines) * 100 : 0;
            $data[] = [
                'name' => $category->name,
                'count' => $category->medicines_count,
                'percentage' => round($percentage, 2), // Làm tròn phần trăm
            ];
        }
        // Trả về phản hồi JSON với dữ liệu
        return response()->json($data);
    }

    public function getSupplier()
    { {
            // Lấy tổng số loại thuốc
            $totalMedicines = Medicine::count();

            // Lấy danh sách nhà cung cấp và số lượng loại thuốc họ cung cấp
            $suppliers = Supplier::withCount('medicines')->get();
            // Tính toán tỷ lệ phần trăm cho từng nhà cung cấp
            $supplierPercentages = $suppliers->map(function ($supplier) use ($totalMedicines) {
                return [
                    'supplier_name' => $supplier->name,
                    'percentage' => $totalMedicines > 0 ? ($supplier->medicines_count / $totalMedicines) * 100 : 0,
                ];
            });

            return response()->json($supplierPercentages);
        }
    }
    public function getStorage()
{
    try {
        // Lấy danh sách kho và đếm số lượng thuốc theo từng kho
        $storages = Storage::query()->withCount('medicines')->get();

        // Tính tổng số lượng thuốc từ tất cả các kho
        $totalMedicinesCount = $storages->sum('medicines_count');

        // Format lại dữ liệu trả về
        $formattedStorages = $storages->map(function ($storage) {
            return [
                'storage_name' => $storage->name,
                'medicines_count' => $storage->medicines_count,
            ];
        });

        return response()->json([
            'total_medicines_count' => $totalMedicinesCount,
            'storages' => $formattedStorages,
        ]);
    } catch (\Exception $e) {
        // Ghi log chi tiết lỗi
        Log::error('Lỗi khi lấy dữ liệu:', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);

        return response()->json([
            'error' => 'Lỗi khi lấy dữ liệu',
        ], 500);
    }
}

    
    

    public function recentOrders(){
        $recentOrders = CutDoseOrder::with(
            [
                'shift.users' => function ($query) {
                    $query->where('type', 'staff');
                },
               'cutDoseOrderDetails.medicine',
                'cutDoseOrderDetails.unit',
                'disease',
                'customer'
                ])
        ->where('created_at', '>=', now()->subDays(7))
        ->orderByDesc('created_at')
        ->limit(5)
        ->get();

       return response()->json($recentOrders);
    }
}
