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

    // 1. INISIALISASI DEFAULT (PENTING: Agar tidak error saat compact)
    $readyOrders = 0;
    $paidOrders = 0;
    $totalRevenue = 0;
    $totalResellers = 0;
    $recentOrders = collect(); // Menggunakan collection kosong agar @forelse tidak error

    // 2. LOGIKA BERDASARKAN ROLE
    if ($user->role == 'staff') {
        // --- KHUSUS STAFF ---
        // Menghitung pesanan yang siap diambil di tokonya
        $readyOrders = \App\Models\Order::where('toko_id', $user->toko_id)
                        ->where('status', 'siap_diambil')
                        ->count();

        // Pendapatan toko ini saja (Lunas & Selesai)
        $totalRevenue = \App\Models\Order::where('toko_id', $user->toko_id)
                        ->whereIn('status', ['sudah_bayar', 'siap_diambil', 'selesai'])
                        ->sum('total_bayar');

        // Pesanan terbaru toko ini
        $recentOrders = \App\Models\Order::with(['user', 'toko'])
                        ->where('toko_id', $user->toko_id)
                        ->latest()
                        ->take(5)
                        ->get();

        $totalResellers = 0; // Staff tidak melihat total reseller
    } else {
        // --- KHUSUS ADMIN ---
        // Admin fokus ke pesanan baru yang sudah lunas tapi belum diproses
        $paidOrders = \App\Models\Order::where('status', 'sudah_bayar')->count();

        // Total pendapatan seluruh toko
        $totalRevenue = \App\Models\Order::whereIn('status', ['sudah_bayar', 'siap_diambil', 'selesai'])
                        ->sum('total_bayar');

        $totalResellers = \App\Models\User::where('role', 'reseller')->count();

        // Semua pesanan terbaru
        $recentOrders = \App\Models\Order::with(['user', 'toko'])
                        ->latest()
                        ->take(5)
                        ->get();
    }

    // Mengirimkan semua variabel ke view
    return view('admin.dashboard', compact(
        'readyOrders',
        'paidOrders',
        'totalRevenue',
        'totalResellers',
        'recentOrders'
    ));
}
}
