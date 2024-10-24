<?php

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\API\CutDoseOrderController;
use App\Http\Controllers\API\UnitMedicineController;
use App\Http\Controllers\API\PrescriptionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('get-units/{medicineId}', [UnitMedicineController::class, 'getUnits']);

Route::get('cut-dose-order/{medicineId}', [CutDoseOrderController::class, 'getUnits']);
// Route::get('get-price/{medicineId}', [UnitMedicineController::class, 'getPrice']);

Route::get('admin/catalogues/getChildren', [CategoryController::class, 'getChildren'])->name('admin.catalogues.getChildren');

Route::get('get-prescription-details', [PrescriptionsController::class, 'getPrescriptionDetails']);

// dasboard customer
Route::get('/dashboard-customers', [DashboardController::class, 'getTotalCustomers'])->name('dashboard-customers');
Route::get('/dashboard-categories', [DashboardController::class, 'getTotalCategory'])->name('dashboard-categories');
Route::get('dashboard/suppliers', [DashboardController::class, 'getSupplier'])->name('dashboard.suppliers');