<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:ital,wght@0,500;0,700;1,600;1,700&family=Roboto:wght@100;400;500;700;900&family=Ubuntu&display=swap" rel="stylesheet">
<style>
     .container-fluid{
         margin-top: 30px;
         padding: 0px 50px 0px 50px;
         font-family: 'Poppins', sans-serif;
     }
      hr{
        background-color: rgb(0, 0, 0); height: 1px; border: 1;
      }
      header > h1,h5,h3,h6,p{
          text-align: center;
          font-weight: 600;
      }
      header > p{
          text-align: center;
          font-weight: 400;
      }
      .periode > p {
          font-weight: 400;
      }

      thead{
       text-align: center;
        font-weight: 500;
        color: rgb(0, 0, 0);
      }
  </style>
</head>
<div class="container-fluid">
<header>
    <h5>Laporan Pemesanan</h5>
    <h1>Deltizen Corner</h1>
    <p>Jalan Sisingamangaraja, Sitoluama, Laguboti, Kabupaten Toba Samosir, Sumatera Utara</p>
</header>

<hr>
<div class="periode">
    <p>Dari tanggal {{ $start_date }} sampai dengan tanggal {{ $end_date }}</p> 
</div>

<table  class="table table-bordered border-dark" id="order" width="100%">
    <thead>
<tr>
        <th>ID</th>
        <th>Nama Pemesan</th>
        <th>Nomor Telepon</th>
        <th>Jumlah Item</th>
        <th>Total Bayar</th>
        <th>Tanggal</th>
    </tr>
    </thead>
    @foreach($orders as $order)
        <tbody>
        <tr>
            <td>{{ $loop->iteration}}</td>
            <td>{{ $order->receiver }}</td>
            <td>{{ $order->address }}</td>
            <td>{{ $order->quantity }}</td>
            <td>{{ $order->total_price }}</td>
            <td>{{ $order->date }}</td>
        </tr>
        </tbody>
    @endforeach
    <tr>


    </tr>
  </table>
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
