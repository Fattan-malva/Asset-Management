<?php

use App\Http\Controllers\{
    MerkController,
    HomeController,
    HomeUserController,
    DashboardController,
    ReportController,
    AsetsController,
    AssetUserController,
    CustomerController,
    InventoryController,
    MappingController,
    InventoryTotalController,
    UserController
};
use Illuminate\Support\Facades\Route;
use App\Events\DataUpdated;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/register', [UserController::class, 'register'])->name('auth.register');
Route::post('/register', [UserController::class, 'storeregister'])->name('user.storeregister');

Route::middleware(['auth.check'])->group(function () {
    Route::get('/home/user', [HomeUserController::class, 'index'])->name('shared.homeUser');
    Route::get('/dashboard-User', [DashboardController::class, 'indexUser'])->name('dashboard.user');
    Route::get('/my-assets', [AssetUserController::class, 'indexuser'])->name('asset-user');
    Route::get('assets/{id}/serahterima', [AssetUserController::class, 'serahterima'])->name('assets.serahterima');
    Route::put('/assets/{id}/updateserahterima', [AssetUserController::class, 'updateserahterima'])->name('assets.updateserahterima');
    Route::delete('assets-user/{id}', [AssetUserController::class, 'destroyasset'])->name('assets-user.delete');
    Route::delete('/assets/{id}/return', [AssetUserController::class, 'returnAsset'])->name('assets.return');
    Route::post('/assets/reject/{id}', [AsetsController::class, 'reject'])->name('assets.reject');
    Route::delete('assets/{id}', [AsetsController::class, 'destroy'])->name('assets.delete');
    Route::get('/assets/print/{id}', [AsetsController::class, 'print'])->name('assets.print');
    Route::get('/test-broadcast', function () {
        $data = ['message' => 'This is a test message'];
        event(new DataUpdated($data));
        return 'Broadcast event fired!';
    });


});

Route::middleware(['auth.check:admin'])->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('shared.home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('customer', CustomerController::class);
    Route::get('customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('customer/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('customer', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('customer/{id}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('customer/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('customer/{id}', [CustomerController::class, 'destroy'])->name('customer.delete');

    Route::resource('assets', AsetsController::class);
    // routes/web.php
    Route::get('assets/data', [App\Http\Controllers\AsetsController::class, 'data'])->name('assets.data');
    Route::get('assetsgsi', [AsetsController::class, 'index'])->name('assets.index');
    Route::get('assetsgsi/mutasi', [AsetsController::class, 'indexmutasi'])->name('assets.indexmutasi');
    Route::get('assetsgsi/return', [AsetsController::class, 'indexreturn'])->name('assets.indexreturn');
    Route::delete('assets/{id}', [AsetsController::class, 'destroy'])->name('assets.delete');
    Route::get('assets/create', [AsetsController::class, 'create'])->name('assets.create');
    Route::post('assetsgsi', [AsetsController::class, 'store'])->name('assets.store');
    Route::get('assets/{id}/edit', [AsetsController::class, 'edit'])->name('assets.edit');
    Route::get('assets/{id}/pindahtangan', [AsetsController::class, 'pindah'])->name('assets.pindahtangan');
    Route::put('/assets/{id}/pindah', [AsetsController::class, 'pindahUpdate'])->name('assets.pindahUpdate');
    Route::put('assets/{id}', [AsetsController::class, 'update'])->name('assets.update');
    Route::get('assets-history', [AsetsController::class, 'history'])->name('assets.history');
    // web.php
    Route::get('/history', [AsetsController::class, 'history'])->name('history');
    Route::get('/history/data', [AsetsController::class, 'getData'])->name('history.data');



    Route::get('/assets/return/{id}', [AsetsController::class, 'returnAsset'])->name('assets.return');
    Route::put('/assets/return/{id}', [AsetsController::class, 'returnUpdate'])->name('assets.returnUpdate');
    Route::put('/assets/{id}/approvereturn', [AsetsController::class, 'approveReturn'])->name('assets.approvereturn');
    Route::put('/assets/{id}/approvemutasi', [AsetsController::class, 'approveMutasi'])->name('assets.approvemutasi');
    Route::put('/assets/{id}/approveaction', [AsetsController::class, 'approveAction'])->name('assets.approveaction');
    Route::post('/assets/rollbackMutasi/{id}', [AsetsController::class, 'rollbackMutasi'])->name('assets.rollbackMutasi');


    Route::resource('inventorys', InventoryController::class);
    Route::get('inventorys', [InventoryController::class, 'index'])->name('inventorys.index');
    Route::get('inventorystotal', [InventoryTotalController::class, 'summary'])->name('inventorys.total');
    Route::delete('inventorys/{id}', [InventoryController::class, 'destroy'])->name('inventorys.delete');
    Route::get('inventorys/create', [InventoryController::class, 'create'])->name('inventorys.create');
    Route::post('inventorys', [InventoryController::class, 'store'])->name('inventorys.store');
    Route::get('inventorys/{id}/edit', [InventoryController::class, 'edit'])->name('inventorys.edit');
    Route::put('inventorys/{id}', [InventoryController::class, 'update'])->name('inventorys.update');
    Route::get('mapping', [MappingController::class, 'mapping'])->name('inventorys.mapping');

    Route::resource('merk', MerkController::class);
    Route::get('/merks', [MerkController::class, 'index'])->name('merk.index');
    Route::get('/merks/create', [MerkController::class, 'create'])->name('merk.create');
    Route::post('/merks', [MerkController::class, 'store'])->name('merk.store');
    Route::get('/merks/{id}/edit', [MerkController::class, 'edit'])->name('merk.edit');
    Route::put('/merks/{id}', [MerkController::class, 'update'])->name('merk.update');
    Route::delete('/merks/{id}', [MerkController::class, 'destroy'])->name('merk.destroy');

    Route::get('/summary-report', [ReportController::class, 'summaryReport'])->name('summary.report');

});
