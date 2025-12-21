@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Data Toko Cabang (Pick-up Point)</h1>
        <a href="{{ route('admin.tokos.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-1"></i> Tambah Toko
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama Toko</th>
                            <th>Kota</th>
                            <th>Alamat Lengkap</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tokos as $toko)
                        <tr>
                            <td><strong>{{ $toko->nama_toko }}</strong></td>
                            <td>{{ $toko->kota }}</td>
                            <td>{{ $toko->alamat_lengkap }}</td>
                            <td>
                                <a href="{{ route('admin.tokos.edit', $toko->id) }}" class="btn btn-sm btn-warning"><i class="fa-solid fa-edit"></i></a>

                                <form action="{{ route('admin.tokos.destroy', $toko->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada data toko.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
