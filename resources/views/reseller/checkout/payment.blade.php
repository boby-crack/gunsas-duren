@extends('layouts.reseller')

@section('content')
<script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<div class="container py-5 text-center">
    <div class="card shadow mx-auto" style="max-width: 600px;">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0"><i class="fa-solid fa-check-circle"></i> Pesanan Berhasil Dibuat!</h4>
        </div>
        <div class="card-body p-5">
            <h5 class="text-muted mb-4">Kode Invoice: <strong>{{ $order->kode_invoice }}</strong></h5>

            <h1 class="display-4 fw-bold text-success mb-4">
                Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
            </h1>

            <p class="lead mb-4">
                Silakan selesaikan pembayaran agar pesanan Anda segera diproses oleh
                <strong>{{ $order->toko->nama_toko }}</strong>.
            </p>

            <button id="pay-button" class="btn btn-primary btn-lg w-100 rounded-pill shadow">
                <i class="fa-solid fa-credit-card me-2"></i> BAYAR SEKARANG
            </button>

            <div class="mt-3">
                <a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">Bayar nanti (Masuk ke Riwayat)</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
        window.snap.pay('{{ $order->snap_token }}', {
            onSuccess: function(result){
                /* Jika sukses, redirect ke halaman sukses atau dashboard */
                alert("Pembayaran Berhasil!");
                window.location.href = "{{ route('dashboard') }}";
            },
            onPending: function(result){
                /* Jika pending (misal: menunggu transfer VA) */
                alert("Menunggu Pembayaran Anda!");
                window.location.href = "{{ route('dashboard') }}";
            },
            onError: function(result){
                /* Jika gagal */
                alert("Pembayaran Gagal!");
                window.location.href = "{{ route('dashboard') }}";
            },
            onClose: function(){
                /* Jika popup ditutup tanpa bayar */
                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    });
</script>
@endsection
