{{-- resources/views/front/pembayaran.blade.php --}}
@extends('layouts.frontend')

@section('title', 'Pembayaran - Deltizen Corner')

@section('content')
<section class="section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Pembayaran</h2>
        <p><span>Pilih</span> <span class="description-title">Metode Pembayaran</span></p>
    </div>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                {{-- Order Summary Card --}}
                <div class="card mb-4" data-aos="fade-up">
                    <div class="card-header" style="background: var(--dc-primary); color: white;">
                        <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Ringkasan Pesanan #{{ $order->id }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Penerima:</strong> {{ $order->receiver }}</p>
                                <p class="mb-2"><strong>Telepon:</strong> {{ $order->address }}</p>
                                <p class="mb-0"><strong>Waktu Penjemputan:</strong> {{ $order->pickup_time }}</p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <p class="mb-2 text-muted">Total Pembayaran</p>
                                <h3 class="fw-bold" style="color: var(--dc-accent);">{{ formatRupiah($order->total_price) }}</h3>
                            </div>
                        </div>
                        @if($order->catatan && $order->catatan !== 'Tidak Ada Catatan')
                            <hr>
                            <p class="mb-0 text-muted"><i class="bi bi-chat-text me-2"></i>{{ $order->catatan }}</p>
                        @endif
                    </div>
                </div>
                
                {{-- Payment Method Selection --}}
                <div class="card" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4 text-center">Pilih Metode Pembayaran</h5>
                        
                        {{-- Payment Tabs --}}
                        <div class="d-flex justify-content-center gap-3 mb-4">
                            <button id="qrisBtn" class="btn btn-lg px-4 py-3 active" 
                                    style="background: var(--dc-accent); color: white; border-radius: var(--dc-radius);">
                                <i class="bi bi-qr-code-scan me-2" style="font-size: 24px;"></i>
                                <span class="d-block">QRIS</span>
                            </button>
                            <button id="cashBtn" class="btn btn-lg btn-outline-secondary px-4 py-3"
                                    style="border-radius: var(--dc-radius);">
                                <i class="bi bi-cash-coin me-2" style="font-size: 24px;"></i>
                                <span class="d-block">Tunai</span>
                            </button>
                        </div>
                        
                        {{-- Payment Content --}}
                        <div id="paymentContent" class="text-center p-5 rounded-3" style="background: var(--dc-bg-light);">
                            <div id="qrisContent">
                                <p class="text-muted mb-3">Scan kode QRIS berikut untuk melakukan pembayaran:</p>
                                <div class="p-3 bg-white d-inline-block rounded-3 shadow-sm mb-3">
                                    <img src="{{ asset('barcode Qris.png') }}" alt="QRIS Code" class="img-fluid" style="max-height: 200px;">
                                </div>
                                <p class="small text-muted mb-0">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Setelah pembayaran, lanjutkan untuk upload bukti transfer
                                </p>
                            </div>
                            <div id="cashContent" style="display: none;">
                                <i class="bi bi-cash-coin" style="font-size: 64px; color: var(--dc-success);"></i>
                                <h5 class="mt-3">Pembayaran Tunai</h5>
                                <p class="text-muted mb-3">Silakan bayar langsung ke kasir saat mengambil pesanan.</p>
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Tunjukkan kode pesanan <strong>#{{ $order->id }}</strong> kepada kasir
                                </div>
                            </div>
                        </div>
                        
                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-between mt-4 flex-wrap gap-2">
                            <a href="{{ route('cart.checkout') }}" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                            <div class="d-flex gap-2">
                                <a href="{{ route('invoice.list') }}" class="btn btn-outline-primary px-4" id="viewOrderBtn">
                                    <i class="bi bi-list-check me-2"></i>Lihat Pesanan
                                </a>
                                <a href="{{ route('confirm.index', ['id' => $order->id]) }}" class="btn-get-started px-4" id="confirmBtn">
                                    Upload Bukti Bayar <i class="bi bi-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Payment Info --}}
                <div class="mt-4 text-center" data-aos="fade-up" data-aos-delay="200">
                    <p class="text-muted small">
                        <i class="bi bi-shield-check me-1"></i>
                        Pembayaran Anda aman dan terenkripsi
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const qrisBtn = document.getElementById('qrisBtn');
    const cashBtn = document.getElementById('cashBtn');
    const qrisContent = document.getElementById('qrisContent');
    const cashContent = document.getElementById('cashContent');
    const confirmBtn = document.getElementById('confirmBtn');
    const viewOrderBtn = document.getElementById('viewOrderBtn');

    qrisBtn.addEventListener('click', function() {
        // Update button styles
        qrisBtn.style.background = 'var(--dc-accent)';
        qrisBtn.style.color = 'white';
        qrisBtn.classList.remove('btn-outline-secondary');
        
        cashBtn.style.background = 'transparent';
        cashBtn.style.color = 'var(--dc-text)';
        cashBtn.classList.add('btn-outline-secondary');
        
        // Show QRIS content
        qrisContent.style.display = 'block';
        cashContent.style.display = 'none';
        
        // Show confirm button for QRIS
        confirmBtn.style.display = 'inline-flex';
    });

    cashBtn.addEventListener('click', function() {
        // Update button styles
        cashBtn.style.background = 'var(--dc-accent)';
        cashBtn.style.color = 'white';
        cashBtn.classList.remove('btn-outline-secondary');
        
        qrisBtn.style.background = 'transparent';
        qrisBtn.style.color = 'var(--dc-text)';
        qrisBtn.classList.add('btn-outline-secondary');
        
        // Show cash content
        qrisContent.style.display = 'none';
        cashContent.style.display = 'block';
        
        // Hide confirm button for cash (they pay at counter)
        confirmBtn.style.display = 'none';
    });
});
</script>
@endpush