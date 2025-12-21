<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Toko;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    // 1. Tampilkan Halaman Form Checkout
    public function index()
    {
        // Cek keranjang kosong
        if (!session('cart') || count(session('cart')) == 0) {
            return redirect()->route('katalog.index')->with('error', 'Keranjang Anda kosong!');
        }

        $tokos = Toko::all(); // Untuk dropdown lokasi

        // Hitung Tanggal Minimal H+3 untuk validasi tampilan
        $minDate = Carbon::now()->addDays(3)->format('Y-m-d');

        return view('reseller.checkout.index', compact('tokos', 'minDate'));
    }

    // 2. PROSES UTAMA: Simpan Order & Minta Token Midtrans
    public function process(Request $request)
    {
        // A. Validasi Input (Aturan Bisnis H+3)
        $request->validate([
            'toko_id' => 'required|exists:tokos,id',
            // Validasi tanggal harus minimal H+3 hari dari sekarang
            'tgl_ambil' => 'required|date|after_or_equal:' . Carbon::now()->addDays(3)->format('Y-m-d'),
        ]);

        // B. Hitung Total Bayar dari Session Cart
        $cart = session('cart');
        $totalBayar = 0;
        foreach($cart as $id => $details) {
            $totalBayar += $details['price'] * $details['quantity'];
        }

        // C. Database Transaction (Agar data konsisten)
        DB::beginTransaction();
        try {
            // 1. Buat Data Order (Header)
            $order = Order::create([
                'kode_invoice' => 'INV-' . time() . '-' . auth()->id(),
                'user_id' => auth()->id(),
                'toko_id' => $request->toko_id,
                'tgl_pesan' => now(),
                'tgl_ambil' => $request->tgl_ambil,
                'total_bayar' => $totalBayar,
                'status' => 'menunggu_bayar',
            ]);

            // 2. Buat Data Order Item (Detail)
            foreach($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'jumlah' => $details['quantity'],
                    'harga_satuan' => $details['price'],
                    'subtotal' => $details['price'] * $details['quantity'],
                ]);
            }

            // D. Konfigurasi Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');

            // E. Siapkan Parameter untuk Midtrans
            $midtransParams = [
                'transaction_details' => [
                    'order_id' => $order->kode_invoice,
                    'gross_amount' => (int) $totalBayar,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    'phone' => auth()->user()->no_hp,
                ],
                // Opsional: Kirim detail item agar muncul di email Midtrans
                // 'item_details' => ... (bisa ditambahkan jika perlu)
            ];

            // F. Minta Snap Token
            $snapToken = Snap::getSnapToken($midtransParams);

            // Simpan Snap Token ke Database
            $order->snap_token = $snapToken;
            $order->save();

            DB::commit();

            // Hapus Keranjang Belanja
            session()->forget('cart');

            // Redirect ke halaman pembayaran
            return redirect()->route('checkout.payment', $order->id);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // 3. Tampilkan Halaman Pembayaran (Pop-up Midtrans)
    public function payment($id)
    {
        $order = Order::with(['toko', 'orderItems.product'])->findOrFail($id);

        // Pastikan hanya pemilik order yang bisa lihat
        if($order->user_id != auth()->id()) {
            abort(403);
        }

        return view('reseller.checkout.payment', compact('order'));
    }
}
