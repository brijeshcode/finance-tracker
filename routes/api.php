<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Investor\PlatformController;

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


// Route::middleware('auth:sanctum')->name('api.')->group(function () {
    Route::name('api.')->group(function () {

    Route::name('investors.')->prefix('investor/')->group(function () { 

        Route::get('platofroms', [PlatformController::class, 'platfroms'])->name('platfroms');
        Route::get('stocks', [PlatformController::class, 'stocks'])->name('stocks');

    })->middleware(['role_or_permission:investor']);

});
