@extends('layouts.admin-template')

@section('content')

@if(session('status'))
    <div class="box-header">
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon fa fa-check"></i> Success! &nbsp;
            {{ session('status') }}
        </div>
    </div>
@endif

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .btn {
            position: relative;
            display: inline-block;
            height: 41px;
            width: 43px;
            padding: 5px;
        }

        .btn .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -60px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .btn .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;
        }

        .btn:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }

        .btn1{
            padding: 5px;
            border-radius: 10px;
        }

        @media screen and (max-width: 600px) {
            #btn2, #btn3 {
                margin-top: 5px;
            }
        }
    </style>
</head>

<div class="container-fluid">
    <div class="header" style="margin-top: 20px;">
        <h4 style="font-weight: 700" style="margin-bottom: 20px;">Konfirmasi Pesanan</h4>
    </div>
    <div class="card shadow mb-4" style="padding: 5px;">
        <div class="card-body">
            <div style="overflow: auto;">
                <table id="categories" class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Total Harga</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>

                    @php
                        $no = 1;
                    @endphp

                    @foreach($confirms as $index=>$confirm)
                    <tbody>
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>
                                @if($confirm->user)
                                    {{ $confirm->user->name }}
                                @elseif($confirm->visitor_id)
                                    Guest - {{ $confirm->order->receiver }}  <!-- Gunakan nama yang diinputkan -->
                                @else
                                    Tidak diketahui
                                @endif
                            </td>
                            <td>Rp. {{ number_format($confirm->order->total_price, 0) }}</td>
                            <td>{{ $confirm->order->date }}</td>
                            <td>
                                @if ($confirm->order->status == 'menunggu verifikasi')
                                    <button class="btn btn-warning">
                                        <i class='bx bx-time-five' style="font-size: 30px;font-weight: 700;"></i>
                                        <span class="tooltiptext">Menunggu Verifikasi</span>
                                    </button>
                                @elseif ($confirm->order->status == 'dibayar')
                                    <button class="btn btn-success">
                                        <i class='bx bx-check-circle' style="font-size: 30px;font-weight: 700;"></i>
                                        <span class="tooltiptext">Dibayar</span>
                                    </button>
                                @else
                                    <button class="btn btn-danger">
                                        <i class='bx bx-x-circle' style="font-size: 30px;font-weight: 700;"></i>
                                        <span class="tooltiptext">Ditolak</span>
                                    </button>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('upload/confirm/'.$confirm->image) }}" class="btn bg-primary" download>
                                    <i class='bx bx-download' style="font-size: 30px;font-weight: 700;"></i>
                                    <span class="tooltiptext">Download Attachment</span>
                                </a>
                            </td>
                            <td>
                                <a href="{{ url('/confirmAdmin/detail/'.$confirm->order_id) }}" class="btn btn-secondary">
                                    <i class='bx bx-info-circle' style="font-size: 30px;font-weight: 700;color: #fff;"></i>
                                    <span class="tooltiptext">Detail Pesanan</span>
                                </a>
                                <a href="{{ url('/confirmAdmin/terima/'.$confirm->order_id) }}" class="btn bg-success">
                                    <i class='bx bx-check-circle' style="font-size: 30px;font-weight: 700;"></i>
                                    <span class="tooltiptext">Terima Pesanan</span>
                                </a>
                                <button type="button" class="btn bg-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $confirm->order_id }}">
                                    <i class='bx bx-x-circle' style="font-size: 30px;font-weight: 700;"></i>
                                    <span class="tooltiptext">Tolak Pesanan</span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

@foreach($confirms as $confirm)
<!-- Modal Create Product -->
<div class="modal fade" id="staticBackdrop{{ $confirm->order_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Alasan Ditolak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form role="form" method="get" action="{{ url('/confirmAdmin/tolak/'.$confirm->order_id)}}" enctype="multipart/form-data">
                    @csrf
                    <input type="radio" name="detail_status" value="Alamat Terlalu Jauh">Alamat Terlalu Jauh<br>
                    <input type="radio" name="detail_status" value="Bukti Pembayaran Tidak Sesuai">Bukti Pembayaran Tidak Sesuai<br>
                    <input type="radio" name="detail_status" id="other" value="other"> Other 
                    <input class="form-control" onClick="otherChoice()" id="inputother{{ $confirm->order_id }}" type="text" onchange="changeradioother({{ $confirm->order_id }})" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn1 btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn1 btn-success">Tolak</button>
            </div>
        </form>
    </div>
</div>
</div>
@endforeach

<script>
    function otherChoice(){
        var a = document.getElementById('other');
        a.checked = true;
    }

    function changeradioother(orderId) {
        var other = document.getElementById("other");
        var inputText = document.getElementById("inputother" + orderId).value;
        other.value = inputText;  // Ganti nilai "Other" dengan teks yang dimasukkan
    }
</script>

@endsection
