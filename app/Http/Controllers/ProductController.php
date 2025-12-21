<?php

namespace App\Http\Controllers;

use App\Models\Product; // Pastikan Model dipanggil
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // 1. Tampilkan Daftar Produk
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    // 2. Tampilkan Form Tambah Produk
    public function create()
    {
        return view('admin.products.create');
    }

    // 3. Proses Simpan ke Database
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga_mitra' => 'required|numeric',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        // Upload Gambar (Jika ada)
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            // Simpan ke folder 'storage/app/public/products'
            $gambarPath = $request->file('gambar')->store('products', 'public');
        }

        // Simpan Data
        Product::create([
            'nama_produk' => $request->nama_produk,
            'deskripsi'   => $request->deskripsi,
            'harga_mitra' => $request->harga_mitra,
            'gambar'      => $gambarPath,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk Berhasil Ditambahkan!');
    }
    // ... method store sebelumnya ...

    // 1. Tampilkan Form Edit
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    // 2. Proses Update Data
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required',
            'harga_mitra' => 'required|numeric',
            'gambar'      => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        // Cek jika ada upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($product->gambar && \Storage::disk('public')->exists($product->gambar)) {
                \Storage::disk('public')->delete($product->gambar);
            }
            // Simpan gambar baru
            $data['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diupdate!');
    }

    // 3. Proses Hapus Data
   public function destroy($id)
{
    $product = Product::findOrFail($id);

    // --- 1. CEK KEAMANAN DATA ---
    // Cek apakah produk ini ada di tabel order_items (pernah dibeli orang)
    if ($product->orderItems()->exists()) {
        return redirect()->back()->with('error', 'Gagal menghapus! Produk ini sudah pernah terjual dalam transaksi.');
    }
    // ----------------------------

    // --- 2. HAPUS GAMBAR DARI FOLDER (Bersih-bersih) ---
    if ($product->gambar && \Storage::disk('public')->exists($product->gambar)) {
        \Storage::disk('public')->delete($product->gambar);
    }

    // --- 3. HAPUS DATA DARI DATABASE ---
    $product->delete();

    return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
}
}
