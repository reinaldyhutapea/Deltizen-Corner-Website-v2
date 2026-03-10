{{-- resources/views/front/home.blade.php --}}
@extends('layouts.frontend')

@section('title', 'Deltizen Corner - Tempat Nongkrong Santai')

@section('content')
{{-- Hero Section --}}
<section id="hero" class="hero section light-background">
    <div class="container">
        <div class="row gy-4 justify-content-center justify-content-lg-between align-items-center">
            <div class="col-lg-5 order-2 order-lg-1 d-flex flex-column justify-content-center">
                <h1 data-aos="fade-up">
                    Selamat Datang di<br>
                    <span style="color: var(--dc-accent);">Deltizen Corner</span>
                </h1>
                <p data-aos="fade-up" data-aos-delay="100">
                    Nikmati hidangan lezat dan suasana nyaman untuk berkumpul bersama teman dan keluarga. 
                    Tempat nongkrong terbaik di Balige!
                </p>
                <div class="d-flex gap-3 flex-wrap" data-aos="fade-up" data-aos-delay="200">
                    <a href="/menu" class="btn-get-started">
                        <i class="bi bi-bag-plus me-2"></i>Pesan Sekarang
                    </a>
                    <a href="#menu" class="btn-get-started" style="background: var(--dc-primary);">
                        <i class="bi bi-arrow-down me-2"></i>Lihat Menu
                    </a>
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out">
                <img src="{{ asset('gambar9.jpg') }}" class="img-fluid animated" alt="Deltizen Corner - Hidangan Lezat" loading="lazy">
            </div>
        </div>
    </div>
</section>

{{-- Featured Menu Section --}}
<section id="menu" class="menu section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Menu Andalan</h2>
        <p><span>Coba</span> <span class="description-title">Hidangan Favorit Kami</span></p>
    </div>
    
    <div class="container">
        <div class="row gy-4">
            @forelse($products as $product)
                <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                    <div class="menu-item">
                        <a href="{{ route('product.detail_front', ['id' => $product->id]) }}" class="glightbox">
                            <img src="{{ asset($product->image) }}" class="menu-img" alt="{{ $product->name }}">
                        </a>
                        <h4>{{ $product->name }}</h4>
                        <p class="ingredients">{{ Str::limit($product->description, 60) }}</p>
                        <p class="price">{{ formatRupiah($product->price) }}</p>
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <input type="hidden" name="image" value="{{ $product->image }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-get-started w-100">
                                <i class="bi bi-cart-plus me-1"></i> Tambah
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-emoji-frown" style="font-size: 48px; color: var(--dc-text-light);"></i>
                    <p class="mt-3 text-muted">Belum ada menu promo saat ini.</p>
                    <a href="/menu" class="btn-get-started mt-3">Lihat Semua Menu</a>
                </div>
            @endforelse
        </div>
        
        @if($products->hasPages())
            <div class="pagination mt-5 d-flex justify-content-center" data-aos="fade-up">
                {{ $products->links('vendor.pagination.bootstrap-4') }}
            </div>
        @endif
        
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="/menu" class="btn-get-started" style="background: var(--dc-primary);">
                <i class="bi bi-grid me-2"></i>Lihat Semua Menu
            </a>
        </div>
    </div>
</section>

{{-- Why Choose Us Section --}}
<section class="section light-background py-5">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Kenapa Memilih Kami</h2>
            <p><span>Alasan</span> <span class="description-title">Deltizen Corner Istimewa</span></p>
        </div>
        
        <div class="row gy-4 mt-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-star-fill" style="font-size: 48px; color: var(--dc-accent);"></i>
                    </div>
                    <h4>Kualitas Terjamin</h4>
                    <p class="text-muted">Bahan-bahan segar dan berkualitas untuk setiap hidangan yang kami sajikan.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-clock-fill" style="font-size: 48px; color: var(--dc-accent);"></i>
                    </div>
                    <h4>Pelayanan Cepat</h4>
                    <p class="text-muted">Pesanan Anda akan disiapkan dengan cepat tanpa mengurangi kualitas.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-heart-fill" style="font-size: 48px; color: var(--dc-accent);"></i>
                    </div>
                    <h4>Suasana Nyaman</h4>
                    <p class="text-muted">Tempat yang nyaman untuk bersantai dan berkumpul bersama orang tersayang.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection