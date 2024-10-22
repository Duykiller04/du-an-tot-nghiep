<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Medicine;
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
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
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
