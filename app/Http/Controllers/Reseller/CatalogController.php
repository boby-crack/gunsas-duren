<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    // 1. Tampilkan Semua Produk di Halaman Depan Reseller
    public function index()
    {
        $products = Product::all();
        return view('reseller.catalog.index', compact('products'));
    }

    // 2. Logika Tambah ke Keranjang (Session)
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Ambil data keranjang saat ini dari session
        $cart = session()->get('cart', []);

        // Jika produk sudah ada di keranjang, tambahkan jumlahnya
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Jika belum ada, masukkan data baru
            $cart[$id] = [
                "name" => $product->nama_produk,
                "quantity" => 1,
                "price" => $product->harga_mitra, // PENTING: Pakai Harga Mitra B2B
                "image" => $product->gambar
            ];
        }

        // Simpan kembali ke session
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produk masuk keranjang!');
    }

    // 3. Tampilkan Halaman Keranjang
    public function cart()
    {
        return view('reseller.cart.index');
    }

    // 4. Hapus Item dari Keranjang
    public function removeCart(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Produk dihapus dari keranjang');
        }
    }
}
