@extends('layouts.admin-template')
@section('content')
{{-- <link href="{{ asset('/css/detail.css') }}" rel="stylesheet"> --}}
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700&family=Montserrat:ital,wght@0,500;0,700;1,600;1,700&family=Roboto:wght@100;400;500;700;900&family=Sora:wght@300;400;500;600;700&family=Ubuntu&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/f4cf3b69a5.js" crossorigin="anonymous"></script>
</head>

<div class="container-fluid">

            <a href="{{ route('confirmAdmin') }}" class="btn btn-secondary" style="text-decoration: none;color:rgb(0, 0, 0);margin-top: 20px;margin-bottom: 20px;;color: white;">Kembali</a>
    
            <h6 style="float: right;width: 150px; margin-top: 30px;">Id Pesanan : {{ $identity->order_id}}</h6>

        
    <div class="card shadow mb-4" >
            <div class="card-header">
                <h4>Detail Penerima</h4>
            </div>
            <div class="card-body">
            <table class="table table-borderless">
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


        <div class="card shadow mb-4">
            <div class="card-header ">
                <h4>Detail Produk</h4>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
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
                            <td>Rp. {{ number_format($detail->subtotal, 0) }}</td>
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan="4" align="center" style="font-size: medium">Total</td>
                        <td style="font-size: medium">Rp. {{ number_format($detail->order->total_price,0) }}</td>
                    </tr>
                </table>
            </div>
        </div>

<br>
<a href="{{ url('confirmAdmin/terima/'.$detail->order_id) }}" class="btn btn-lg bg-success btn-block">Terima</a>
<a style="margin-bottom: 20px;" href="{{ url('confirmAdmin/tolak/'.$detail->order_id)}}" class="btn btn-lg bg-red btn-block">Tolak</a>

</div>
@endsection