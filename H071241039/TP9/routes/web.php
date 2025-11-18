<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\StokController;

// Ganti route dashboard dengan root
Route::get('/', function () {
    return view('dashboard');
});

Route::resource('kategoris', KategoriController::class);
Route::resource('gudangs', GudangController::class);
Route::resource('produks', ProdukController::class);

Route::get('/stoks', [StokController::class, 'index'])->name('stoks.index');
Route::get('/stoks/transfer', [StokController::class, 'transfer'])->name('stoks.transfer');
Route::post('/stoks/transfer', [StokController::class, 'processTransfer'])->name('stoks.process-transfer');