<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // 1. Menampilkan Daftar Riwayat Pesanan
    public function index()
    {
        // Ambil data order milik user yang sedang login, urutkan dari yang terbaru
        $orders = Order::where('user_id', auth()->id())
                        ->with('toko') // Eager load data toko biar ringan
                        ->latest()
                        ->get();

        return view('reseller.orders.index', compact('orders'));
    }

    // 2. Menampilkan Detail Satu Pesanan
    public function show($id)
    {
        // Cari order, pastikan milik user yang login
        $order = Order::with(['toko', 'orderItems.product'])
                      ->where('user_id', auth()->id())
                      ->findOrFail($id);

        return view('reseller.orders.show', compact('order'));
    }
}
