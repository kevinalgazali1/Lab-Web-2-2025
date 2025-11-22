<?php

use App\Http\Controllers\WarehousesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::get('/product', function () {
    return view('');
});

Route::view('/', 'template.home');

Route::resource('category', CategoryController::class);
Route::resource('warehouses', WarehousesController::class);
Route::resource('products',ProductsController::class);

Route::get('stocks', [StockController::class, 'index'])->name('stocks.index');
Route::get('stocks/transfer', [StockController::class, 'transfer'])->name('stocks.transfer');
Route::post('stocks/transfer', [StockController::class, 'processTransfer'])->name('stocks.processTransfer');


