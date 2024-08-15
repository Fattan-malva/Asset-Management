<?php

use App\Http\Controllers\MerkController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AsetsController;
use App\Http\Controllers\AssetUserController;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MappingController;
use App\Http\Controllers\InventoryTotalController;
use App\Http\Controllers\UserController;
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
    return view('auth.login');
});

Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/register', [UserController::class, 'register'])->name('auth.register');
Route::post('register', [UserController::class, 'storeregister'])->name('user.storeregister');


Route::middleware(['auth.check'])->group(function () {

    Route::get('home', [HomeController::class, 'index'])->name('shared.home');
    Route::get('home/user', [HomeUserController::class, 'index'])->name('shared.homeUser');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    


    Route::resource('customer', CustomerController::class);
    Route::get('customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('customer/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('customer', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('customer/{id}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('customer/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('customer/{id}', [CustomerController::class, 'destroy'])->name('customer.delete');

    Route::resource('assets', AsetsController::class);
    Route::get('assetsgsi', [AsetsController::class, 'index'])->name('assets.index');
    Route::delete('assets/{id}', [AsetsController::class, 'destroy'])->name('assets.delete');
    Route::get('assets/create', [AsetsController::class, 'create'])->name('assets.create');
    Route::post('assetsgsi', [AsetsController::class, 'store'])->name('assets.store');
    Route::get('assets/{id}/edit', [AsetsController::class, 'edit'])->name('assets.edit');
    Route::get('assets/{id}/pindahtangan', [AsetsController::class, 'pindah'])->name('assets.pindahtangan');
    Route::put('/assets/{id}/pindah', [AsetsController::class, 'pindahUpdate'])->name('assets.pindahUpdate');
    Route::put('assets/{id}', [AsetsController::class, 'update'])->name('assets.update');
    Route::get('assets-history', [AsetsController::class, 'history'])->name('assets.history');



    Route::get('/my-assets', [AssetUserController::class, 'indexuser'])->name('asset-user');
    Route::get('assets/{id}/serahterima', [AssetUserController::class, 'serahterima'])->name('assets.serahterima');
    Route::put('/assets/{id}/updateserahterima', [AssetUserController::class, 'updateserahterima'])->name('assets.updateserahterima');
    Route::delete('assets-user/{id}', [AssetUserController::class, 'destroyasset'])->name('assets-user.delete');

    

    Route::resource('inventorys', InventoryController::class);
    Route::get('inventorys', [InventoryController::class, 'index'])->name('inventorys.index');
    Route::get('inventorystotal', [InventoryTotalController::class, 'summary'])->name('inventorys.total');
    Route::delete('inventorys/{id}', [InventoryController::class, 'destroy'])->name('inventorys.delete');
    Route::get('inventorys/create', [InventoryController::class, 'create'])->name('inventorys.create');
    Route::post('inventorys', [InventoryController::class, 'store'])->name('inventorys.store');
    Route::get('inventorys/{id}/edit', [InventoryController::class, 'edit'])->name('inventorys.edit');
    Route::put('inventorys/{id}', [InventoryController::class, 'update'])->name('inventorys.update');
    Route::get('mapping', [MappingController::class, 'mapping'])->name('inventorys.mapping');

    Route::get('merk/create', [MerkController::class, 'create'])->name('merk.create');
    Route::post('merk', [MerkController::class, 'store'])->name('merk.store');

    Route::get('/summary-report', [ReportController::class, 'summaryReport'])->name('summary.report');

});
