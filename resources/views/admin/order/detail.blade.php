<!-- resources/views/admin/order/detail.blade.php -->
@extends('layouts.admin-template')
@section('content')
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .content { font-family: sans-serif; }
        .col_a { padding-top: 20px; padding-right: 20px; padding-left: 20px; }
        .col_b { padding-right: 20px; padding-left: 20px; }
        .card { padding: 15px; }
        .btn-print {
            position: fixed;
            right: 20px;
            bottom: 20px;
            background-color: red;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<div class="content">
    <div class="col_a">
        <div class="col-md-12">
            <div class="id_pesanan">
                <a href="{{ route('admin.order.index') }}"
                    style="text-decoration: none;color:rgb(0, 0, 0);float: left;">
                    <i class="fa-solid fa-chevron-left" style="margin-right: 4px;"></i>Kembali
                </a>
            </div>
            <div class="id_pesanan">
                <h6 style="float: right">Id Pesanan : {{ $order->id }}</h6>
            </div>
            <br><br>
            <div class="card shadow mb-4">
                <div class="box">
                    <div class="box-header with-border">
                        <h2>Detail Penerima</h2>
                    </div>
                    <table class="table">
                        <tr style="font-size: larger">
                            <td>Penerima</td>
                            <td>{{ $order->receiver }}</td>
                        </tr>
                        <tr style="font-size: larger">
                            <td>Nomor Telepon</td>
                            <td>{{ $order->address }}</td>
                        </tr>
                        <tr style="font-size: larger">
                            <td>Catatan</td>
                            <td>{{ $order->catatan ?? '-' }}</td>
                        </tr>
                        <tr style="font-size: larger">
                            <td>Status Pengiriman</td>
                            <td>{{ $order->detail_status ?? 'Belum diatur' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col_b">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="box">
                    <div class="box-header with-border">
                        <h2>Detail Produk</h2>
                    </div>
                    <div class="box-body">
                        <table class="table">
                            <tr style="font-size: large;">
                                <th>Gambar Produk</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                            @foreach ($details as $detail)
                                <tr>
                                    <td>
                                        <a href="{{ url($detail->image) }}" target="_blank">
                                            <img src="{{ url($detail->image) }}" width="100px">
                                        </a>
                                    </td>
                                    <td style="font-size: medium">{{ $detail->name }}</td>
                                    <td style="font-size: medium">{{ $detail->price }}</td>
                                    <td style="font-size: medium">{{ $detail->pivot->quantity }}</td>
                                    <td style="font-size: medium">Rp. {{ number_format($detail->pivot->subtotal, 0) }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button class="btn btn-print" id="printButton">Cetak Pesanan</button>
</div>

<script>
    document.getElementById('printButton').addEventListener('click', function() {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Pesanan ini akan dicetak!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, cetak!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                var content = document.querySelector(".content").innerHTML;
                var printWindow = window.open('', '', 'height=400,width=800');
                printWindow.document.write('<html><head><title>Cetak Pesanan</title>');
                printWindow.document.write('</head><body>');
                printWindow.document.write(content);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();
            }
        });
    });
</script>
@endsection