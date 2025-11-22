<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function tambah($a, $b)
    {
        $hasil = $a + $b;
        return "Hasil dari penjumlahan $a + $b = $hasil";
    }
}
