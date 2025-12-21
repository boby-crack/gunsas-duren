<?php

namespace App\Http\Controllers;

use App\Models\Toko; // Pastikan Model Toko ada (jika belum, buat: php artisan make:model Toko)
use Illuminate\Http\Request;

class TokoController extends Controller
{
    // 1. Tampilkan Daftar Toko
    public function index()
    {
        $tokos = Toko::all();
        return view('admin.tokos.index', compact('tokos'));
    }

    // 2. Form Tambah Toko
    public function create()
    {
        return view('admin.tokos.create');
    }

    // 3. Simpan Data Toko
    public function store(Request $request)
    {
        $request->validate([
            'nama_toko'      => 'required|string|max:255',
            'kota'           => 'required|string|max:100',
            'alamat_lengkap' => 'required|string',
        ]);

        Toko::create([
            'nama_toko'      => $request->nama_toko,
            'kota'           => $request->kota,
            'alamat_lengkap' => $request->alamat_lengkap,
        ]);

        // Redirect menggunakan pola penamaan Anda (tanpa prefix admin.)
        return redirect()->route('admin.tokos.index')->with('success', 'Toko Berhasil Ditambahkan!');
    }

    // ... method index & store sebelumnya ...

    public function edit($id)
    {
        $toko = \App\Models\Toko::findOrFail($id);
        return view('admin.tokos.edit', compact('toko'));
    }

    public function update(Request $request, $id)
    {
        $toko = \App\Models\Toko::findOrFail($id);
        $request->validate(['nama_toko' => 'required', 'kota' => 'required', 'alamat_lengkap' => 'required']);
        $toko->update($request->all());

        return redirect()->route('admin.tokos.index')->with('success', 'Data Toko diupdate');
    }

    public function destroy($id)
{
    $toko = \App\Models\Toko::findOrFail($id);

    // --- LOGIKA PENGECEKAN (VALIDASI) ---
    // Cek apakah toko ini punya relasi ke tabel orders
    if ($toko->orders()->exists()) {
        // Jika ada, batalkan hapus dan kirim pesan error
        return redirect()->back()->with('error', 'Gagal menghapus! Toko ini memiliki riwayat pesanan yang tidak boleh hilang.');
    }
    // ------------------------------------

    $toko->delete();
    return redirect()->route('tokos.index')->with('success', 'Data Toko berhasil dihapus');
}
}
