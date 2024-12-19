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

    //Truy vấn batch where theo storage_id rồi group by theo medicine_id


    public function getStorage()
    {
        try {
            // Lấy danh sách kho và đếm số lượng thuốc theo từng kho
            $storages = Storage::query()
                            ->select('storages.id', 'storages.name') // Chọn thông tin về kho
                            ->selectSub(function ($query) {
                                $query->from('batches')
                                    ->join('medicines', 'medicines.id', '=', 'batches.medicine_id') // Join với bảng medicines
                                    ->selectRaw('COUNT(DISTINCT batches.medicine_id)') // Đếm số lượng thuốc (distinct) trong từng kho
                                    ->whereColumn('batches.storage_id', 'storages.id') // Liên kết kho với batches
                                    ->whereNull('medicines.deleted_at'); // Lọc thuốc chưa bị xóa (soft deleted)
                            }, 'medicines_count')
                            ->latest('id') // Sắp xếp theo ID của kho
                            ->get(); // Lấy kết quả

            // Tính tổng số lượng thuốc trong tất cả các kho
           $totalMedicinesCount = Medicine::count();
    
            // Format lại dữ liệu trả về
            $formattedStorages = $storages->map(function ($storage) {
                return [
                    'storage_name' => $storage->name, // Tên kho
                    'medicines_count' => $storage->medicines_count, // Số lượng thuốc trong kho
                ];
            });
    
            return response()->json([
                'total_medicines_count' => $totalMedicinesCount, // Tổng số thuốc trong tất cả các kho
                'storages' => $formattedStorages, // Dữ liệu thống kê thuốc theo kho
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
        $recentOrders = array_merge($cutDoseOrders, $presscriptions);
        return response()->json($recentOrders);
    }


    //tông doanh thu
    public function getDashboardRevenue()
    {
        // Tổng doanh thu từ bảng Prescription
        $totalPrescription = DB::table('prescriptions')
            ->whereNull('deleted_at') // Nếu sử dụng SoftDeletes
            ->sum('total_price');
        // dd($totalPrescription); 

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

        // Tổng doanh thu từ bảng Prescription
        $totalPrescription = DB::table('prescriptions')
            ->whereNull('deleted_at') // Nếu sử dụng SoftDeletes
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_price');
        // dd($totalPrescription); 

        // Tổng doanh thu từ bảng CutDoseOrder
        $totalCutDoseOrder = DB::table('cut_dose_orders')
            ->whereNull('deleted_at') // Nếu sử dụng SoftDeletes
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_price');

        // Tổng doanh thu
        $totalRevenue = $totalPrescription + $totalCutDoseOrder;

        // Tính tổng giá nhập (price_import) trong khoảng thời gian
        $totalCostPrice = DB::table('batches')
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
            'totalCostPrice' => $totalCostPrice, 
            'profit' => $profit, 
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
        $totalCostPrice = DB::table('batches')->sum('price_import');

        // dd($totalCostPrice);
        $totalPrescriptionPrice = DB::table('prescriptions')->sum('total_price');


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
        $startDate = Carbon::now()->startOfYear();
        $endDate = Carbon::now()->endOfYear();
    
        $categories = [];
        $revenues = [];
        $profit = [];
    
        for ($i = 1; $i <= 12; $i++) {
            $dateStart = $startDate->copy()->addMonths($i - 1);
            $dateEnd = $dateStart->copy()->endOfMonth();
            $categories[] = "Tháng $i";
    
            $monthlyRevenue = CutDoseOrder::whereBetween('created_at', [$dateStart, $dateEnd])->sum('total_price') 
                            + Prescription::whereBetween('created_at', [$dateStart, $dateEnd])->sum('total_price');
                            $totalCostPrice = DB::table('batches')->whereBetween('created_at', [$dateStart, $dateEnd])->sum('price_import');

                            $totalPrescriptionPrice = DB::table('prescriptions')->whereBetween('created_at', [$dateStart, $dateEnd])->sum('total_price');
                    
                    
                            $totalcutDoseOrdersPrice = DB::table('cut_dose_orders')->whereBetween('created_at', [$dateStart, $dateEnd])->sum('total_price');
                    
                    
                            $totalRevenue = $totalPrescriptionPrice + $totalcutDoseOrdersPrice;
                            
                            // Tính lợi nhuận
                            $monthlyRevenue = $totalRevenue - $totalCostPrice;
            // Nếu không có dữ liệu, set mặc định là 0
            $revenues[] = $totalRevenue ?? 0;
            $profit[] = $monthlyRevenue ?? 0;
        }
    
        return response()->json([
            'categories' => $categories,
            'profit' => $profit,
            'revenues' => $revenues,
        ]);
    }
    
    public function getTopSuppliers(Request $request)
    {
        try {
            // Lấy loại thống kê thời gian từ query (mặc định là 'today')
            $type = $request->query('type', 'today');
            $startDate = now()->startOfDay();
            $endDate = now()->endOfDay();
    
            // Xử lý thời gian dựa vào loại $type
            switch ($type) {
                case 'yesterday':
                    $startDate = now()->subDay()->startOfDay();
                    $endDate = now()->subDay()->endOfDay();
                    break;
                case 'last_7_days':
                    $startDate = now()->subDays(7)->startOfDay();
                    $endDate = now()->endOfDay();
                    break;
                case 'last_30_days':
                    $startDate = now()->subDays(30)->startOfDay();
                    $endDate = now()->endOfDay();
                    break;
                case 'this_month':
                    $startDate = now()->startOfMonth()->startOfDay();
                    $endDate = now()->endOfMonth()->endOfDay();
                    break;
                case 'last_month':
                    $startDate = now()->subMonth()->startOfMonth()->startOfDay();
                    $endDate = now()->subMonth()->endOfMonth()->endOfDay();
                    break;
                case 'today':
                default:
                    $startDate = now()->startOfDay();
                    $endDate = now()->endOfDay();
                    break;
            }
    
            // Lấy top 5 nhà cung cấp dựa trên số lượng đơn hàng từ các lô
            $topSuppliers = DB::table('suppliers')
                ->leftJoin('batches', 'suppliers.id', '=', 'batches.supplier_id')
                ->leftJoin('cut_dose_order_details as c', 'batches.id', '=', 'c.batch_id')
                ->leftJoin('prescription_details as p', 'batches.id', '=', 'p.batch_id')
                ->select(
                    'suppliers.id',
                    'suppliers.name as supplier_name',
                    'suppliers.created_at as join_date',
                    DB::raw('MIN(batches.created_at) as first_batch_date'),
                    DB::raw('COUNT(DISTINCT c.id) + COUNT(DISTINCT p.id) as total_orders')
                )
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('c.created_at', [$startDate, $endDate])
                        ->orWhereBetween('p.created_at', [$startDate, $endDate]);
                })
                ->whereNull('suppliers.deleted_at')
                ->groupBy('suppliers.id', 'suppliers.name', 'suppliers.created_at')
                ->orderByDesc('total_orders')
                ->take(5)
                ->get();
    
            // Kiểm tra nếu không có dữ liệu
            if ($topSuppliers->isEmpty()) {
                if ($type === 'today' || $type === 'yesterday') {
                    return response()->json(['error' => 'Không có dữ liệu cho ngày được chọn'], 200);
                }
                return response()->json(['error' => 'Không tìm thấy dữ liệu'], 200);
            }
    
            // Trả về kết quả dưới dạng JSON
            return response()->json(['topSuppliers' => $topSuppliers], 200);
        } catch (\Exception $e) {
            // Xử lý lỗi
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function getTopMedicines(Request $request)
    {
        try {
            // Lấy top 5 thuốc dựa trên tổng số đơn hàng
            $topMedicines = DB::table('medicines as m')
                ->join('batches as b', 'm.id', '=', 'b.medicine_id') // Liên kết thuốc và lô thuốc
                ->leftJoin('cut_dose_order_details as c', 'b.id', '=', 'c.batch_id') // Đơn hàng bán theo liều
                ->leftJoin('prescription_details as p', 'b.id', '=', 'p.batch_id') // Đơn hàng bán theo đơn
                ->select(
                    'm.name as medicine_name', // Tên thuốc
                    DB::raw('MIN(b.created_at) as import_date'), // Ngày nhập thuốc sớm nhất
                    DB::raw('MIN(m.created_at) as join_date'), // Ngày tham gia của thuốc
                    DB::raw('COUNT(DISTINCT c.id) + COUNT(DISTINCT p.id) as total_orders') // Tổng số đơn hàng
                )
                ->whereNotNull('b.id') // Chỉ lấy thuốc có lô
                ->groupBy('m.id', 'm.name') // Nhóm theo thuốc
                ->orderByDesc('total_orders') // Sắp xếp giảm dần theo tổng đơn hàng
                ->limit(5) // Lấy top 5 thuốc
                ->get();


            // Kiểm tra nếu không có dữ liệu
            if ($topMedicines->isEmpty()) {
                return response()->json(['error' => 'Không tìm thấy dữ liệu'], 404);
            }


            // Trả về kết quả dưới dạng JSON
            return response()->json(['topMedicines' => $topMedicines], 200);
        } catch (\Exception $e) {
            // Xử lý lỗi
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
