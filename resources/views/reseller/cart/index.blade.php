@extends('layouts.reseller')

@section('title', 'Keranjang Belanja - Gunsas Duren')

@section('content')
<style>
    /* Styling Khusus Halaman Keranjang */
    .cart-box { background: white; border-radius: 20px; border: 1px solid #ECEFF1; overflow: hidden; }
    .cart-head { background: #FFF9C4; } /* Warna emas muda khas Gunsas */
    .cart-head th { border: none; padding: 20px; font-weight: 700; color: #1B1B1B; font-size: 0.9rem; text-transform: uppercase; }
    
    .cart-row:hover { background-color: #FAFAFA; }
    .cart-thumb { width: 70px; height: 70px; border-radius: 12px; object-fit: cover; border: 1px solid #eee; }
    .cart-prod-name { font-weight: 700; color: #1B1B1B; margin-bottom: 2px; }
    
    /* Control Quantity */
    .qty-control { background: #F5F5F5; border-radius: 50px; padding: 5px; display: inline-flex; align-items: center; }
    .btn-qty { width: 32px; height: 32px; border-radius: 50% !important; background: white !important; border: none !important; box-shadow: 0 2px 5px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: center; transition: 0.3s; }
    .btn-qty:hover { background: #1B1B1B !important; color: white !important; }
    .qty-input-box { width: 50px; border: none !important; background: transparent !important; font-weight: 800; text-align: center; color: #1B1B1B; }

    /* Summary Card */
    .summary-card { background: white; border-radius: 20px; padding: 30px; border: 1px solid #ECEFF1; box-shadow: 0 10px 30px rgba(0,0,0,0.02); }
    .summary-title { font-weight: 800; color: #1B1B1B; margin-bottom: 20px; }
    .summary-line { display: flex; justify-content: space-between; margin-bottom: 12px; color: #546E7A; font-weight: 500; }
    .summary-total { color: #388E3C; font-weight: 800; font-size: 1.5rem; }
    
    /* Button Premium */
    .btn-checkout-premium { background: #388E3C; color: white; border: none; width: 100%; padding: 16px; border-radius: 50px; font-weight: 700; text-decoration: none; transition: 0.3s; display: flex; justify-content: space-between; align-items: center; }
    .btn-checkout-premium:hover { background: #2E7D32; color: white; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(56, 142, 60, 0.2); }

    /* Hilangkan panah input number */
    input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
    input[type=number] { -moz-appearance: textfield; }
</style>

<div class="container">
    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-5">
        <div>
            <span class="text-uppercase fw-bold text-warning ls-1 small">Proses Pesanan</span>
            <h2 class="fw-bold m-0 text-dark">Keranjang Belanja</h2>
        </div>
        <a href="{{ route('catalog.index') }}" class="btn btn-outline-dark rounded-pill px-4 fw-bold">
            <i class="fas fa-arrow-left me-2"></i> Lanjut Belanja
        </a>
    </div>

    <div class="row g-4">
        {{-- DAFTAR BARANG --}}
        <div class="col-lg-8">
            <div class="cart-box shadow-sm">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="cart-head">
                            <tr>
                                <th class="ps-4">Produk</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center" style="width: 200px;">Jumlah</th>
                                <th class="text-end">Subtotal</th>
                                <th class="text-center pe-4" width="80">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @if(session('cart'))
                                @foreach(session('cart') as $id => $details)
                                    @php $total += $details['price'] * $details['quantity'] @endphp
                                    <tr class="cart-row border-bottom" data-id="{{ $id }}">
                                        <td class="ps-4 py-4">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3 position-relative">
                                                    @if(isset($details['image']) && $details['image'])
                                                        <img src="{{ asset('storage/'.$details['image']) }}" class="cart-thumb">
                                                    @else
                                                        <div class="cart-thumb bg-light d-flex align-items-center justify-content-center">
                                                            <i class="fas fa-box text-muted"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h6 class="cart-prod-name">{{ $details['name'] }}</h6>
                                                    <span class="badge bg-light text-dark border-0 small fw-bold">Mitra Area</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center fw-bold text-muted price-col" data-price="{{ $details['price'] }}">
                                            Rp {{ number_format($details['price'], 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <div class="qty-control">
                                                {{-- TOMBOL MINUS --}}
                                                <button type="button" class="btn-qty btn-minus {{ $details['quantity'] <= 5 ? 'd-none' : '' }}">
                                                    <i class="fas fa-minus fs-xs"></i>
                                                </button>
                                                
                                                <input type="number" value="{{ $details['quantity'] }}" min="5" step="5"
                                                       class="qty-input-box update-cart quantity-input" readonly>

                                                {{-- TOMBOL PLUS --}}
                                                <button type="button" class="btn-qty btn-plus">
                                                    <i class="fas fa-plus fs-xs"></i>
                                                </button>
                                            </div>
                                            <div class="small text-muted mt-2 fw-bold" style="font-size: 10px; opacity: 0.6;">MIN. 5 BOX</div>
                                        </td>
                                        <td class="text-end fw-bold text-dark subtotal-col" style="font-size: 1.1rem;">
                                            Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                        </td>
                                        <td class="text-center pe-4">
                                            <button class="btn btn-sm btn-light text-danger remove-from-cart rounded-circle shadow-sm p-2" title="Hapus Item">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="py-5">
                                            <img src="https://cdn-icons-png.flaticon.com/512/11329/11329060.png" width="100" class="mb-4 opacity-25">
                                            <h4 class="text-muted fw-bold">Wah, Keranjangmu Kosong!</h4>
                                            <p class="text-muted mb-4">Yuk, pilih produk durian favoritmu sekarang.</p>
                                            <a href="{{ route('catalog.index') }}" class="btn btn-dark px-5 py-3 rounded-pill fw-bold">Mulai Belanja</a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- RINGKASAN TAGIHAN --}}
        @if(session('cart'))
        <div class="col-lg-4">
            <div class="summary-card shadow-sm">
                <h5 class="summary-title">Ringkasan Pesanan</h5>
                
                <div class="summary-line">
                    <span>Total Jenis Produk</span>
                    <span class="text-dark fw-bold" id="total-items">{{ count(session('cart')) }} Produk</span>
                </div>
                <div class="summary-line">
                    <span>Total Kuantitas</span>
                    <span class="text-dark fw-bold" id="total-qty">{{ collect(session('cart'))->sum('quantity') }} Box</span>
                </div>
                <div class="summary-line mb-4">
                    <span>Metode Pengambilan</span>
                    <span class="badge bg-success-subtle text-success fw-bold">Pickup Outlet</span>
                </div>

                <hr class="border-light my-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="fw-bold text-dark fs-5">Total Bayar</span>
                    <span class="summary-total" id="grand-total">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <a href="{{ route('checkout.index') }}" class="btn-checkout-premium px-4">
                    <span>Checkout Sekarang</span>
                    <i class="fas fa-chevron-right"></i>
                </a>

                <p class="text-center text-muted small mt-4">
                    <i class="fas fa-shield-alt me-1"></i> Transaksi Aman & Terjamin
                </p>
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
        // Logika JavaScript Anda tetap sama
        $(".btn-plus").click(function (e) {
            e.preventDefault();
            var input = $(this).siblings(".quantity-input");
            var btnMinus = $(this).siblings(".btn-minus");
            var currentVal = parseInt(input.val());
            var newVal = currentVal + 5;
            input.val(newVal).trigger('change');
            btnMinus.removeClass('d-none');
        });

        $(".btn-minus").click(function (e) {
            e.preventDefault();
            var input = $(this).siblings(".quantity-input");
            var btnMinus = $(this);
            var currentVal = parseInt(input.val());
            if (currentVal > 5) {
                var newVal = currentVal - 5;
                input.val(newVal).trigger('change');
                if(newVal <= 5) {
                    btnMinus.addClass('d-none');
                }
            }
        });

        $(".update-cart").change(function (e) {
            e.preventDefault();
            var ele = $(this);
            var row = ele.closest("tr");
            var productId = row.attr("data-id");
            var quantity = parseInt(ele.val());

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

            row.find('.subtotal-col').html('<i class="fas fa-spinner fa-spin"></i>');

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
                },
               error: function (xhr) {
                    alert("Gagal memperbarui keranjang. Silakan coba lagi.");
                    window.location.reload();
                }
            });
        });

        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
            var ele = $(this);
            var row = ele.closest("tr");
            var productId = row.attr("data-id");

            if(confirm("Hapus produk ini dari keranjang?")) {
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