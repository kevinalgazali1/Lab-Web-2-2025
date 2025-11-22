<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Categories Routes
Route::resource('categories', CategoryController::class);

// Warehouses Routes  
Route::resource('warehouses', WarehouseController::class);

// Products Routes
Route::resource('products', ProductController::class);

// Stock Management Routes
Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
Route::get('/stock/transfer', [StockController::class, 'transferForm'])->name('stock.transfer.form');
Route::post('/stock/transfer', [StockController::class, 'transfer'])->name('stock.transfer');