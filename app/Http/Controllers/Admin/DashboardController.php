<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class DashboardController extends Controller
{
   public function index()
{
    $user = auth()->user();

    // 1. SETUP QUERY DASAR
    $orders = \App\Models\Order::query();

    // 2. FILTER BERDASARKAN ROLE
    if ($user->role == 'staff') {
        // Staff cuma hitung data tokonya sendiri
        $pendingOrders = $orders->where('toko_id', $user->toko_id)
                                ->where('status', 'sudah_bayar') // Staff fokus ke yang sudah bayar utk disiapkan
                                ->count();

        // Pendapatan Toko Ini Saja
        // Kita perlu clone query agar tidak tumpang tindih
        $totalRevenue = \App\Models\Order::where('toko_id', $user->toko_id)
                                         ->whereIn('status', ['sudah_bayar', 'siap_diambil', 'selesai'])
                                         ->sum('total_bayar');

        // Staff tidak perlu tahu jumlah reseller global, kasih 0 atau hitung order hari ini
        $totalResellers = 0;

        // Tabel Pesanan Terbaru (Hanya Toko Ini)
        $recentOrders = \App\Models\Order::with(['user', 'toko'])
                                         ->where('toko_id', $user->toko_id)
                                         ->latest()
                                         ->take(5)
                                         ->get();
    } else {
        // ADMIN: Lihat Semuanya
        $pendingOrders = \App\Models\Order::where('status', 'menunggu_bayar')->count();
        $totalRevenue = \App\Models\Order::whereIn('status', ['sudah_bayar', 'siap_diambil', 'selesai'])->sum('total_bayar');
        $totalResellers = \App\Models\User::where('role', 'reseller')->count();
        $recentOrders = \App\Models\Order::with(['user', 'toko'])->latest()->take(5)->get();
    }

    return view('admin.dashboard', compact('pendingOrders', 'totalRevenue', 'totalResellers', 'recentOrders'));
}
}
