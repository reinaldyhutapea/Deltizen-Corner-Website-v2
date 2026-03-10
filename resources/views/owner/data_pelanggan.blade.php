@extends('layouts.owner-template')
@section('content')
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Local CSS -->

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <title>Hello, world!</title>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/f4cf3b69a5.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
{{-- Font --}}
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:ital,wght@0,500;0,700;1,600;1,700&family=Roboto:wght@100;400;500;700;900&family=Ubuntu&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:ital,wght@0,500;0,700;1,600;1,700&family=Roboto:wght@100;400;500;700;900&family=Sora:wght@300;400;500;600;700&family=Ubuntu&display=swap" rel="stylesheet"></head>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700&family=Montserrat:ital,wght@0,500;0,700;1,600;1,700&family=Roboto:wght@100;400;500;700;900&family=Sora:wght@300;400;500;600;700&family=Ubuntu&display=swap" rel="stylesheet">
<style>
        .container-fluid{
    padding: 20px;
    font-family: 'Inter';
    font-weight: 400;
    }

    .card-body{
    padding: 10px;
    }

    .custom-select.custom-select-sm.form-control.form-control-sm{
    width: 50px;
    }

    h4{
    float: left;
    }

    .header > .btn.btn-primary{
    float: right;
    }

    img{
    height: 100px;
    width: 100px;
    }

    a#action.btn.btn-xs.btn-warning{
    margin-left: 7px;
    }

    .mobile-ui{
    display: none;
    }


/* perlu dirubah dari bawah ini */

@media screen and (max-width: 600px) {

    .none-mobile-ui{
        display: none;
    }

    .mobile-ui{
        display: block;
    }
    #product-table_wrapper > div:nth-child(3){
        margin-bottom: 25px;
    }

    a#action.btn.btn-xs.btn-warning{
        margin-left: 0px;
        margin-top: 7px;
    }

    #product-table_length{
     
        text-align: left;
    }
    #product-table_filter{
        text-align: left;
    }
    #product-table_length > label > select{
        margin-left: 18px;
    }
}
</style>
</head>
<body>
    <div class="container-fluid">

        <div class="card shadow mb-4" >
            <div class="card-header">
                <h4 style="font-weight: 700">Daftar Pelanggan</h4>        
            </div>
        <div class="card-body">
            <div style="overflow: auto;" >
        <table class="table table-bordered" id="product-table" width=100%>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Tanggal Daftar</th>
                </tr>
            </thead>
        </table>
        </div>
        </div>
    </div>
    </div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->

    <script>
        $(function() {
                $('#product-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{!! url("/owner/data/pelanggan") !!}',
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'name', name: 'name' },
                        { data: 'email', name: 'email' },
                        { data: 'month', name: 'month' },
                    ]
                });
            });

    </script>
</body>
    
    @endsection