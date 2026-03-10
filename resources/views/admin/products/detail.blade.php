@extends('layouts.admin-template')
@section('content')
<link href="{{ asset('/css/detail.css') }}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700&family=Montserrat:ital,wght@0,500;0,700;1,600;1,700&family=Roboto:wght@100;400;500;700;900&family=Sora:wght@300;400;500;600;700&family=Ubuntu&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/f4cf3b69a5.js" crossorigin="anonymous"></script>
<div class="row">
<div class="container-fluid" style="padding: 15px;">
    <div class="card shadow mb-4">
        <div class="card-header" style="padding: 0px;">
            <h4 style="font-weight: 700;font-size: 30px;">Detail Produk</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4">
                    <img class="img-responsive" src="{{ url($product->image) }}" >
                    <button class="btn btn-secondary" style="margin-top: 50px">
                    <a href="{{ route('product.index') }}" style="text-decoration: none;color:white;"><i class="fa-solid fa-chevron-left" style="margin-right: 4px;"></i>Back</a>
                </button>
                </div>
                <div class="col-sm-8">
                    <div class="desc">
                    <div class="title">
                        <h1>{{ $product->name }}</h1>       
                    </div>
                    <div class="harga">
                        <h2><i class="fa-solid fa-money-bill" style="margin-right: 8px;color: rgb(255, 217, 0);"></i>Harga</h2>
                        <p>Rp. {{ number_format($product->price,0) }}</p>
                        </div>
                    <div class="deskripsi">
                        <h2><i class="fa-solid fa-bars-staggered " style="margin-right: 8px;color: rgb(192, 0, 0);"></i>Deskripsi Produk</h2>
                        <p>{{ $product->description }}</p>
                    </div>
                    <div class="category">
                        <h2><i class="fa-solid fa-grip" style="margin-right: 8px;color: rgb(0, 132, 255);" ></i>Kategori</h2>      
                        <p>{{ $product->category->name }}</p>      
                    </div>
                    <div class="stok">
                    <h2><i class="fa-solid fa-boxes-stacked" style="margin-right: 8px;color: rgb(0, 187, 0);"></i>Stok</h2>
                    <p>{{ $product->stock }} Porsi</p>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection