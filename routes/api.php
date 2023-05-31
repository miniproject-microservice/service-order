<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('product/')->name('product.')->group(function () {
    Route::get('index', [ProductController::class, 'index'])->name('index');
    Route::get('detail/{id}', [ProductController::class, 'detail'])->name('detail');
    Route::post('store', [ProductController::class, 'store'])->name('store');
    Route::post('update/{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [ProductController::class, 'delete'])->name('delete');
});

Route::prefix('order/')->name('order.')->group(function () {
    Route::get('pay/{id}', [OrderController::class, 'pay'])->name('pay');
});
