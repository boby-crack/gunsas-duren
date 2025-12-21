@extends('layouts.reseller')

@section('content')
<div class="container">
    <h2 class="mb-4 fw-bold">Checkout Pesanan</h2>

    <div class="row">
        <div class="col-md-7">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Informasi Pengambilan</div>
                <div class="card-body">
                    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Lokasi Toko (Pick-up Point)</label>
                            <select name="toko_id" class="form-select" required>
                                <option value="">-- Pilih Cabang Gunsas --</option>
                                @foreach($tokos as $toko)
                                    <option value="{{ $toko->id }}">
                                        {{ $toko->nama_toko }} - {{ $toko->kota }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Pengambilan</label>
                            <input type="date" name="tgl_ambil" class="form-control"
                                   min="{{ $minDate }}" required>
                            <div class="form-text text-danger">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                Sesuai aturan Pre-Order, pengambilan minimal H+3 ({{ \Carbon\Carbon::parse($minDate)->format('d M Y') }}).
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Pemesan</label>
                            <input type="text" class="form-control bg-light" value="{{ Auth::user()->name }}" readonly>
                        </div>

                        <button type="submit" class="btn btn-warning w-100 fw-bold py-2 mt-2">
                            Buat Pesanan & Bayar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow-sm bg-light">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Ringkasan Item</h5>
                    <ul class="list-group list-group-flush mb-3">
                        @php $total = 0; @endphp
                        @foreach(session('cart') as $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                                <div>
                                    <span class="fw-bold">{{ $details['name'] }}</span>
                                    <small class="d-block text-muted">{{ $details['quantity'] }} x Rp {{ number_format($details['price']) }}</small>
                                </div>
                                <span>Rp {{ number_format($details['price'] * $details['quantity']) }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total Bayar</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
