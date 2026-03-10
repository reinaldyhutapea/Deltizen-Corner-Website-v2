{{-- resources/views/front/cart.blade.php --}}
@extends('layouts.frontend')

@php
$user = currentCustomer();
@endphp

@section('title', 'Keranjang - Deltizen Corner')

@section('content')
<section id="cart" class="menu section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Keranjang Belanja</h2>
        <p><span>Detail</span> <span class="description-title">Pesanan Anda</span></p>
    </div>
    
    <div class="container">
        @if($cartItems->isEmpty())
            {{-- Empty Cart State --}}
            <div class="card text-center py-5" data-aos="fade-up">
                <div class="card-body">
                    <i class="bi bi-cart-x" style="font-size: 72px; color: var(--dc-text-light);"></i>
                    <h4 class="mt-4">Keranjang Anda Kosong</h4>
                    <p class="text-muted mb-4">Belum ada item di keranjang. Yuk, mulai belanja!</p>
                    <a href="/menu" class="btn-get-started">
                        <i class="bi bi-grid me-2"></i>Lihat Menu
                    </a>
                </div>
            </div>
        @else
            {{-- Cart Items --}}
            <div class="card" data-aos="fade-up">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background: var(--dc-bg-light);">
                                <tr>
                                    <th class="py-3 ps-4" style="width: 100px;">Gambar</th>
                                    <th class="py-3">Produk</th>
                                    <th class="py-3 text-center">Harga</th>
                                    <th class="py-3 text-center" style="width: 150px;">Jumlah</th>
                                    <th class="py-3 text-center" style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $item)
                                    <tr>
                                        <td class="align-middle ps-4">
                                            <img src="{{ $item->attributes->image ?? asset('default-image.jpg') }}" 
                                                 class="rounded" 
                                                 alt="{{ $item->name }}" 
                                                 style="width: 70px; height: 70px; object-fit: cover;">
                                        </td>
                                        <td class="align-middle">
                                            <h6 class="mb-1 fw-semibold">{{ $item->name }}</h6>
                                            <small class="text-muted">{{ formatRupiah($item->price) }} / item</small>
                                        </td>
                                        <td class="align-middle text-center fw-semibold" style="color: var(--dc-accent);">
                                            {{ formatRupiah($item->price * $item->quantity) }}
                                        </td>
                                        <td class="align-middle">
                                            <form action="{{ route('cart.update') }}" method="POST" class="d-flex justify-content-center gap-2">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <input type="number" name="quantity" 
                                                       min="1" max="100" 
                                                       value="{{ $item->quantity }}" 
                                                       class="form-control text-center" 
                                                       style="width: 60px;">
                                                <button type="submit" class="btn btn-sm" 
                                                        style="background: var(--dc-primary); color: white;" 
                                                        title="Perbarui jumlah">
                                                    <i class="bi bi-arrow-repeat"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="align-middle text-center">
                                            <form action="{{ route('cart.remove') }}" method="POST" class="cart-remove-form">
                                                @csrf
                                                <input type="hidden" value="{{ $item->id }}" name="id">
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                        data-item-name="{{ $item->name }}"
                                                        title="Hapus {{ $item->name }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            {{-- Cart Summary --}}
            <div class="row mt-4" data-aos="fade-up" data-aos-delay="100">
                <div class="col-lg-6">
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="/menu" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Lanjut Belanja
                        </a>
                        <form action="{{ route('cart.clear') }}" method="POST" class="cart-clear-form">
                            @csrf
                            <button type="button" class="btn btn-outline-danger">
                                <i class="bi bi-trash me-1"></i> Kosongkan Keranjang
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card" style="background: var(--dc-bg-light);">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Subtotal ({{ $cartItems->count() }} item)</span>
                                <span class="fw-semibold">{{ formatRupiah(Cart::getTotal()) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="fw-bold fs-5">Total</span>
                                <span class="fw-bold fs-4" style="color: var(--dc-accent);">{{ formatRupiah(Cart::getTotal()) }}</span>
                            </div>
                            @if($user)
                                <form action="{{ route('cart.checkout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-get-started w-100">
                                        <i class="bi bi-bag-check me-1"></i> Checkout Sekarang
                                    </button>
                                </form>
                            @else
                                <button type="button" id="checkoutBtn" class="btn-get-started w-100">
                                    <i class="bi bi-bag-check me-1"></i> Checkout Sekarang
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

{{-- Checkout Modal for Guest --}}
@unless($user)
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="checkoutModalLabel">
                    <i class="bi bi-person-check me-2"></i>Lanjutkan Checkout
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center pb-4">
                <p class="text-muted mb-4">Pilih cara untuk melanjutkan pesanan Anda</p>
                <div class="d-grid gap-3">
                    <a href="{{ route('login') }}" class="btn-get-started">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login ke Akun
                    </a>
                    <a href="{{ route('cart.checkout') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="bi bi-person me-2"></i>Lanjutkan sebagai Tamu
                    </a>
                </div>
                <p class="text-muted mt-4 mb-0 small">
                    Belum punya akun? <a href="{{ route('register') }}" style="color: var(--dc-accent);">Daftar sekarang</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endunless

{{-- Confirm Remove Modal --}}
<div class="modal fade" id="confirmRemoveModal" tabindex="-1" aria-labelledby="confirmRemoveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="confirmRemoveModalLabel">
                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="bi bi-trash" style="font-size: 48px; color: var(--dc-danger);"></i>
                <p id="confirmRemoveMessage" class="mt-3 mb-0"></p>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x me-1"></i>Batal
                </button>
                <button type="button" id="confirmRemoveBtn" class="btn btn-danger">
                    <i class="bi bi-trash me-1"></i>Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Checkout Modal for Guest
    const checkoutBtn = document.getElementById('checkoutBtn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function() {
            new bootstrap.Modal(document.getElementById('checkoutModal')).show();
        });
    }

    // Confirm Remove Modal
    const removeButtons = document.querySelectorAll('.cart-remove-form button');
    const confirmRemoveModal = document.getElementById('confirmRemoveModal');
    const confirmRemoveMessage = document.getElementById('confirmRemoveMessage');
    const confirmRemoveBtn = document.getElementById('confirmRemoveBtn');
    let activeForm = null;

    removeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            activeForm = this.closest('form');
            const itemName = this.getAttribute('data-item-name') || 'item ini';
            confirmRemoveMessage.textContent = `Apakah Anda yakin ingin menghapus "${itemName}" dari keranjang?`;
            new bootstrap.Modal(confirmRemoveModal).show();
        });
    });

    if (confirmRemoveBtn) {
        confirmRemoveBtn.addEventListener('click', function() {
            if (activeForm) {
                activeForm.submit();
            }
            bootstrap.Modal.getInstance(confirmRemoveModal)?.hide();
        });
    }

    // Clear Cart Confirmation
    const clearForm = document.querySelector('.cart-clear-form');
    if (clearForm) {
        const clearBtn = clearForm.querySelector('button');
        clearBtn.addEventListener('click', function(e) {
            e.preventDefault();
            activeForm = clearForm;
            confirmRemoveMessage.textContent = 'Apakah Anda yakin ingin mengosongkan semua item dari keranjang?';
            new bootstrap.Modal(confirmRemoveModal).show();
        });
    }
});
</script>
@endpush