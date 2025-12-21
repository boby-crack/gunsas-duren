<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Pastikan Model Product sudah ada
use App\Models\Toko;

class PublicController extends Controller
{
    // Halaman Depan (Landing Page)
   // Jangan lupa import model Toko

public function index()
{
    $products = Product::latest()->take(6)->get();

    // TAMBAHKAN INI: Ambil semua data toko
    $tokos = Toko::all();

    return view('landing', compact('products', 'tokos'));
}

    // Halaman Katalog Full
    public function catalog()
    {
        $products = Product::all();
        return view('reseller.catalog.index', compact('products'));
    }
}
