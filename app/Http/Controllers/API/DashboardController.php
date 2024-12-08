<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\CutDoseOrder;
use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\Storage;
use App\Models\Supplier;
use Carbon\Carbon;
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




    public function recentOrders()
    {
        $cutDoseOrders = CutDoseOrder::with(
            [
                'disease',
            ]
        )
            ->where('created_at', '>=', now()->subDays(30))
            ->orderByDesc('created_at')
            ->limit(value: 5)
            ->get()->toArray();         
            $presscriptions = Prescription::where('created_at', '>=', now()->subDays(30))
                ->orderByDesc('created_at')
                ->limit(value: 5)
                ->get()->toArray();
                
        // Thêm trường 'prescription_name' cho đơn thuốc cắt liều
        foreach ($cutDoseOrders as &$cutDoseOrder) {
            $cutDoseOrder['prescription_name'] = 'Đơn thuốc cắt liều';
        }

        // Thêm trường 'prescription_name' cho đơn thuốc thông thường
        foreach ($presscriptions as &$order) {
            $order['prescription_name'] = 'Đơn thuốc thông thường';
        }
        $recentOrders = array_merge($cutDoseOrders,$presscriptions);
        return response()->json($recentOrders);
    }


    //tông doanh thu
    public function getDashboardRevenue()
    {
        // Tổng doanh thu từ bảng Prescription
        $totalPrescription = DB::table('prescriptions')
            ->whereNull('deleted_at') // Nếu sử dụng SoftDeletes
            ->sum('total');

        // Tổng doanh thu từ bảng CutDoseOrder
        $totalCutDoseOrder = DB::table('cut_dose_orders')
            ->whereNull('deleted_at') // Nếu sử dụng SoftDeletes
            ->sum('total_price');

        // Tổng doanh thu
        $totalRevenue = $totalPrescription + $totalCutDoseOrder;

        // Định dạng tổng doanh thu và các giá trị theo kiểu "36,894 VND"
        $formattedTotalPrescription = number_format($totalPrescription, 0, ',', ',') . ' VND';
        $formattedTotalCutDoseOrder = number_format($totalCutDoseOrder, 0, ',', ',') . ' VND';
        $formattedTotalRevenue = number_format($totalRevenue, 0, ',', ',') . ' VND';

        // Tạo mảng dữ liệu để trả về
        $revenueData = [
            'totalPrescription' => $formattedTotalPrescription,
            'totalCutDoseOrder' => $formattedTotalCutDoseOrder,
            'totalRevenue' => $formattedTotalRevenue,
        ];

        // Trả về JSON response
        return response()->json($revenueData);
    }

    public function getFilter(Request $request)
{
    // Lấy giá trị startDate và endDate từ request
    $startDate = $request->input('startDate');
    $endDate = $request->input('endDate');

    // Kiểm tra và parse ngày
    try {
        $startDate = Carbon::createFromFormat('d/m/Y', $startDate)->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', $endDate)->endOfDay();
    } catch (\Exception $e) {
        return response()->json(['error' => 'Ngày không hợp lệ.'], 400);
    }

    // Lọc dữ liệu khách hàng trong khoảng thời gian
    $totalCustomers = Customer::whereBetween('created_at', [$startDate, $endDate])->count();

    // Tính tổng doanh thu
    $totalPrescription = DB::table('prescriptions')
        ->whereNull('deleted_at')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->sum('total');

    $totalCutDoseOrder = DB::table('cut_dose_orders')
        ->whereNull('deleted_at')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->sum('total_price');

    $totalRevenue = $totalPrescription + $totalCutDoseOrder;

    // Tính tổng giá nhập (price_import) trong khoảng thời gian
    $totalCostPrice = DB::table('medicines')
        ->whereBetween('created_at', [$startDate, $endDate]) // Lọc theo ngày nhập
        ->sum('price_import');

    // Tính lợi nhuận
    $profit = $totalRevenue - $totalCostPrice;

    // Tính tổng số đơn thuốc bán ra
    $totalPrescriptionOrders = DB::table('prescriptions')
        ->whereNull('deleted_at')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->count();

    $totalCutDoseOrders = DB::table('cut_dose_orders')
        ->whereNull('deleted_at')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->count();

    $totalOrders = $totalPrescriptionOrders + $totalCutDoseOrders;

    // Trả về JSON
    return response()->json([
        'totalCustomers' => $totalCustomers,
        'totalRevenue' => $totalRevenue,
        'totalCostPrice' => $totalCostPrice, // Tổng giá nhập
        'profit' => $profit, // Lợi nhuận
        'totalOrders' => $totalOrders
    ], 200);
}


    public function totalOrders()
    {
        $totalPrescriptionOrders = Prescription::count();
        $totalCutdouseOrders = CutDoseOrder::count();
        $totalCount = $totalPrescriptionOrders + $totalCutdouseOrders;
        return response()->json([
            'totalPrescriptionOrders' => $totalPrescriptionOrders,
            'totalCutdouseOrders' => $totalCutdouseOrders,
            'totalCount' => $totalCount
        ]);
    }
    public function getProfit()
    {
        $totalCostPrice = DB::table('medicines')->sum('price_import');
        // dd($totalCostPrice);
        $totalPrescriptionPrice = DB::table('prescriptions')->sum('total');

        $totalcutDoseOrdersPrice = DB::table('cut_dose_orders')->sum('total_price');
        

        $totalRevenue = $totalPrescriptionPrice + $totalcutDoseOrdersPrice;

        // Tính lợi nhuận
        $profit = $totalRevenue - $totalCostPrice;
        
        return response()->json([
            'total_cost_price' => $totalCostPrice,
            'total_revenue' => $totalRevenue,
            'profit' => $profit,
        ]);
    }

    public function getStatistics(Request $request)
    {
        $type = $request->query('type', 'day');
        $startDate = null;
        $endDate = Carbon::now();
        // Xử lý thống kê theo khoảng thời gian cụ thể
        switch ($type) {
            case 'week':
                $startDate = Carbon::now()->startOfWeek();
                break;
            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                break;
            case 'year':
                $startDate = Carbon::now()->startOfYear();
                break;
            default:
                $startDate = Carbon::now()->startOfDay();
                break;
        }
        // Tổng doanh thu
        $totalRevenueCutDoseOrders = CutDoseOrder::whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_price');
        $totalRevenuePrescriptions = Prescription::whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_price');
        $totalRevenue = $totalRevenueCutDoseOrders + $totalRevenuePrescriptions;
        // Tổng số đơn hàng
        $totalCutDoseOrders = CutDoseOrder::whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $totalPrecriptions = Prescription::whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $totalOrders = $totalCutDoseOrders + $totalPrecriptions;
        return response()->json([
            'totalRevenue' => $totalRevenue,
            'totalOrders' =>$totalOrders,
          ]);
    }

    public function getTopSuppliers(Request $request)
    {
        // Lấy giá trị startDate và endDate từ request
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');


        // Kiểm tra và parse ngày
        try {
            if (!$startDate || !$endDate) {
                $startDate = Carbon::now()->subYear()->startOfDay(); // 1 năm trước
                $endDate = Carbon::now()->endOfDay(); // Ngày hiện tại
            } else {
                $startDate = Carbon::createFromFormat('d/m/Y', $startDate)->startOfDay();
                $endDate = Carbon::createFromFormat('d/m/Y', $endDate)->endOfDay();
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ngày không hợp lệ.'], 400);
        }


        // Lấy top 5 nhà cung cấp có nhiều đơn thuốc từ các bảng liên quan
        try {
            $topSuppliers = DB::table('medicine_supplier')
                ->join('suppliers', 'medicine_supplier.supplier_id', '=', 'suppliers.id')
                ->join('medicines', 'medicine_supplier.medicine_id', '=', 'medicines.id')
                ->leftJoin('cut_dose_order_details', 'medicines.id', '=', 'cut_dose_order_details.medicine_id')
                ->leftJoin('cut_dose_orders', 'cut_dose_order_details.cut_dose_order_id', '=', 'cut_dose_orders.id')
                ->leftJoin('prescription_details', 'medicines.id', '=', 'prescription_details.medicine_id')
                ->leftJoin('prescriptions', 'prescription_details.prescription_id', '=', 'prescriptions.id')
                ->select(
                    'suppliers.name as supplier_name', // Lấy tên nhà cung cấp
                    'suppliers.created_at as join_date', // Lấy ngày tham gia của nhà cung cấp
                    DB::raw('count(distinct prescriptions.id) + count(distinct cut_dose_orders.id) as total_orders') // Tổng số đơn thuốc
                )
                ->whereNull('suppliers.deleted_at')
                ->where(function($query) use ($startDate, $endDate) {
                    $query->whereBetween('prescriptions.created_at', [$startDate, $endDate])
                        ->orWhereBetween('cut_dose_orders.created_at', [$startDate, $endDate]);
                })
                ->groupBy('suppliers.id')
                ->orderBy('total_orders', 'desc')
                ->take(5)
                ->get();


            // Trả về JSON
            return response()->json(['topSuppliers' => $topSuppliers], 200);
        } catch (\Exception $e) {
            // Trả về lỗi nếu có vấn đề
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getTopMedicines(Request $request)
    {
        // Lấy giá trị startDate và endDate từ request
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');


        // Kiểm tra và parse ngày
        try {
            if (!$startDate || !$endDate) {
                $startDate = Carbon::now()->subYear()->startOfDay(); // 1 năm trước
                $endDate = Carbon::now()->endOfDay(); // Ngày hiện tại
            } else {
                $startDate = Carbon::createFromFormat('d/m/Y', $startDate)->startOfDay();
                $endDate = Carbon::createFromFormat('d/m/Y', $endDate)->endOfDay();
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ngày không hợp lệ.'], 400);
        }


        // Lấy top 5 thuốc bán chạy nhất từ các bảng liên quan
        try {
            $topMedicines = DB::table('medicines')
                ->leftJoin('cut_dose_order_details', 'medicines.id', '=', 'cut_dose_order_details.medicine_id')
                ->leftJoin('cut_dose_orders', 'cut_dose_order_details.cut_dose_order_id', '=', 'cut_dose_orders.id')
                ->leftJoin('prescription_details', 'medicines.id', '=', 'prescription_details.medicine_id')
                ->leftJoin('prescriptions', 'prescription_details.prescription_id', '=', 'prescriptions.id')
                ->select(
                    'medicines.name as medicine_name',
                    'medicines.created_at as import_date', // Sử dụng created_at làm ngày nhập thuốc
                    DB::raw('count(distinct prescriptions.id) + count(distinct cut_dose_orders.id) as total_orders') // Tổng số đơn thuốc
                )
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('prescriptions.created_at', [$startDate, $endDate])
                        ->orWhereBetween('cut_dose_orders.created_at', [$startDate, $endDate]);
                })
                ->groupBy('medicines.id') // Nhóm theo ID thuốc
                ->orderBy('total_orders', 'desc')
                ->take(5)
                ->get();


            // Trả về JSON
            return response()->json(['topMedicines' => $topMedicines], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
