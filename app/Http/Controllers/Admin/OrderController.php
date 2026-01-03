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

    // Update pada method update di OrderController
      public function update(Request $request, $id)
            {
                $order = Order::findOrFail($id);

    // 1. CEK JIKA STATUS SUDAH FINAL
            if (in_array($order->status, ['selesai', 'batal'])) {
                return redirect()->back()->with('error', 'Pesanan yang sudah selesai atau batal tidak dapat diubah lagi.');
            }

            $request->validate([
                'status' => 'required|in:sudah_bayar,siap_diambil,selesai,batal'
            ]);

            // 2. LOGIKA TAMBAHAN UNTUK STAFF
            if (auth()->user()->role == 'staff') {
                if ($order->status !== 'siap_diambil' || $request->status !== 'selesai') {
                    return redirect()->back()->with('error', 'Staff hanya boleh menyelesaikan pesanan yang berstatus Siap Diambil.');
                }
            }

            $order->update([
                'status' => $request->status
            ]);

            return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
        }
}
