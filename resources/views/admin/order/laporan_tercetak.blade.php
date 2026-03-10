<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:ital,wght@0,500;0,700;1,600;1,700&family=Roboto:wght@100;400;500;700;900&family=Ubuntu&display=swap" rel="stylesheet">
<style>
     .container-fluid{
         margin-top: 30px;
         padding: 0px 50px 0px 50px;
         font-family: 'Roboto', sans-serif;
     }
      hr{
        background-color: rgb(0, 0, 0); height: 1px; border: 1;
      }
      header > h1{
          text-align: center;
          font-weight: 700;
      }
      .periode > p {
          font-weight: 400;
      }

      thead{
        background-color: rgb(223, 223, 223);
        font-weight: 500;
      }
  </style>
</head>
<div class="container-fluid">
<header>
    <h1>Laporan Pesanan Deltizen Corner</h1>
</header>

<hr>
<div class="periode">
    {{-- <p>Dari tanggal {{ $Tglawal }} sampai dengan tanggal {{ $Tglakhir }}</p>  --}}
</div>

<table class="table-bordered" id="order" width="100%">
    <thead>
<tr>
        <th>ID</th>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Total</th>
        <th>Tanggal</th>
    </tr>
    </thead>
    @foreach($orders as $o)
        <tbody>
        <tr>
            <td>{{ $loop->iteration}}</td>
            <td>{{ $o->name }}</td>
            <td>{{ $o->price }}</td>
            <td>{{ $o->quantity }}</td>
            <td>{{ $o->subtotal }}</td>
            <td>{{ $o->date }}</td>
        </tr>

        </tbody>
    @endforeach
    <tr>
        <td colspan="4" style="text-align: center;">Jumlah</td>
        {{-- <td >Rp. {{ number_format($sum,0) }}</td> --}}

    </tr>
  </table>
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>