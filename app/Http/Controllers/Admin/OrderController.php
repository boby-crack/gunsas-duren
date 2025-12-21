<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // 1. Tampilkan Semua Pesanan Masuk
    public function index()
{
    $query = Order::with(['user', 'toko']);

    // LOGIKA FILTER ROLE
    if (auth()->user()->role == 'staff') {
        // Jika yang login staff, filter berdasarkan toko_id dia
        $query->where('toko_id', auth()->user()->toko_id);
    }

    $orders = $query->latest()->get();

    return view('admin.orders.index', compact('orders'));
}

    // 2. Tampilkan Detail Pesanan
   public function show($id)
    {
        $order = Order::with(['orderItems.product', 'user', 'toko'])->findOrFail($id);

        // CEK KEAMANAN
        if (auth()->user()->role == 'staff' && $order->toko_id != auth()->user()->toko_id) {
            abort(403, 'Anda tidak berhak mengakses pesanan toko lain.');
        }

        return view('admin.orders.show', compact('order'));
    }

    // 3. Update Status Pesanan (PENTING)
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Validasi input status
        $request->validate([
            'status' => 'required|in:menunggu_bayar,sudah_bayar,siap_diambil,selesai,batal'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
