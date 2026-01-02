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
        // 1. Validasi Input
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat_lengkap'    => 'required|string',
            'kota'      => 'required|string|max:100',
            // Field baru: Boleh kosong (nullable), tapi jika diisi harus berupa URL
            'link_maps' => 'nullable|url',
        ]);

        // 2. Simpan ke Database
        Toko::create([
            'nama_toko' => $request->nama_toko,
            'alamat_lengkap'    => $request->alamat_lengkap,
            'kota'      => $request->kota,
            'link_maps' => $request->link_maps, // <--- Simpan link maps
        ]);

        return redirect()->route('admin.tokos.index')
            ->with('success', 'Cabang toko berhasil ditambahkan');
    }

    // ... method index & store sebelumnya ...

    public function edit($id)
    {
        $toko = \App\Models\Toko::findOrFail($id);
        return view('admin.tokos.edit', compact('toko'));
    }

    public function update(Request $request, $id)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat_lengkap'    => 'required|string',
            'kota'      => 'required|string|max:100',
            'link_maps' => 'nullable|url', // <--- Validasi field baru
        ]);

        $toko = Toko::findOrFail($id);

        // 2. Update Data
        $toko->update([
            'nama_toko' => $request->nama_toko,
            'alamat_lengkap'    => $request->alamat_lengkap,
            'kota'      => $request->kota,
            'link_maps' => $request->link_maps, // <--- Update link maps
        ]);

        return redirect()->route('admin.tokos.index')
            ->with('success', 'Data cabang berhasil diperbarui');
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
