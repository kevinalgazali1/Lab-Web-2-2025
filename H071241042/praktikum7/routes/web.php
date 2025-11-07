<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home', ['title' => 'Home']);
});

Route::get('/destinasi', function () {
    return view('pages.destinasi', ['title' => 'Destinasi Wisata']);
});

Route::get('/kuliner', function () {
    return view('pages.kuliner', ['title' => 'Kuliner Khas']);
});

Route::get('/galeri', function () {
    return view('pages.galeri', ['title' => 'Galeri Foto']);
});

Route::get('/kontak', function () {
    return view('pages.kontak', ['title' => 'Kontak']);
});