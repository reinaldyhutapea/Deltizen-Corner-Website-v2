{{-- resources/views/customer/invoice.blade.php --}}
{{-- NOTE: This view appears to be a duplicate of list_invoice.blade.php. Consider consolidating. --}}
@extends('layouts.frontend')

@section('title', 'Ringkasan Pesanan - Deltizen Corner')

@section('content')
<section class="section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Ringkasan Pesanan</h2>
        <p><span>Daftar</span> <span class="description-title">Pesanan Anda</span></p>
    </div>
    
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('warning'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($orders->isEmpty())
            {{-- Empty State --}}
            <div class="card text-center py-5" data-aos="fade-up">
                <div class="card-body">
                    <i class="bi bi-bag-x" style="font-size: 72px; color: var(--dc-text-light);"></i>
                    <h4 class="mt-4">Belum Ada Pesanan</h4>
                    <p class="text-muted mb-4">Anda belum memiliki riwayat pesanan.</p>
                    <a href="/menu" class="btn-get-started">
                        <i class="bi bi-grid me-2"></i>Mulai Pesan
                    </a>
                </div>
            </div>
        @else
            {{-- Orders Table - Desktop --}}
            <div class="d-none d-lg-block">
                <div class="card" data-aos="fade-up">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background: var(--dc-bg-light);">
                                    <tr>
                                        <th class="py-3 ps-4">Kode</th>
                                        <th class="py-3">Penerima</th>
                                        <th class="py-3">Total</th>
                                        <th class="py-3">Tanggal</th>
                                        <th class="py-3 text-center">Status Bayar</th>
                                        <th class="py-3 text-center">Status Pesanan</th>
                                        <th class="py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td class="align-middle ps-4">
                                                <span class="fw-bold">#{{ $order->id }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <strong>{{ $order->receiver ?? '-' }}</strong>
                                                <br><small class="text-muted">{{ $order->address ?? '-' }}</small>
                                            </td>
                                            <td class="align-middle fw-semibold" style="color: var(--dc-accent);">
                                                {{ formatRupiah($order->total_price) }}
                                            </td>
                                            <td class="align-middle text-muted">
                                                {{ \Carbon\Carbon::parse($order->date)->format('d M Y') }}
                                            </td>
                                            <td class="align-middle text-center">
                                                @php
                                                    $statusConfig = match($order->status) {
                                                        'belum bayar' => ['warning', 'bi-clock', 'Belum Bayar'],
                                                        'menunggu verifikasi' => ['info', 'bi-hourglass-split', 'Menunggu Verifikasi'],
                                                        'dibayar' => ['success', 'bi-check-circle', 'Dibayar'],
                                                        'ditolak' => ['danger', 'bi-x-circle', 'Ditolak'],
                                                        default => ['secondary', 'bi-question-circle', ucwords($order->status)],
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $statusConfig[0] }} px-3 py-2">
                                                    <i class="bi {{ $statusConfig[1] }} me-1"></i>{{ $statusConfig[2] }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                @php
                                                    $deliveryConfig = match($order->detail_status) {
                                                        'menunggu konfirmasi pembayaran' => ['secondary', 'Menunggu Konfirmasi'],
                                                        'pesanan sedang disiapkan' => ['warning', 'Sedang Disiapkan'],
                                                        'pesanan selesai, menunggu konfirmasi penjemputan' => ['info', 'Siap Diambil'],
                                                        'selesai' => ['success', 'Selesai'],
                                                        default => ['secondary', ucwords($order->detail_status ?? 'Belum diatur')],
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $deliveryConfig[0] }}-subtle text-{{ $deliveryConfig[0] }} px-3 py-2">
                                                    {{ $deliveryConfig[1] }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('invoice.detail', ['id' => $order->id]) }}" 
                                                       class="btn btn-sm btn-outline-primary" 
                                                       title="Lihat Detail">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    @if($order->status == 'belum bayar')
                                                        <a href="{{ route('confirm.index', ['id' => $order->id]) }}" 
                                                           class="btn btn-sm" 
                                                           style="background: var(--dc-accent); color: white;"
                                                           title="Bayar Sekarang">
                                                            <i class="bi bi-credit-card"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Orders List - Mobile Cards --}}
            <div class="d-lg-none">
                @foreach($orders as $order)
                    <div class="card mb-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <span class="badge bg-dark mb-2">#{{ $order->id }}</span>
                                    <h5 class="mb-1">{{ $order->receiver ?? '-' }}</h5>
                                    <p class="text-muted small mb-0">{{ $order->address ?? '-' }}</p>
                                </div>
                                <div class="text-end">
                                    <p class="fw-bold mb-1" style="color: var(--dc-accent);">{{ formatRupiah($order->total_price) }}</p>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($order->date)->format('d M Y') }}</small>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2 mb-3 flex-wrap">
                                @php
                                    $statusConfig = match($order->status) {
                                        'belum bayar' => ['warning', 'Belum Bayar'],
                                        'menunggu verifikasi' => ['info', 'Menunggu Verifikasi'],
                                        'dibayar' => ['success', 'Dibayar'],
                                        'ditolak' => ['danger', 'Ditolak'],
                                        default => ['secondary', ucwords($order->status)],
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusConfig[0] }}">{{ $statusConfig[1] }}</span>
                                <span class="badge bg-secondary-subtle text-secondary">{{ ucwords($order->detail_status ?? 'Belum diatur') }}</span>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <a href="{{ route('invoice.detail', ['id' => $order->id]) }}" class="btn btn-outline-primary btn-sm flex-grow-1">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                                @if($order->status == 'belum bayar')
                                    <a href="{{ route('confirm.index', ['id' => $order->id]) }}" class="btn btn-sm flex-grow-1" style="background: var(--dc-accent); color: white;">
                                        <i class="bi bi-credit-card me-1"></i>Bayar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        
        {{-- Back to Menu --}}
        <div class="text-center mt-4" data-aos="fade-up">
            <a href="/menu" class="btn btn-outline-secondary">
                <i class="bi bi-grid me-2"></i>Lihat Menu
            </a>
        </div>
    </div>
</section>
@endsection