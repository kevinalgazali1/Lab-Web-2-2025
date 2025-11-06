<?php

use App\Http\Controllers\FishController;
use Illuminate\Support\Facades\Route;

// Redirect halaman utama ke halaman daftar ikan
Route::get('/', function () {
    return redirect()->route('fishes.index');
});

Route::resource('fishes', FishController::class);