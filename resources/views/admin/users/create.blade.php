@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4" style="max-width: 600px;">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah User Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email Login</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required minlength="8">
                </div>
                <div class="mb-3">
                    <label class="form-label">Role (Hak Akses)</label>
                    <select name="role" id="roleSelect" class="form-select" required>
                        <option value="" selected disabled>-- Pilih Role --</option>
                        <option value="admin">Admin (Full Akses)</option>
                        <option value="staff">Staff Toko / Kepala Cabang</option>

                        </select>
                </div>

                <div class="mb-3" id="tokoDiv" style="display: none;">
                    <label class="form-label">Penempatan Toko <span class="text-danger">*</span></label>
                    <select name="toko_id" class="form-select">
                        <option value="">-- Pilih Cabang --</option>
                        @foreach($tokos as $toko)
                            <option value="{{ $toko->id }}">{{ $toko->nama_toko }} - {{ $toko->kota }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Wajib dipilih jika role adalah Staff Toko.</small>
                </div>
                <button type="submit" class="btn btn-primary">Simpan User</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection

