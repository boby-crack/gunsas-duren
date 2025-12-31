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
    
    // 1. Ambil quantity dari URL, default 5 jika tidak ada
    $qty = (int) $request->query('quantity', 5);

    // 2. Validasi Server Side (Jaga-jaga jika user otak-atik URL manual)
   $request->validate([
        'quantity' => ['required', 'integer', 'min:5', function ($attr, $val, $fail) {
            if ($val % 5 !== 0) $fail('Jumlah wajib kelipatan 5.');
        }]
    ]);
    $product = Product::findOrFail($id);
    $qty = (int) $request->quantity;

    // 3. Logic Simpan ke Keranjang (Session)
    $cart = session()->get('cart', []);

    if(isset($cart[$id])) {
        // Jika produk sudah ada, tambahkan qty baru ke qty lama
        $cart[$id]['quantity'] += $qty;
    } else {
        // Jika belum ada, buat baru
        $cart[$id] = [
            "name" => $product->nama_produk,
            "quantity" => $qty,
            "price" => $product->harga_mitra,
            "image" => $product->gambar
        ];
    }

    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Berhasil menambahkan ' . $qty . ' box ke keranjang!');
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
