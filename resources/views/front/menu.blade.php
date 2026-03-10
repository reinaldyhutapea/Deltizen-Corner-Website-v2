{{-- resources/views/front/menu.blade.php --}}
@extends('layouts.frontend')

@section('title', 'Menu - Deltizen Corner')

@section('content')
<section id="menu" class="menu section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Menu Kami</h2>
        <p><span>Pilih</span> <span class="description-title">Hidangan Favorit Anda</span></p>
    </div>
    
    <div class="container">
        {{-- Category Filter Tabs --}}
        <ul class="nav nav-tabs d-flex justify-content-center flex-wrap" data-aos="fade-up" data-aos-delay="100">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('menu') ? 'active show' : '' }}" href="/menu">
                    <i class="bi bi-grid-3x3-gap me-1"></i>
                    <h4>Semua</h4>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('menu/promo') ? 'active show' : '' }}" href="/menu/promo">
                    <i class="bi bi-tag me-1"></i>
                    <h4>Promo</h4>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('menu/minuman') ? 'active show' : '' }}" href="/menu/minuman">
                    <i class="bi bi-cup-straw me-1"></i>
                    <h4>Minuman</h4>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('menu/makanan') ? 'active show' : '' }}" href="/menu/makanan">
                    <i class="bi bi-egg-fried me-1"></i>
                    <h4>Makanan</h4>
                </a>
            </li>
        </ul>
        
        {{-- Menu Items Grid --}}
        <div class="row gy-4 mt-4">
            @forelse ($products as $product)
                <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 50 }}">
                    <div class="menu-item">
                        <a href="{{ route('product.detail_front', ['id' => $product->id]) }}" class="glightbox">
                            <img src="{{ url($product->image) }}" class="menu-img" alt="{{ $product->name }}">
                            @if($product->category && $product->category->name === 'Promo')
                                <span class="badge bg-danger position-absolute" style="top: 10px; right: 10px; font-size: 11px;">
                                    <i class="bi bi-lightning-fill"></i> PROMO
                                </span>
                            @endif
                        </a>
                        <h4>{{ $product->name }}</h4>
                        <p class="ingredients">{{ Str::limit($product->description, 80) }}</p>
                        <p class="price">{{ formatRupiah($product->price) }}</p>
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <input type="hidden" name="image" value="{{ $product->image }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-get-started w-100">
                                <i class="bi bi-cart-plus me-1"></i> Tambah ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 64px; color: var(--dc-text-light);"></i>
                    <h4 class="mt-3 text-muted">Belum Ada Menu</h4>
                    <p class="text-muted">Menu untuk kategori ini belum tersedia.</p>
                    <a href="/menu" class="btn-get-started mt-3">
                        <i class="bi bi-arrow-left me-1"></i> Lihat Semua Menu
                    </a>
                </div>
            @endforelse
        </div>
        
        {{-- Pagination --}}
        @if(method_exists($products, 'hasPages') && $products->hasPages())
            <div class="pagination mt-5 d-flex justify-content-center" data-aos="fade-up">
                {{ $products->links('vendor.pagination.bootstrap-4') }}
            </div>
        @endif
    </div>
</section>
@endsection