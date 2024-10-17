<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CutDoseOrderController;
use App\Http\Controllers\Admin\CutDosePrescriptionController;
use App\Http\Controllers\Admin\PrescriptionsController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DiseaseController;
use App\Http\Controllers\Admin\EnvironmentController;
use App\Http\Controllers\Admin\InventoryAuditController;
use App\Http\Controllers\Admin\ImportOrderController;
use App\Http\Controllers\Admin\MedicalInstrumentController;
use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StorageController;
use App\Http\Controllers\Admin\UnitController;
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
    // return view('admin.layouts.master');
    return route('login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');;

Auth::routes();


Route::prefix('admin')
    ->as('admin.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', function () {
            return view("admin.dashboard");
        })->name('dashboard');

        Route::controller(SettingController::class)
            ->prefix('setting')->as('setting.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::put('/update/{id}', 'update')->name('update');
                Route::delete('/delete/{id}', 'destroy')->name('destroy');
            });
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
                Route::get('/download-template', 'downloadTemplate')->name('downloadTemplate');
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

        Route::resource('prescriptions', PrescriptionsController::class);

        Route::prefix('restore')->group(function () {
            // restore categories
            Route::get('/categories', [CategoryController::class, 'getRestore'])->name('restore.categories');
            Route::post('/categories', [CategoryController::class, 'restore']);

            // restore disease
            Route::get('/diseases', [DiseaseController::class, 'getRestore'])->name('restore.diseases');
            Route::post('/diseases', [DiseaseController::class, 'restore']);

            // restore suppliers
            Route::get('/suppliers', [SupplierController::class, 'getRestore'])->name('restore.suppliers');
            Route::post('/suppliers', [SupplierController::class, 'restore']);

            // restore users
            Route::get('/users', [UserController::class, 'getRestore'])->name('restore.users');
            Route::post('/users', [UserController::class, 'restore']);

            // restore units
            Route::get('/units', [UnitController::class, 'getRestore'])->name('restore.units');
            Route::post('/units', [UnitController::class, 'restore']);

            // restore units
            Route::get('/medicines', [MedicineController::class, 'getRestore'])->name('restore.medicines');
            Route::post('/medicines', [MedicineController::class, 'restore']);

            Route::get('/storages', [StorageController::class, 'getRestore'])->name('restore.storages');
            Route::post('/storages', [StorageController::class, 'restore']);

            Route::get('/cutDosePrescriptions', [CutDosePrescriptionController::class, 'getRestore'])->name('restore.cutDosePrescriptions');
            Route::post('/cutDosePrescriptions', [CutDosePrescriptionController::class, 'restore']);

            Route::get('/importorder', [ImportOrderController::class, 'getRestore'])->name('restore.importorder');
            Route::post('/importorder', [ImportOrderController::class, 'restore']);

            Route::get('/cutDoseOrders', [CutDoseOrderController::class, 'getRestore'])->name('restore.cutDoseOrders');
            Route::post('/cutDoseOrders', [CutDoseOrderController::class, 'restore']);
        });
    });
