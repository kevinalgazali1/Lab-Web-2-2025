<?php

use Illuminate\Support\Facades\Route; // Pastikan ini ada
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;

// ----------------------------------------------------
// BARIS PERBAIKAN: Arahkan root URL (/) ke halaman Produk
// ----------------------------------------------------
Route::get('/', [ProductController::class, 'index'])->name('home');
// ----------------------------------------------------


// 1. Manajemen Category
Route::resource('categories', CategoryController::class);

// 2. Manajemen Warehouse
Route::resource('warehouses', WarehouseController::class);

// 3. Manajemen Produk
Route::resource('products', ProductController::class);

// 4. Manajemen Stok
Route::get('stocks', [StockController::class, 'index'])->name('stocks.index');
Route::get('stocks/transfer', [StockController::class, 'transferStokForm'])->name('stocks.transfer.form');
Route::post('stocks/transfer', [StockController::class, 'processTransferStok'])->name('stocks.transfer.process');