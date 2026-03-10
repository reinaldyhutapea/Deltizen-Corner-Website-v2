@extends('layouts.owner-template')
@section('content')
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> 
 </head>
<div class="content-header">
    <div class="container-fluid">
 
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $orders->count() }}</h3>
              <p>Pesanan</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="/owner/laporan/pesanan" class="small-box-footer">Lebih Detail <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{ $products->count() }}<sup style="font-size: 20px"></sup></h3>
              <p>Produk</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="/owner/data/produk" class="small-box-footer">Lebih Detail <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{ $users1->count() }}</h3>
              <p>Jumlah Pelanggan </p>
            </div>
            <div class="icon">
              <i class="fa-solid fa-check-double"></i>
            </div>
            <a href="/owner/data/pelanggan" class="small-box-footer">Lebih Detail  <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{ $users2->count() }}</h3>
              <p>Jumlah Admin</p>
            </div>
            <div class="icon">
              <i class="fa-solid fa-check-double"></i>
            </div>
            <a href="/owner/data/admin" class="small-box-footer">Lebih Detail  <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <!-- /.row -->
      </div>
      <div class="row">
      <div class="col">
        <div class="card" style="padding: 10px;">
        <div class="chart-container">
          <div class="pie-chart-container">
            <canvas id="pie-chart"></canvas>
          </div>
        </div>
      </div>
      </div>
      </div>

      <div class="row" >
                <div class="col">
                <!-- TABLE: LATEST ORDERS -->
                  <div class="card">
                    <div class="card-header border-transparent">
                      <h3 class="card-title">Pesanan Terbaru</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                      <div class="table-responsive">
                        <table class="table m-0">
                          <thead>
                          <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Total Harga</th>
                          </tr>
                          </thead>
                          <tbody>
                            @foreach ($orders2 as $o)
                          <tr>
                            <td>{{ $o->id }}</td>
                            <td>{{ $o->receiver }}</td>
                            <td>{{ $o->status }}</td>
                            <td>{{ number_format($o->total_price,0) }} </td>
                          </tr>
                          </tbody>
                          @endforeach
                        </table>
                      </div>
                      <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                      {{-- <a href="/owner/laporan/pesanan" class="btn btn-sm btn-secondary float-right">Semua</a> --}}
                    </div>
                    <!-- /.card-footer -->
                  </div>
                  <!-- /.card -->
                </div>


          <div class="col">
            <!-- TABLE: LATEST ORDERS -->
              <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">Produk Terlaris</h3>
      
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table m-0">
                      <thead>
                      <tr>
                        <th>Nama Produk</th>
                        <th>Total Penjualan</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($terlaris as $t)
                      <tr>
                        <td>{{$t->name}}</td></td>
                        <td>{{$t->total}}</td>
                      </tr>
                      </tbody>
                      @endforeach
                    </table>
                  </div>
                  <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                  {{-- <a href="" class="btn btn-sm btn-secondary float-right">Semua</a> --}}
                </div>
                <!-- /.card-footer -->
              </div>
              <!-- /.card -->
            </div>
          <!-- /.col -->
          </div>
          <div class="row">
            <div class="col">
              <!-- TABLE: LATEST ORDERS -->
                <div class="card">
                  <div class="card-header border-transparent">
                    <h3 class="card-title">Pemesan Terbanyak</h3>
        
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table m-0">
                        <thead>
                        <tr>
                          <th>Nama Pemesan</th>
                          <th>Jumlah Pesanan</th>
                          <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                          @foreach ($pemesan as $p)
                        <tr>
                          <td>{{ $p->receiver }}</td>
                          <td>{{ $p->total }}</td>
                          <td>Rp. {{ number_format($p->subtotal,0) }}</td>
                        </tr>
                        </tbody>
                        @endforeach
                      </table>
                    </div>
                    <!-- /.table-responsive -->
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer clearfix">
                    {{-- <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a> --}}
                  </div>
                  <!-- /.card-footer -->
                </div>
                <!-- /.card -->
              </div>
            <!-- /.col -->
          </div>
      </div>
      </div>
      </div>

    </div>
  </section>
  
  <script>
    $(function(){
        //get the pie chart canvas
        var cData = JSON.parse(`<?php echo $chart_data; ?>`);
        var ctx = $("#pie-chart");
   
        //pie chart data
        var data = {
          labels: cData.label,
          datasets: [
            {
              label: "Bulan",
              data: cData.data,
              fill:false,
              backgroundColor: [
                "#0087FF", 
                "#0087FF", 
                "#0087FF", 
                "#0087FF", 
                "#0087FF", 
                       
              ],
              borderColor: [
                "#999999",
              
              ],
            
            }
          ]
        };
   
        //options
        var options = {
          responsive: true,
          title: {
            display: true,
            position: "top",
            text: "Penjualan Perbulan",
            fontSize: 18,
            fontColor: "#111"
          },
          legend: {
            display: true,
            position: "bottom",
            labels: {
              fontColor: "#333",
              fontSize: 16
            }
          }
          
        };
   
        //create Pie Chart class object
        var chart1 = new Chart(ctx, {
          type: "bar",
          data: data,
          options: options
        });
   
    });
  </script>

@endsection
