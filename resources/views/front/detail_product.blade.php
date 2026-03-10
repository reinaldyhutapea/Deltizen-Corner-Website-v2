{{-- resources/views/front/detail_product.blade.php --}}
@extends('layouts.frontend')

@section('title', $product->name . ' - Deltizen Corner')

@section('content')
<section id="details" class="section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Detail Produk</h2>
        <p><span>Informasi</span> <span class="description-title">Lengkap Produk</span></p>
    </div>
    
    <div class="container">
        <div class="row gy-4">
            {{-- Product Image --}}
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card overflow-hidden">
                    <img src="{{ url($product->image) }}" 
                         class="img-fluid" 
                         alt="{{ $product->name }}"
                         style="width: 100%; height: 400px; object-fit: cover;">
                    @if($product->category && $product->category->name === 'Promo')
                        <span class="badge bg-danger position-absolute" style="top: 15px; left: 15px; font-size: 14px;">
                            <i class="bi bi-lightning-fill"></i> PROMO
                        </span>
                    @endif
                </div>
            </div>
            
            {{-- Product Details --}}
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100">
                    <div class="card-body p-4">
                        {{-- Breadcrumb --}}
                        <nav aria-label="breadcrumb" class="mb-3">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="/" style="color: var(--dc-accent);">Home</a></li>
                                <li class="breadcrumb-item"><a href="/menu" style="color: var(--dc-accent);">Menu</a></li>
                                <li class="breadcrumb-item active">{{ $product->name }}</li>
                            </ol>
                        </nav>
                        
                        {{-- Category Badge --}}
                        @if($product->category)
                            <span class="badge mb-3" style="background: var(--dc-primary); font-size: 12px;">
                                <i class="bi bi-tag me-1"></i>{{ $product->category->name }}
                            </span>
                        @endif
                        
                        {{-- Product Name --}}
                        <h2 class="fw-bold mb-3">{{ $product->name }}</h2>
                        
                        {{-- Price --}}
                        <div class="mb-4">
                            <span class="fs-2 fw-bold" style="color: var(--dc-accent);">
                                {{ formatRupiah($product->price) }}
                            </span>
                        </div>
                        
                        {{-- Description --}}
                        <div class="mb-4">
                            <h6 class="text-muted mb-2">
                                <i class="bi bi-info-circle me-1"></i>Deskripsi
                            </h6>
                            <p class="mb-0">{{ $product->description ?: 'Tidak ada deskripsi tersedia.' }}</p>
                        </div>
                        
                        {{-- Product Info --}}
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <div class="p-3 rounded-3 text-center" style="background: var(--dc-bg-light);">
                                    <i class="bi bi-box-seam" style="font-size: 24px; color: var(--dc-accent);"></i>
                                    <p class="mb-0 mt-2 text-muted small">Stok Tersedia</p>
                                    <span class="fw-bold">{{ $product->stock }} Porsi</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-3 text-center" style="background: var(--dc-bg-light);">
                                    <i class="bi bi-clock" style="font-size: 24px; color: var(--dc-accent);"></i>
                                    <p class="mb-0 mt-2 text-muted small">Waktu Penjemputan</p>
                                    <span class="fw-bold">{{ $product->pickup_time ?: 'Fleksibel' }}</span>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Add to Cart Form --}}
                        <form action="{{ route('cart.store') }}" method="POST" class="mb-4">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <input type="hidden" name="image" value="{{ $product->image }}">
                            
                            <div class="d-flex gap-2 align-items-center mb-3">
                                <label class="fw-semibold">Jumlah:</label>
                                <input type="number" 
                                       name="quantity" 
                                       value="1" 
                                       min="1" 
                                       max="{{ $product->stock }}"
                                       class="form-control text-center" 
                                       style="width: 80px;">
                            </div>
                            
                            <button type="submit" class="btn-get-started w-100" {{ $product->stock < 1 ? 'disabled' : '' }}>
                                <i class="bi bi-cart-plus me-2"></i>
                                {{ $product->stock < 1 ? 'Stok Habis' : 'Tambah ke Keranjang' }}
                            </button>
                        </form>
                        
                        {{-- Back Button --}}
                        <a href="/menu" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-arrow-left me-2"></i>Kembali ke Menu
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection