<?php

use App\Http\Controllers\API\BatchMedicineController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\API\CutDoseOrderController;
use App\Http\Controllers\Api\GetAllProductController;
use App\Http\Controllers\API\GetMedicineDetail;
use App\Http\Controllers\API\UnitMedicineController;
use App\Http\Controllers\API\PrescriptionsController;
use App\Http\Controllers\API\Unitcontroller;
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
Route::get('get-medicine-detail/{medicineId}', [GetMedicineDetail::class, 'getMedicineDetail']);

Route::get('get-largest-unit/{medicineId}', [UnitMedicineController::class, 'getLargestUnit']);

Route::get('get-all-product', [GetAllProductController::class, 'getAllProduct']);

Route::get('cut-dose-order/{medicineId}', [CutDoseOrderController::class, 'getUnits']);
// Route::get('get-price/{medicineId}', [UnitMedicineController::class, 'getPrice']);

Route::get('admin/catalogues/getChildren', [CategoryController::class, 'getChildren'])->name('admin.catalogues.getChildren');
Route::get('admin/units/getChildren', [Unitcontroller::class, 'getChildren'])->name('admin.units.getChildren');

Route::get('get-prescription-details', [PrescriptionsController::class, 'getPrescriptionDetails']);

// dasboard customer
Route::get('/dashboard-customers', [DashboardController::class, 'getTotalCustomers'])->name('dashboard-customers');
Route::get('/dashboard-categories', [DashboardController::class, 'getTotalCategory'])->name('dashboard-categories');
Route::get('dashboard/suppliers', [DashboardController::class, 'getSupplier'])->name('dashboard.suppliers');
// routes/web.php
Route::get('/dashboard/storages', [DashboardController::class, 'getStorage'])->name('dashboard.storages');



Route::get('/dashboard/recent-orders', [DashboardController::class, 'recentOrders'])->name('dashboard.recent.order');

Route::get('/dashboard/total-revenue', [DashboardController::class, 'getDashboardRevenue'])->name('dashboard.total.revenue');

Route::post('/dashboard/filter', [DashboardController::class, 'getFilter'])->name('dashboard.filter');

Route::get('/dashboard/total-orders', [DashboardController::class, 'totalOrders'])->name('dashboard.total.orders');

Route::get('/dashboard/profit', [DashboardController::class, 'getProfit'])->name('dashboard.profit');
Route::get('/dashboardtopsuppliers', [DashboardController::class, 'getTopSuppliers'])->name('dashboard.dashboardtopsuppliers');
Route::get('/dashboardtopmedicines', [DashboardController::class, 'getTopMedicines'])->name('dashboard.dashboardtopmedicines');
Route::get('/dashboard/store-statistics', [DashboardController::class, 'getStatistics'])->name('dashboard.store.statistics');



