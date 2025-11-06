<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FishController;

Route::get('/', [FishController::class, 'index'])->name('home');

Route::resource('fishes', FishController::class);