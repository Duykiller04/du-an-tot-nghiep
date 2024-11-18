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
    // Thống kê tổng số lượng thuốc trong tất cả các kho
    $totalMedicinesCount = Medicine::sum('quantity');  // Thay 'quantity' bằng tên trường trong bảng 'Medicine' chứa số lượng thuốc

    // Lấy thông tin kho và số lượng thuốc trong mỗi kho
    $storages = Storage::withCount('medicines')->get()->map(function ($storage) {
        return [
            'storage_name' => $storage->name,  // Tên kho
            'medicines_count' => $storage->medicines_count,  // Số lượng thuốc trong kho
        ];
    });
    dd(11);
    // Trả về kết quả dưới dạng JSON
    return response()->json([
        'total_medicines_count' => $totalMedicinesCount, // Tổng số lượng thuốc trong tất cả các kho
        'storages' => $storages  // Thông tin từng kho và số lượng thuốc trong kho
    ]);
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
        ->where('created_at', '>=', now()->subDays(3))
        ->orderByDesc('created_at')
        ->limit(5)
        ->get();

       return response()->json($recentOrders);
    }
}
