<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class PaymentCallbackController extends Controller
{
    public function receive()
    {
        // 1. Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        try {
            // 2. Ambil Data Notifikasi dari Midtrans
            $notif = new Notification();

            $transaction = $notif->transaction_status;
            $type = $notif->payment_type;
            $order_id = $notif->order_id;
            $fraud = $notif->fraud_status;

            // 3. Cari Order berdasarkan Invoice Code
            // (Ingat: order_id di Midtrans adalah kode_invoice di database kita)
            $order = Order::where('kode_invoice', $order_id)->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            // 4. Logika Update Status
            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $order->update(['status' => 'menunggu_bayar']); // Challenge = mencurigakan
                    } else {
                        $order->update(['status' => 'sudah_bayar']); // Sukses
                    }
                }
            } else if ($transaction == 'settlement') {
                // Settlement = Uang sudah masuk (Paling umum untuk VA/E-Wallet)
                $order->update(['status' => 'sudah_bayar']);

            } else if ($transaction == 'pending') {
                $order->update(['status' => 'menunggu_bayar']);

            } else if ($transaction == 'deny') {
                $order->update(['status' => 'batal']);

            } else if ($transaction == 'expire') {
                $order->update(['status' => 'batal']);

            } else if ($transaction == 'cancel') {
                $order->update(['status' => 'batal']);
            }

            return response()->json(['message' => 'Payment status updated']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
