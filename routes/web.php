<?php

use App\Http\Controllers\Admin\CatalogueController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DeseaseController;
use App\Http\Controllers\Admin\MedicalInstrumentController;
use App\Http\Controllers\Admin\MedicineController;
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
    return view('admin.layouts.master');
});

Route::get('/login', function () {
    return view('auth.login');
});

Auth::routes();


Route::prefix('admin')
    ->as('admin.')
    //->middleware('auth')
    ->group(function () {

        Route::controller(DeseaseController::class)
            ->prefix('diseases')->as('diseases.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/add', 'store')->name('store');
                Route::get('/{id}', 'edit')->name('edit');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });
        Route::controller(CatalogueController::class)
            ->prefix('catalogues')->as('catalogues.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/add', 'create')->name('add');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/update/{id}', 'update')->name('update');
                Route::delete('/delete/{id}', 'destroy')->name('destroy');
            });

        Route::resource('users', UserController::class);

        Route::resource('customers', CustomerController::class);

        Route::resource('suppliers', SupplierController::class);
      
        Route::resource('medicalInstruments', MedicalInstrumentController::class);
        Route::resource('medicines', MedicineController::class);
        Route::resource('units', UnitController::class);
    });


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
