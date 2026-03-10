
@extends('layouts.admin-template')
@section('content')
<head>
<link href="{{ asset('/css/order.css') }}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:ital,wght@0,500;0,700;1,600;1,700&family=Roboto:wght@100;400;500;700;900&family=Ubuntu&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/f4cf3b69a5.js" crossorigin="anonymous"></script>
<style>
    .content{
        font-family: roboto;
    }
    .card-header > h1{
      font-size: 20px;
      font-weight: 700;
    }
    
    .input-group > a{
        font-weight: 500;
    }
</style>
</head>
<div class="content" style="margin-top: 30px">
    <div class="card card-info card-outline">
      <div class="card-header">
          <h1>Cetak Laporan</h1>
      </div>
      <div class="card-body">
          <div class="input-group mb-3" style="float: left;">
              <div class="col-md-12 awal">
              <label for="label">Tanggal Awal </label>
              <input type="date" name="tglawal" id="tglawal" class="form-control" width="100%">
              </div>
          </div>
          <div class="input-group mb-3" style="float: right;">
              <div class="col-md-12 akhir">
              <label for="label">Tanggal Akhir </label>
              <input type="date" name="tglakhir" id="tglakhir" class="form-control">
              </div>
          </div>
          <div class="input-group mb-3">
           <a href="" onclick="this.href='/order/cetak_pertanggal/' + document.getElementById('tglawal').value +
           '/' + document.getElementById('tglakhir').value" target="_blank" class="btn btn-primary col-md-12">
           Cetak <i class="fa-solid fa-print" style="margin-left: 5px"></i></a>
          </div>
      </div>
    </div>
</div>

@endsection