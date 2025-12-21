<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Set Default Tanggal (Bulan Ini)
        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-d'));

        // 2. Query Data
        // Kita hanya ambil status yang VALID (bukan batal/menunggu bayar)
        $orders = Order::with(['user', 'toko'])
            ->whereBetween('tgl_pesan', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->whereIn('status', ['sudah_bayar', 'siap_diambil', 'selesai'])
            ->latest()
            ->get();

        // 3. Hitung Total Pendapatan
        $totalRevenue = $orders->sum('total_bayar');

        return view('admin.reports.index', compact('orders', 'startDate', 'endDate', 'totalRevenue'));
    }

    public function print(Request $request)
    {
        // Logika sama persis dengan index, tapi view-nya khusus cetak
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $orders = Order::with(['user', 'toko'])
            ->whereBetween('tgl_pesan', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->whereIn('status', ['sudah_bayar', 'siap_diambil', 'selesai'])
            ->latest()
            ->get();

        $totalRevenue = $orders->sum('total_bayar');

        return view('admin.reports.print', compact('orders', 'startDate', 'endDate', 'totalRevenue'));
    }
}
