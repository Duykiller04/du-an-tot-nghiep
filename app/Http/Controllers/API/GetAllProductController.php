<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;

class GetAllProductController extends Controller
{
    public function getAllProduct()
    {
        $medicines = Medicine::with(['category', 'batches.inventory'])->get();
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
                    ? asset($medicine->image) 
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
}
