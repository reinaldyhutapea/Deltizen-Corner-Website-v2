@extends('layouts.owner-template')
@section('content')
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
{{-- 
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
     --}} 
     <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap5.min.css">

    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
    <style>
        .container-fluid{
    padding: 20px;
}
.box-title{
    font-size: 30px;
    font-weight: 600;
    margin-bottom: 10px;
}
.card{
 padding: 10px;
}

.custom-select.custom-select-sm.form-control.form-control-sm{
    width: 50px;
}
a#action.btn.btn-xs.btn-warning{
    margin-left: 7px;
}

#product-table2_wrapper > div:nth-child(3){
    margin-bottom: 25px;
}


@media screen and (max-width: 600px) {


    #product-table2_wrapper > div:nth-child(3){
        margin-bottom: 25px;
    }


    .col{
        margin-top: 20px;
    }

    #product-table2_length{
     
        text-align: left;
    }
    #product-table2_filter{
        text-align: left;
    }
    #product-table2_length > label > select{
        margin-left: 18px;
    }
}
    </style>
 </head> 
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="box-header">
            <h6 class="box-title">Daftar Pesanan</h6>
           </div>
        <div class="card shadow mb-4">
            <div class="card-body">
            <div class="box" style="margin-bottom: 10px;">
                <div class="my-2">
                    <button class="btn btn-danger">
               <a href="{{ route('pesanan.cetak') }}" style="color: white;text-decoration: none;">Cetak</a>
             </button>
               </div>
             </div>
            <div class="row" style="margin-bottom: 30px;">
                <div class="col-5">
                    <input type="date" name="from_date" id="from_date" class="form-control" placeholder="From Date"  />
                </div>
                <div class="col-5">
                    <input type="date" name="to_date" id="to_date" class="form-control" placeholder="To Date"  />
                </div>
                <div class="col">
                    <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                    <button type="button" name="refresh" id="refresh" class="btn btn-secondary">Reset</button>
                </div>
            </div>
            <div style="overflow: auto;" >
               <table class="table table-bordered" id="product-table2" width="100%">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Nama Penerima</th>
                        <th>No telepon yang dapat dihubungi</th>
                        <th>Total Bayar</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
            </div>
        </div>
         </div>
          </div>
    </div>
  </div>
<meta name="csrf-token" content="{{ csrf_token() }}">


<script>
    function load_data(from_date = '', to_date='') {
        $('#product-table2').DataTable({ 
            processing: true,
            serverSide: true,
            ajax:{
                url:'{{ route("pesanan.data") }}',
                data:{from_date:from_date, to_date:to_date}
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'id', name: 'id' },
                { data: 'receiver', name: 'receiver' },
                { data: 'address', name: 'address' },
                { data: 'total_price', name: 'total_price' },
                { data: 'date', name: 'date'},
                { data: 'status', name: 'status'},
                { data: 'action', name: 'action', orderable: false, searchable: false}
            ]

            
        });
    };
          
            $(document).ready(function(){
                $('.input-daterange').datepicker({
                    todayBtn:'linked',
                    format:'yyyy-mm-dd',
                    autoclose:true
                });

                load_data();
        

            });


   
$('#filter').click(function(){
  var from_date = $('#from_date').val();
  var to_date = $('#to_date').val();
  console.log('result date', from_date, to_date);
  if(from_date != '' &&  to_date != '')
  {
   $('#product-table2').DataTable().destroy();
   load_data(from_date, to_date);
  }
  else
  {
   alert('Both Date is required');
  }
 });

 $('#refresh').click(function(){
  $('#from_date').val('');
  $('#to_date').val('');
  $('#product-table2').DataTable().destroy();
  load_data();
 });

    var myModal = document.getElementById('myModal')
    var myInput = document.getElementById('myInput')
        myModal.addEventListener('shown.bs.modal', function () {
            myInput.focus()
        })
</script>
        

@endsection