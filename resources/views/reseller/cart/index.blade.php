@extends('layouts.reseller')

@section('content')
<style>
    /* Hilangkan panah input number bawaan */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

<div class="container pb-5">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-bold m-0 text-dark"><i class="fas fa-shopping-cart text-warning me-2"></i> Keranjang Belanja</h2>
        <a href="{{ route('catalog.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Lanjut Belanja
        </a>
    </div>

    <div class="row g-4">

        {{-- BAGIAN KIRI: DAFTAR BARANG --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light border-bottom">
                                <tr>
                                    <th class="py-3 ps-4">Produk</th>
                                    <th class="py-3 text-center">Harga</th>
                                    <th class="py-3 text-center" style="width: 180px;">Jumlah (Box)</th>
                                    <th class="py-3 text-end">Subtotal</th>
                                    <th class="py-3 text-center pe-4" width="50">Hapus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @if(session('cart'))
                                    @foreach(session('cart') as $id => $details)
                                        @php $total += $details['price'] * $details['quantity'] @endphp
                                        <tr class="border-bottom" data-id="{{ $id }}">
                                            {{-- Kolom Produk --}}
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-light rounded p-1 me-3 border" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                                        @if(isset($details['image']) && $details['image'])
                                                            <img src="{{ asset('storage/'.$details['image']) }}" class="img-fluid rounded" style="max-height: 100%;">
                                                        @else
                                                            <i class="fas fa-box text-muted"></i>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-bold text-dark">{{ $details['name'] }}</h6>
                                                    </div>
                                                </div>
                                            </td>

                                            {{-- Kolom Harga --}}
                                            <td class="text-center text-muted price-col" data-price="{{ $details['price'] }}">
                                                Rp {{ number_format($details['price'], 0, ',', '.') }}
                                            </td>

                                            {{-- Kolom Quantity --}}
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center align-items-center position-relative">

                                                    {{-- TOMBOL MINUS (HANYA MUNCUL JIKA QTY > 5) --}}
                                                    <button type="button" class="btn btn-sm btn-outline-secondary btn-minus rounded-circle shadow-sm {{ $details['quantity'] <= 5 ? 'd-none' : '' }}"
                                                            style="width: 30px; height: 30px; padding: 0;">
                                                        <i class="fas fa-minus small"></i>
                                                    </button>

                                                    {{-- Input Angka --}}
                                                    <input type="number" value="{{ $details['quantity'] }}" min="5" step="5"
                                                           class="form-control text-center update-cart quantity-input fw-bold mx-2 border-0 bg-light"
                                                           style="width: 60px;" readonly>

                                                    {{-- Tombol Plus --}}
                                                    <button type="button" class="btn btn-sm btn-outline-secondary btn-plus rounded-circle shadow-sm" style="width: 30px; height: 30px; padding: 0;">
                                                        <i class="fas fa-plus small"></i>
                                                    </button>
                                                </div>
                                                <small class="text-muted d-block mt-1" style="font-size: 10px;">Kelipatan 5</small>
                                            </td>

                                            {{-- Kolom Subtotal --}}
                                            <td class="text-end fw-bold text-dark subtotal-col">
                                                Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                            </td>

                                            {{-- Tombol Hapus --}}
                                            <td class="text-center pe-4">
                                                <button class="btn btn-sm btn-light text-danger remove-from-cart rounded-circle shadow-sm" title="Hapus Item">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="py-4">
                                                <i class="fas fa-shopping-basket fa-3x text-muted mb-3 opacity-50"></i>
                                                <h5 class="text-muted fw-bold">Keranjang Belanja Kosong</h5>
                                                <p class="text-muted small mb-4">Yuk, isi keranjangmu dengan produk durian terbaik!</p>
                                                <a href="{{ route('catalog.index') }}" class="btn btn-warning px-4 rounded-pill fw-bold">Mulai Belanja</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- BAGIAN KANAN: RINGKASAN TAGIHAN --}}
        @if(session('cart'))
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="fw-bold mb-0">Ringkasan Pesanan</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-2 text-muted">
                        <span>Total Item</span>
                        <span id="total-items">{{ count(session('cart')) }} Produk</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4 text-muted">
                        <span>Total Qty</span>
                        <span id="total-qty">{{ collect(session('cart'))->sum('quantity') }} Box</span>
                    </div>

                    <hr class="border-light my-3">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="fw-bold text-dark">Total Tagihan</span>
                        <span class="fw-bold text-success fs-4" id="grand-total">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn btn-primary-custom w-100 py-3 rounded-pill fw-bold shadow-sm d-flex justify-content-between align-items-center px-4">
                        <span>Lanjut Checkout</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        // 1. TOMBOL PLUS (+)
        $(".btn-plus").click(function (e) {
            e.preventDefault();
            var input = $(this).siblings(".quantity-input");
            var btnMinus = $(this).siblings(".btn-minus"); // Ambil tombol minus di sebelahnya
            var currentVal = parseInt(input.val());

            // Tambah 5
            var newVal = currentVal + 5;
            input.val(newVal).trigger('change');

            // Munculkan tombol minus karena nilai pasti > 5
            btnMinus.removeClass('d-none');
        });

        // 2. TOMBOL MINUS (-)
        $(".btn-minus").click(function (e) {
            e.preventDefault();
            var input = $(this).siblings(".quantity-input");
            var btnMinus = $(this);
            var currentVal = parseInt(input.val());

            if (currentVal > 5) {
                var newVal = currentVal - 5;
                input.val(newVal).trigger('change');

                // Jika setelah dikurang hasilnya jadi 5, sembunyikan tombol minus
                if(newVal <= 5) {
                    btnMinus.addClass('d-none');
                }
            }
        });

        // 3. FUNGSI UPDATE KE SERVER
        $(".update-cart").change(function (e) {
            e.preventDefault();

            var ele = $(this);
            var row = ele.closest("tr");
            var productId = row.attr("data-id");
            var quantity = parseInt(ele.val());

            // Validasi: Pastikan Angka & Kelipatan 5
            if(isNaN(quantity) || quantity < 5) {
                alert("Minimal pembelian adalah 5 box!");
                window.location.reload();
                return;
            }
            if(quantity % 5 !== 0) {
                alert("Jumlah harus kelipatan 5");
                window.location.reload();
                return;
            }

            // Kirim AJAX ke Server
            $.ajax({
                url: '{{ route('update.cart') }}',
                method: "PATCH",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: productId,
                    quantity: quantity
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        });

        // 4. FUNGSI HAPUS BARANG
        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
            var ele = $(this);
            var row = ele.closest("tr");
            var productId = row.attr("data-id");

            if(confirm("Apakah Anda yakin ingin menghapus produk ini dari keranjang?")) {
                $.ajax({
                    url: '{{ route('remove.from.cart') }}',
                    method: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: productId
                    },
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });

    });
</script>
@endsection
