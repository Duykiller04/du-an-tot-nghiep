<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GetAllProductController extends Controller
{
    public function getAllProduct()
    {
        $medicines = Medicine::with(['category', 'batches.inventory', 'unitConversions'])->get();
        // dd($medicines->toArray());
        // Biến đổi dữ liệu
        $transformedData = $medicines->map(function ($medicine) {
            return [
                'id' => $medicine->id,
                'name' => $medicine->name,
                'price' => $medicine->batches->isNotEmpty()
                    ? $medicine->batches->first()->price_in_smallest_unit
                    : 0,
                'quantity' => $medicine->batches->isNotEmpty()
                    ? $medicine->batches->sum(function ($batch) {
                        return optional($batch->inventory)->quantity ?? 0;
                    })
                    : 0,
                'unit_smallest' => $medicine->batches->isNotEmpty()
                    ? optional($medicine->batches->first()->inventory)->unit_id ?? 0
                    : 0,
                'category' => optional($medicine->category)->name ?? 'Unknown',
                'img' => $medicine->image
                    ? Storage::url($medicine->image)
                    : 'https://via.placeholder.com/100?text=' . urlencode($medicine->name),
                'batches' => $medicine->batches->map(function ($batch) {
                    return [
                        'id' => optional($batch)->id,
                        'price_in_smallest_unit' => optional($batch)->price_in_smallest_unit,
                        'quantity' => optional(optional($batch)->inventory)->quantity ?? 0,
                        'expiration_date' => optional($batch)->expiration_date,
                        'created_at' => optional($batch->created_at)->format('d-m-Y'),
                    ];
                })->toArray()
            ];
        })->toArray();


        return response()->json($transformedData);
    }
    public function getInvoicesOfTheDay()
    {
        // Lấy ngày hiện tại
        $today = Carbon::today();

        // Truy vấn hóa đơn thông thường
        $normalInvoices = DB::table('prescriptions') // Đổi tên bảng tương ứng
            ->select([
                'seller as seller',
                'total_price as total_price',
                'created_at as created_at',
                'customer_name as customer_name',
                DB::raw("'Đơn thông thường' as type") // Gán loại hóa đơn
            ])
            ->whereDate('created_at', $today);

        // Truy vấn hóa đơn cắt liều
        $splitInvoices = DB::table('cut_dose_orders') // Đổi tên bảng tương ứng
            ->select([
                'seller as seller',
                'total_price as total_price',
                'created_at as created_at',
                'customer_name as customer_name',
                DB::raw("'Đơn cắt liều' as type") // Gán loại hóa đơn
            ])
            ->whereDate('created_at', $today);

        // Gộp 2 truy vấn bằng union
        $invoices = $normalInvoices->union($splitInvoices)->orderBy('created_at', 'desc')->get();

        // Trả về kết quả
        return response()->json($invoices);
    }
}
