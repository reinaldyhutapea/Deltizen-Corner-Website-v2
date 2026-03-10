@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Menu Makanan') }}</div>

                <div class="card-body">
                    <div class="row">
                        @foreach ($menu as $item)
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top" alt="{{ $item->nama }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->nama }}</h5>
                                        <p class="card-text">{{ $item->deskripsi }}</p>
                                        <p class="card-text"><strong>Rp {{ number_format($item->harga, 0, ',', '.') }}</strong></p>
                                        <a href="{{ route('tambah.keranjang', $item->id) }}" class="btn btn-primary">Tambah ke Keranjang</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
