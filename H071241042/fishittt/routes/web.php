<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FishController;

Route::get('/', function () {
    return view('welcome');     // tampilan welcome yg sudah kamu ubah
});

Route::resource('fishes', FishController::class);
