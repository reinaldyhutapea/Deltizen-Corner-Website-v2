{{-- resources/views/customer/checkout.blade.php --}}
@extends('layouts.frontend')

@php
    $user = currentCustomer();
@endphp

@section('title', 'Checkout - Deltizen Corner')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .checkout-card {
        max-width: 700px;
        margin: 0 auto;
    }
    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label {
        color: var(--dc-accent);
    }
    .form-control:focus {
        border-color: var(--dc-accent);
        box-shadow: 0 0 0 0.2rem rgba(230, 126, 34, 0.15);
    }
</style>
@endpush

@section('content')
<section class="section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Checkout</h2>
        <p><span>Lengkapi</span> <span class="description-title">Detail Pesanan Anda</span></p>
    </div>
    
    <div class="container">
        <div class="checkout-card card" data-aos="fade-up">
            <div class="card-body p-4 p-md-5">
                <form id="checkoutForm" method="POST" action="{{ route('cart.bayar') }}" enctype="multipart/form-data">
                    @csrf
                    
                    {{-- Customer Name --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-person me-1"></i>Nama Pemesan
                        </label>
                        <input type="text" 
                               class="form-control form-control-lg @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name"
                               value="{{ old('name', $user ? $user->name : '') }}" 
                               placeholder="Masukkan nama lengkap Anda"
                               @if ($user) readonly style="background-color: var(--dc-bg-light);" @endif
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Phone Number --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-telephone me-1"></i>Nomor Telepon
                        </label>
                        <input type="tel" 
                               class="form-control form-control-lg @error('address') is-invalid @enderror" 
                               id="address" 
                               name="address"
                               placeholder="Contoh: 081234567890" 
                               pattern="\d{8,18}" 
                               minlength="8"
                               maxlength="18" 
                               value="{{ session('address', '') }}"
                               required>
                        <small class="text-muted">Nomor yang dapat dihubungi (8-18 digit)</small>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Pickup Time --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-clock me-1"></i>Waktu Penjemputan
                        </label>
                        <div class="input-group">
                            <input type="text" 
                                   class="form-control form-control-lg @error('pickup_time') is-invalid @enderror" 
                                   id="pickup_time" 
                                   name="pickup_time"
                                   placeholder="Pilih waktu penjemputan" 
                                   value="{{ session('pickup_time', '') }}"
                                   required
                                   readonly>
                            <button type="button" class="btn" id="setNowButton" 
                                    style="background: var(--dc-accent); color: white;">
                                <i class="bi bi-lightning-fill me-1"></i>Segera (+10 menit)
                            </button>
                        </div>
                        <small class="text-muted">Jam operasional: 08:00 - 22:00</small>
                        @error('pickup_time')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Notes --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-chat-text me-1"></i>Catatan (Opsional)
                        </label>
                        <textarea class="form-control" 
                                  name="catatan" 
                                  id="catatan" 
                                  placeholder="Contoh: Pedas level 2, tanpa sayur, dll."
                                  rows="3" 
                                  maxlength="300">{{ session('catatan', '') }}</textarea>
                        <small class="text-muted">Maksimal 300 karakter</small>
                    </div>
                    
                    {{-- Order Summary --}}
                    <div class="p-4 rounded-3 mb-4" style="background: var(--dc-bg-light);">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Total Pembayaran</span>
                            <span class="fs-3 fw-bold" style="color: var(--dc-accent);">
                                {{ formatRupiah(Cart::getTotal()) }}
                            </span>
                        </div>
                    </div>
                    
                    {{-- Action Buttons --}}
                    <div class="d-flex gap-3 justify-content-between flex-wrap">
                        <a href="{{ route('cart.list') }}" class="btn btn-outline-secondary btn-lg px-4">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                        <button type="submit" class="btn-get-started btn-lg px-5" id="submitBtn">
                            Lanjutkan Pembayaran <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Flatpickr datetime picker
    flatpickr("#pickup_time", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: "today",
        time_24hr: true,
        minuteIncrement: 5,
        onOpen: function(selectedDates, dateStr, instance) {
            const now = new Date();
            now.setMinutes(now.getMinutes() + 10);
            instance.set('minDate', now);
        }
    });

    // "Segera" button - set time to now + 10 minutes
    document.getElementById('setNowButton').addEventListener('click', function() {
        const now = new Date();
        now.setMinutes(now.getMinutes() + 10);
        
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const formattedTime = `${year}-${month}-${day} ${hours}:${minutes}`;
        
        document.getElementById('pickup_time').value = formattedTime;
        
        Swal.fire({
            icon: 'success',
            title: 'Waktu Ditetapkan!',
            html: `Pesanan akan siap pada:<br><strong>${formattedTime}</strong>`,
            confirmButtonText: 'OK',
            confirmButtonColor: '#e67e22'
        });
    });

    // Form validation
    document.getElementById('submitBtn').addEventListener('click', function(event) {
        event.preventDefault();
        
        let errors = [];
        
        const name = document.getElementById('name').value.trim();
        if (!name) {
            errors.push('Nama pemesan tidak boleh kosong');
        }
        
        const phone = document.getElementById('address').value.trim();
        if (!/^\d{8,18}$/.test(phone)) {
            errors.push('Nomor telepon harus 8-18 digit angka');
        }
        
        const pickupTime = document.getElementById('pickup_time').value.trim();
        if (!pickupTime) {
            errors.push('Waktu penjemputan harus dipilih');
        }
        
        if (errors.length > 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Lengkapi Data Anda',
                html: errors.map(e => `• ${e}`).join('<br>'),
                confirmButtonText: 'Perbaiki',
                confirmButtonColor: '#e67e22'
            });
        } else {
            document.getElementById('checkoutForm').submit();
        }
    });
});
</script>
@endpush
