<?php

use App\Http\Controllers\CutDoseOrderController;
use App\Http\Controllers\CutDosePrescriptionController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DeseaseController;
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

        Route::resource('users', UserController::class);

        Route::resource('customers', CustomerController::class);

        Route::resource('suppliers', SupplierController::class);

        Route::resource('cutdoseprescription', CutDosePrescriptionController::class);
        Route::resource('cutdoseorder', CutDoseOrderController::class);
    });


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
