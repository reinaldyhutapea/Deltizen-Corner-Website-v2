@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Pemesanan sebagai Tamu</h2>
    <form method="POST" action="{{ route('order.create') }}">
        @csrf
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nomor Telepon</label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Lokasi Pengantaran</label>
            <input type="text" name="address" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi Pesanan</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Total Harga</label>
            <input type="number" name="total_price" class="form-control" value="{{ session('cart_total', 0) }}" readonly>
        </div>
        <button type="submit" class="btn btn-primary">Lanjutkan ke Pembayaran</button>
    </form>
</div>
@endsection