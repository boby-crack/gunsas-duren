<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Toko;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
 public function downloadInvoice($id)
    {
        // 1. Ambil Data
        $order = Order::with(['orderItems.product', 'toko'])
                      ->where('id', $id)
                      ->where('user_id', auth()->id())
                      ->firstOrFail();

        // 2. Load PDF
        $pdf = Pdf::loadView('cetak', compact('order'));

        // --- SOLUSI AJAIB (Tambahkan Blok Ini) ---
        // Membersihkan output buffer agar file PDF murni tidak tercampur sampah lain
        if (ob_get_length()) {
            ob_end_clean();
        }
        // ------------------------------------------

        // 3. Kembalikan ke Download (Jangan Stream lagi)
        // Pastikan nama file tidak mengandung karakter aneh seperti garis miring '/'
        $namaFile = 'Invoice-' . str_replace('/', '-', $order->kode_invoice) . '.pdf';
        
        return $pdf->download($namaFile);
    }
}
