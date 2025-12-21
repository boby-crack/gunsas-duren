@extends('layouts.reseller')

@section('content')
<h2 class="mb-4 fw-bold">Keranjang Belanja</h2>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th>Harga Mitra</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @if(session('cart'))
                            @foreach(session('cart') as $id => $details)
                                @php $total += $details['price'] * $details['quantity'] @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($details['image'])
                                                <img src="{{ asset('storage/'.$details['image']) }}" width="50" class="rounded me-2">
                                            @endif
                                            <span class="fw-bold">{{ $details['name'] }}</span>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                                    <td>{{ $details['quantity'] }}</td>
                                    <td>Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger remove-from-cart" data-id="{{ $id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center py-4">Keranjang masih kosong.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 bg-white">
            <div class="card-header bg-dark text-white">Ringkasan Pesanan</div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <span>Total Tagihan</span>
                    <span class="fw-bold fs-5">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <hr>
                <small class="text-muted d-block mb-3">* Belum termasuk pemilihan lokasi ambil.</small>

                @if(session('cart'))
                    <a href="{{ route('checkout.index') }}" class="btn btn-warning w-100 fw-bold py-2">
                        Lanjut Checkout <i class="fa-solid fa-arrow-right ms-2"></i>
                    </a>
                @endif

                <a href="{{ route('catalog.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                    Kembali Belanja
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(".remove-from-cart").click(function (e) {
        e.preventDefault();
        var ele = $(this);
        if(confirm("Yakin ingin menghapus produk ini?")) {
            $.ajax({
                url: '{{ route('remove.from.cart') }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: ele.attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });
</script>
@endsection
