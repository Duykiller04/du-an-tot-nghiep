<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CutDoseOrderController;
use App\Http\Controllers\Admin\CutDosePrescriptionController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DiseaseController;
use App\Http\Controllers\Admin\DeseaseController;
use App\Http\Controllers\Admin\EnvironmentController;
use App\Http\Controllers\Admin\InventoryAuditController;
use App\Http\Controllers\Admin\ImportOrderController;
use App\Http\Controllers\Admin\MedicalInstrumentController;
use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\Admin\StorageController;
use App\Http\Controllers\Admin\UnitController;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('admin.layouts.master');
});

Route::get('/login', function () {
    return view('auth.login');
});

Auth::routes();


Route::prefix('admin')
    ->as('admin.')
    ->middleware('auth')
    ->group(function () {

        Route::controller(EnvironmentController::class)
            ->prefix('environments')->as('environments.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/export-environments', 'export')->name('export');
                Route::get('/add', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/update/{id}', 'update')->name('update');
                Route::delete('/delete/{id}', 'destroy')->name('destroy');
            });

        Route::controller(InventoryAuditController::class)
            ->prefix('inventoryaudit')->as('inventoryaudit.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/export-environments', 'export')->name('export');
                Route::get('/add', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/detail/{id}', 'show')->name('show');
                Route::delete('/delete/{id}', 'destroy')->name('destroy');
            });

        Route::resource('diseases', DiseaseController::class);

        Route::resource('catalogues', CategoryController::class);

        Route::resource('users', UserController::class);

        Route::resource('customers', CustomerController::class);

        Route::resource('suppliers', SupplierController::class);

        Route::resource('medicalInstruments', MedicalInstrumentController::class);

        Route::resource('medicines', MedicineController::class);

        Route::resource('units', UnitController::class);

        Route::resource('cutDoseOrders', CutDoseOrderController::class);

        Route::resource('cutDosePrescriptions', CutDosePrescriptionController::class);

        Route::resource('storage', StorageController::class);

        Route::resource('importorder', ImportOrderController::class);

    });

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
