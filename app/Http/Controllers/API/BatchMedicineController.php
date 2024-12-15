<?php 

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Batch;

class BatchMedicineController extends Controller{
    public function getBatchs($medicineId){
        $batchs = Batch::where('medicine_id', $medicineId)->get();
        return response()->json([
            'batchs' => $batchs
        ]);
    }
}