<?php

namespace App\Http\Controllers;

use App\Models\Toko; // Pastikan Model Toko ada (jika belum, buat: php artisan make:model Toko)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



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
        'alamat_lengkap'         => 'required|string',
        'kota'           => 'required|string|max:100',
        'link_maps'      => 'nullable|url',
        'gambar'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi Gambar (Max 2MB)
    ]);

    $pathGambar = null;
    if ($request->hasFile('gambar')) {
        // Simpan ke folder 'public/tokos'
        $pathGambar = $request->file('gambar')->store('tokos', 'public');
    }

    Toko::create([
        'nama_toko'      => $request->nama_toko,
        'alamat_lengkap' => $request->alamat_lengkap,
        'kota'           => $request->kota,
        'link_maps'      => $request->link_maps,
        'gambar'         => $pathGambar, // Simpan path gambar
    ]);

    return redirect()->route('admin.tokos.index')->with('success', 'Cabang toko berhasil ditambahkan');
}

    // ... method index & store sebelumnya ...

    public function edit($id)
    {
        $toko = \App\Models\Toko::findOrFail($id);
        return view('admin.tokos.edit', compact('toko'));
    }

    public function update(Request $request, $id)
        {
            $request->validate([
                'nama_toko' => 'required|string|max:255',
                'alamat_lengkap'    => 'required|string',
                'kota'      => 'required|string|max:100',
                'link_maps' => 'nullable|url',
                'gambar'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $toko = Toko::findOrFail($id);
            $data = [
                'nama_toko'      => $request->nama_toko,
                'alamat_lengkap' => $request->alamat_lengkap,
                'kota'           => $request->kota,
                'link_maps'      => $request->link_maps,
            ];

            // Cek apakah user upload gambar baru?
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($toko->gambar && Storage::disk('public')->exists($toko->gambar)) {
                    Storage::disk('public')->delete($toko->gambar);
                }
                // Simpan gambar baru
                $data['gambar'] = $request->file('gambar')->store('tokos', 'public');
            }

            $toko->update($data);

            return redirect()->route('admin.tokos.index')->with('success', 'Data cabang berhasil diperbarui');
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
