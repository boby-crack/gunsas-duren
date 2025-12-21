<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Toko;

class UserController extends Controller
{
    // 1. Tampilkan Daftar User
    public function index()
{
    // HANYA ambil user yang role-nya 'admin' atau 'staff'
    // Reseller tidak akan muncul di sini
    $users = User::whereIn('role', ['admin', 'staff'])->latest()->get();

    // Jika Anda butuh data toko untuk modal tambah user, biarkan baris ini
    $tokos = \App\Models\Toko::all();

    return view('admin.users.index', compact('users', 'tokos'));
}

    // 2. Tampilkan Form Tambah
   public function create()
{
    // Kirim data toko untuk dropdown
    $tokos = Toko::all();
    return view('admin.users.create', compact('tokos'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'role' => 'required|in:admin,reseller,staff', // Tambahkan 'staff'
        // Wajib pilih toko jika role-nya staff
        'toko_id' => 'required_if:role,staff',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        // Jika bukan staff, toko_id otomatis null
        'toko_id' => $request->role == 'staff' ? $request->toko_id : null,
    ]);

    return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
}

public function edit($id)
{
    $user = User::findOrFail($id);
    $tokos = Toko::all(); // Kirim data toko juga
    return view('admin.users.edit', compact('user', 'tokos'));
}

public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        'role' => 'required|in:admin,reseller,staff',
        'toko_id' => 'required_if:role,staff',
    ]);

    $data = [
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
        'toko_id' => $request->role == 'staff' ? $request->toko_id : null,
    ];

    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $user->update($data);

    return redirect()->route('admin.users.index')->with('success', 'Data user diperbarui!');
}
    // 6. Hapus User
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // PROTEKSI: Jangan biarkan admin menghapus dirinya sendiri yang sedang login
        if ($user->id == auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }
}
