@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4" style="max-width: 600px;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit User: {{ $user->name }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email Login</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                </div>

                <div class="alert alert-info py-2 small">
                    <i class="fa-solid fa-info-circle"></i> Kosongkan password jika tidak ingin menggantinya.
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Baru (Opsional)</label>
                    <input type="password" name="password" class="form-control" minlength="8">
                </div>
                <div class="mb-3">
                    <label class="form-label">Role (Hak Akses)</label>
                    <select name="role" id="roleSelect" class="form-select" required>
                        <option value="" selected disabled>-- Pilih Role --</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin (Full Akses)</option>
                        <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff Toko / Kepala Cabang</option>

                        </select>
                </div>
              <div class="mb-3" id="tokoDiv" style="display: none;">
                <label class="form-label">Penempatan Toko <span class="text-danger">*</span></label>
                <select name="toko_id" class="form-select">
                    <option value="">-- Pilih Cabang --</option>
                    @foreach($tokos as $toko)
                        <option value="{{ $toko->id }}"
                            {{-- LOGIKA: Jika ID Toko sama dengan Toko User saat ini, tambahkan attribute 'selected' --}}
                            {{ $user->toko_id == $toko->id ? 'selected' : '' }}>

                            {{ $toko->nama_toko }} - {{ $toko->kota }}
                        </option>
                    @endforeach
                </select>
                <small class="text-muted">Wajib dipilih jika role adalah Staff Toko.</small>
            </div>

                <button type="submit" class="btn btn-primary">Update User</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
