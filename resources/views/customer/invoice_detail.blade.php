{{-- resources/views/customer/invoice_detail.blade.php --}}
@extends('layouts.frontend')

@section('title', 'Detail Pesanan - Deltizen Corner')

@section('content')
<section class="section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Detail Pesanan</h2>
        <p><span>Informasi</span> <span class="description-title">Pesanan #{{ $order->id ?? '' }}</span></p>
    </div>
    
    <div class="container" style="max-width: 900px;">
        @if(isset($order))
            {{-- Order Status Card --}}
            <div class="card mb-4" data-aos="fade-up">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="d-flex align-items-center gap-3">
                                @php
                                    $statusConfig = match($order->status) {
                                        'belum bayar' => ['warning', 'bi-clock-fill', 'Belum Bayar'],
                                        'menunggu verifikasi' => ['info', 'bi-hourglass-split', 'Menunggu Verifikasi'],
                                        'dibayar' => ['success', 'bi-check-circle-fill', 'Dibayar'],
                                        'ditolak' => ['danger', 'bi-x-circle-fill', 'Ditolak'],
                                        default => ['secondary', 'bi-question-circle-fill', ucwords($order->status)],
                                    };
                                    $deliveryConfig = match($order->detail_status) {
                                        'menunggu konfirmasi pembayaran' => ['secondary', 'bi-hourglass', 'Menunggu Konfirmasi'],
                                        'pesanan sedang disiapkan' => ['warning', 'bi-fire', 'Sedang Disiapkan'],
                                        'pesanan selesai, menunggu konfirmasi penjemputan' => ['info', 'bi-bag-check', 'Siap Diambil'],
                                        'selesai' => ['success', 'bi-check-all', 'Selesai'],
                                        default => ['secondary', 'bi-dash-circle', ucwords($order->detail_status ?? 'Belum diatur')],
                                    };
                                @endphp
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 56px; height: 56px; background: var(--bs-{{ $statusConfig[0] }}-bg-subtle, #f8f9fa);">
                                    <i class="bi {{ $statusConfig[1] }} text-{{ $statusConfig[0] }}" style="font-size: 24px;"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-0 small">Status Pembayaran</p>
                                    <h5 class="mb-0 text-{{ $statusConfig[0] }}">{{ $statusConfig[2] }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 56px; height: 56px; background: var(--bs-{{ $deliveryConfig[0] }}-bg-subtle, #f8f9fa);">
                                    <i class="bi {{ $deliveryConfig[1] }} text-{{ $deliveryConfig[0] }}" style="font-size: 24px;"></i>
                                </div>
                                <div>
                                    <p class="text-muted mb-0 small">Status Pesanan</p>
                                    <h5 class="mb-0 text-{{ $deliveryConfig[0] }}">{{ $deliveryConfig[2] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Order Info --}}
            <div class="card mb-4" data-aos="fade-up" data-aos-delay="50">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="bi bi-person-fill text-primary me-2"></i>Informasi Penerima
                    </h5>
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <p class="text-muted mb-1 small">Nama Penerima</p>
                            <p class="fw-semibold mb-0">{{ $order->receiver ?? '-' }}</p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <p class="text-muted mb-1 small">Tanggal Pesanan</p>
                            <p class="fw-semibold mb-0">{{ \Carbon\Carbon::parse($order->date)->format('d F Y') }}</p>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <p class="text-muted mb-1 small">Nomor Telepon</p>
                            <p class="fw-semibold mb-0">{{ $order->address ?? '-' }}</p>
                        </div>
                        @if($order->catatan)
                            <div class="col-12">
                                <p class="text-muted mb-1 small">Catatan</p>
                                <p class="mb-0 fst-italic">"{{ $order->catatan }}"</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            {{-- Product Items --}}
            <div class="card mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="bi bi-bag-fill me-2" style="color: var(--dc-accent);"></i>Item Pesanan
                    </h5>
                    
                    @foreach($details as $detail)
                        <div class="d-flex gap-3 mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            {{-- Product Image --}}
                            <div class="flex-shrink-0">
                                <img src="{{ url($detail->image) }}" 
                                     alt="{{ $detail->name }}" 
                                     class="rounded-3"
                                     style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                            
                            {{-- Product Info --}}
                            <div class="flex-grow-1">
                                <h6 class="fw-semibold mb-1">{{ $detail->name }}</h6>
                                <p class="text-muted mb-2 small">
                                    {{ formatRupiah($detail->price ?? 0) }} × {{ $detail->pivot->quantity ?? 1 }}
                                </p>
                                <span class="badge bg-secondary-subtle text-secondary">{{ $detail->category->name ?? 'Produk' }}</span>
                            </div>
                            
                            {{-- Subtotal --}}
                            <div class="text-end flex-shrink-0">
                                <p class="fw-bold mb-0" style="color: var(--dc-accent);">
                                    {{ formatRupiah($detail->pivot->subtotal ?? 0) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                    
                    {{-- Total --}}
                    <div class="border-top pt-3 mt-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">Total Pembayaran</span>
                            <span class="h4 mb-0 fw-bold" style="color: var(--dc-accent);">
                                {{ formatRupiah($order->total_price ?? $details->sum(fn($d) => $d->pivot->subtotal ?? 0)) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Action Buttons --}}
            <div class="d-flex flex-wrap gap-3 justify-content-center" data-aos="fade-up" data-aos-delay="150">
                <a href="{{ route('invoice.list') }}" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
                </a>
                @if($order->status == 'belum bayar')
                    <a href="{{ route('confirm.index', ['id' => $order->id]) }}" class="btn-get-started">
                        <i class="bi bi-credit-card me-2"></i>Bayar Sekarang
                    </a>
                @endif
            </div>
        @else
            {{-- Not Found State --}}
            <div class="card text-center py-5" data-aos="fade-up">
                <div class="card-body">
                    <i class="bi bi-exclamation-triangle" style="font-size: 72px; color: var(--dc-text-light);"></i>
                    <h4 class="mt-4">Pesanan Tidak Ditemukan</h4>
                    <p class="text-muted mb-4">Maaf, pesanan yang Anda cari tidak ditemukan.</p>
                    <a href="{{ route('invoice.list') }}" class="btn-get-started">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection