<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Admin\DashboardController; 
use App\Http\Controllers\Admin\Setup\StockController;
use App\Http\Controllers\Investor\StockHoldingController;
use App\Http\Controllers\Admin\Setup\MutualFundController;
use App\Http\Controllers\Admin\AdvanceSetups\RoleController;
use App\Http\Controllers\Admin\AdvanceSetups\UserController;
use App\Http\Controllers\Investor\InvestorPlatformController;
use App\Http\Controllers\Investor\StockPurchaseController;
use App\Http\Controllers\Investor\StockSalesController;

// use App\Http\Controllers\Investor\StockTransactionController;

/*
|--------------------------------------------------------------------------
| Web Routestrue;
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
}); */

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


    Route::name('admin.')->prefix('admin/')->group(function () {
 
        
        Route::resource('users', UserController::class);
        Route::get('permissions/add-update', [RoleController::class, 'addOrUpdatePermissions'])->name('updatePermissions')->middleware(['role:admin']);

        Route::get('permissions/reset', [RoleController::class, 'resetPermissions'])->name('resetPermissions')->middleware(['role:admin']);

        Route::resource('roles', RoleController::class)->middleware(['role_or_permission:admin|roles access|roles edit|roles create']);
        
        Route::prefix('setup/')->group(function () {
            Route::resource('stocks', StockController::class);
            Route::resource('mutualFunds', MutualFundController::class);
        });
 
    });

    Route::name('investors.')->prefix('investor/')->group(function () { 
        
        Route::post('platforms', [InvestorPlatformController::class, 'store'])->name('platform.store');

        Route::name('stocks.')->prefix('stock/')->group(function () { 
            Route::get('/', [StockHoldingController::class, 'portfolio'])->name('portfolio'); 
            Route::get('holdings', [StockHoldingController::class, 'holdings'])->name('holdings'); 
            Route::post('/purchase/store', [StockPurchaseController::class, 'store'])->name('purchase');
            Route::post('/sell/store', [StockSalesController::class, 'store'])->name('sell');
        });

        // Route::resource('stockTransactions', StockTransactionController::class)->except('show');
    })->middleware(['role_or_permission:investor']);
    

});
