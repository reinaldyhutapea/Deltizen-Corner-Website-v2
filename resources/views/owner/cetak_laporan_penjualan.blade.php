
  @extends('layouts.owner-template')
  @section('content')
  <head>
  {{-- <link href="{{ asset('/css/order.css') }}" rel="stylesheet"> --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:ital,wght@0,500;0,700;1,600;1,700&family=Roboto:wght@100;400;500;700;900&family=Ubuntu&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/f4cf3b69a5.js" crossorigin="anonymous"></script>
  <style>
      /* .content{
          font-family: roboto;
      }
      .card-header > h1{
        font-size: 20px;
        font-weight: 700;
      }
      
      .input-group > a{
          font-weight: 500;
      } */

      .container-fluid{
        font-family: 'Poppins', sans-serif;
      }
      .col{
          margin-top: 10px;
      }
      .card-header{
          font-size: 30px;
          font-weight: 600;
      }
  </style>
</head>
  {{-- <div class="content" style="margin-top: 30px">
      <div class="card card-info card-outline">
        <div class="card-header">
            <h1>Cetak Laporan Pertanggal</h1>
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
             <a href="" onclick="this.href='/owner/laporan/penjualan/cetak/penjualan_cetak_pertanggal/' + document.getElementById('tglawal').value +
             '/' + document.getElementById('tglakhir').value" target="_blank" class="btn btn-primary col-md-12">
             Cetak <i class="fa-solid fa-print" style="margin-left: 5px"></i></a>
            </div>
        </div>
      </div> --}}
      {{-- <div class="card card-info card-outline">
        <div class="card-header">
            <h1>Cetak Laporan Pertanggal Kategori Makanan</h1>
        </div>
        <div class="card-body">
            <div class="input-group mb-3" style="float: left;">
                <div class="col-md-12 awal">
                <label for="label">Tanggal Awal </label>
                <input type="date" name="tglawal1" id="tglawal1" class="form-control" width="100%">
                
                </div>
            </div>
            <div class="input-group mb-3" style="float: right;">
                <div class="col-md-12 akhir">
                <label for="label">Tanggal Akhir </label>
                <input type="date" name="tglakhir1" id="tglakhir1" class="form-control">
                </div>
            </div>
            <div class="input-group mb-3">
             <a href="" onclick="this.href='/owner/laporan/penjualan/cetak/penjualan_cetak_pertanggal/makanan/' + document.getElementById('tglawal1').value +
             '/' + document.getElementById('tglakhir1').value" target="_blank" class="btn btn-primary col-md-12">
             Cetak <i class="fa-solid fa-print" style="margin-left: 5px"></i></a>
            </div>
        </div>
      </div>
      <div class="card card-info card-outline">
        <div class="card-header">
            <h1>Cetak Laporan Pertanggal Kategori Minuman</h1>
        </div>
        <div class="card-body">
            <div class="input-group mb-3" style="float: left;">
                <div class="col-md-12 awal">
                <label for="label">Tanggal Awal </label>
                <input type="date" name="tglawal2" id="tglawal2" class="form-control" width="100%">
                
                </div>
            </div>
            <div class="input-group mb-3" style="float: right;">
                <div class="col-md-12 akhir">
                <label for="label">Tanggal Akhir </label>
                <input type="date" name="tglakhir2" id="tglakhir2" class="form-control">
                </div>
            </div>
            <div class="input-group mb-3">
             <a href="" onclick="this.href='/owner/laporan/penjualan/cetak/penjualan_cetak_pertanggal/minuman/' + document.getElementById('tglawal2').value +
             '/' + document.getElementById('tglakhir2').value" target="_blank" class="btn btn-primary col-md-12">
             Cetak <i class="fa-solid fa-print" style="margin-left: 5px"></i></a>
            </div>
        </div>
      </div>
  </div> --}}
<div class="container-fluid">
    <div class="card" style="margin-top: 20px">
        <div class="card-header">
            Cetak Laporan Penjualan Pertanggal
        </div>
        <div class="card-body">
  <form action="/owner/laporan/cari" method="GET" >
    <div class="row">
     <div class="col">
         <label for="Tanggal Awal"> Tanggal Awal </label>
        <input type="date" class="form-control" id="start_date" name="start_date" placeholder="Search..." value="">
    </div>
    <div class="col">
      <label for="Tanggal Akhir"> Tanggal Akhir </label>
      <input type="date" class="form-control" id="end_date" name="end_date" placeholder="Search..." value="">
    </div>
    </div>
    
    <div class="row">
      <div class="col">
        <label  class="form-label">Kategori</label>
        <select class="form-control" name="category" id="category">
          <option selected>---Pilih Kategori---</option>
          @foreach ($category as $p)
              <option  value="{{$p->id}}">{{$p->id}}</option>
          @endforeach
        </select>
        </div>
      </div>

      <div class="row">
          <div class="col">
            <label  class="form-label">Nama</label>
          <select class="form-control" name="name" id="name">
              <option selected>---Pilih Nama---</option>
          </select>
          </div>
          </div>
          <button type="submit" class="btn btn-primary" style="margin-top: 28px;">Submit</button>
      </form>
    </div>
</div>
</div>


      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <script>

      $('#category').change(function(){
      var category_id = $(this).val();    
      if(category_id){
      $.ajax({
      type:"GET",
      url:"/owner/laporan/kategori?category_id="+category_id,
      dataType: 'JSON',
      success:function(res){               
          if(res){
              $("#name").empty();
              $("#name").append('<option>---Pilih Nama---</option>');
              $.each(res,function(nama,category_id){
                  $("#name").append('<option value="'+category_id+'">'+nama+'</option>');
              });
          }else{
          $("#name").empty();
          }
      }
      });
  }else{
      $("#name").empty();
  }      
});




  </script>

@endsection

