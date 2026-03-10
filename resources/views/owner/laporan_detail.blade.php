@extends('layouts.owner-template')
@section('content')
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:ital,wght@0,500;0,700;1,600;1,700&family=Roboto:wght@100;400;500;700;900&family=Ubuntu&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/f4cf3b69a5.js" crossorigin="anonymous"></script>
    <style>
        .content{
            font-family: Roboto;
        }
        .col_a{
           padding-top: 20px;
           padding-right: 20px;
           padding-left: 20px;
        }
        .col_b{
           padding-right: 20px;
           padding-left: 20px;
        }
        .card{
            padding: 15px;
        }

    </style>
</head>
<div class="content">
    <div class="col_a">
    <div class="col-md-12 ">
        <div class="id_pesanan">
            <a href="{{ route('laporan.data') }}" style="text-decoration: none;color:rgb(0, 0, 0);float: left;"><i class="fa-solid fa-chevron-left" style="margin-right: 4px;"></i>Kembali</a>
        </div>
        <div class="id_pesanan">
            <h6 style="float: right">Id Pesanan : {{ $identity->order_id}}</h6>
        </div>
     <br>
     <br>
        <div class="card shadow mb-4">
        <div class="box">
            <div class="box-header with-border">
                <h2>Detail Penerima</h2>
            </div>
            <table class="table">
                <tr style="font-size: larger">
                    <td>Penerima</td>
                    <td>{{ $identity->order->receiver }}</td>
                </tr>

                <tr style="font-size: larger">
                    <td>Nomor Telepon</td>
                    <td>{{ $identity->order->address }}</td>
                </tr>
                <tr style="font-size: larger">
                    <td>Catatan</td>
                    <td>{{ $identity->order->catatan }}</td>
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

                    @foreach($details as $detail)
                        <tr>
                            <td>
                                <a href="{{url($detail->product->image) }}" target="_blank"><img src="{{ url($detail->product->image) }}" width="100px"></a>
                            </td>
                            <td style="font-size: medium">{{ $detail->product->name }}</td>
                            <td style="font-size: medium">{{ $detail->product->price }}</td>
                            <td style="font-size: medium">{{ $detail->quantity }}</td>
                            <td style="font-size: medium">
                                Rp. {{ number_format($detail->quantity * $detail->product->price,0) }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    </div>
</div>
</div>
</div>
</div>
@endsection