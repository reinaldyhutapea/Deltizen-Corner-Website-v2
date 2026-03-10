{{-- Backup Owner Controller --}}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Carbon;
use App\Models\Order_Product;
use App\Models\Product;
use Illuminate\Http\Request;
use PDF;

class OwnerController extends Controller
{
    //
    public function index()
    {
       
        return view('owner.index');
    }

    public function laporan()
    {
      
        $orders = Order_Product::join('orders','order_product.order_id','=','orders.id')
        ->join ('products','order_product.product_id','=','products.id')
        ->select('order_product.id','products.name','products.price','order_product.quantity','order_product.subtotal','orders.date','orders.status')
        ->paginate(10);
        $produk = Category::all();
        return view('owner.laporan', compact('orders','produk'));

    }
    public function search(Request $request)
    {
        $produk = Category::all(); 
       $cari = $request->cari;
        $orders = Order_Product::join('orders','order_product.order_id','=','orders.id')
        ->join ('products','order_product.product_id','=','products.id')
        ->select('order_product.id','products.name','products.price','order_product.quantity','order_product.subtotal','orders.date','orders.status')
        ->where('products.name','like',"%".$cari."%")
        ->paginate(10);
        return view('owner.laporan', compact('orders','produk'));

    }
    public function orderbydate(Request $request)
    {
       $produk = Category::all(); 
       $cari = $request->cari;
       $orders = Order_Product::join('orders','order_product.order_id','=','orders.id')
       ->join ('products','order_product.product_id','=','products.id')
       ->select('order_product.id','products.name','products.price','order_product.quantity','order_product.subtotal','orders.date','orders.status')
       ->paginate(10);
       return view('owner.laporan', compact('orders','produk'));

    }


    public function cari(Request $request)
    {

        $produk = Category::all();
        $start_date = Carbon::parse($request->start_date)->toDateTimeString();
        $end_date = Carbon::parse($request->end_date)->toDateTimeString();
        $category = $request->category;
        $name = $request->name;
        $orders = Order_Product::join('orders','order_product.order_id','=','orders.id')
        ->join ('products','order_product.product_id','=','products.id')
        ->select('order_product.id','products.name','products.price','products.category_id','order_product.quantity','order_product.subtotal','orders.date','orders.status');

        if ($category != '---Pilih Kategori---') {
            $orders = $orders->where('products.category_id','=',$category);
        }
        // dd($start_date);
        if ($name != '---Pilih Nama---') {
            $orders = $orders->where('products.id','=',$name);
        }
        if (!empty($request->start_date) && !empty($request->end_date)) {
            $orders = $orders->whereBetween('orders.date',[$start_date,$end_date]);
        }
        // dd($orders->get());
        $orders = $orders->get();

        // ->where('products.id','=',$name, 'AND' ,'products.category_id','=',$category)

        return view('owner.laporan', compact('orders','produk'));
    }
    public function filter($start_date, $end_date, $name, $category){

        $produk = Category::all();
        $start_date = Carbon::parse($start_date)->toDateTimeString();
        $end_date = Carbon::parse($end_date)->toDateTimeString();
        $orders = Order_Product::join('orders','order_product.order_id','=','orders.id')
        ->join ('products','order_product.product_id','=','products.id')
        ->select('order_product.id','products.name','products.price','products.category_id','order_product.quantity','order_product.subtotal','orders.date','orders.status');
  
        if ($category != '---Pilih Kategori---' && $category != null) {
            $orders = $orders->where('products.category_id','=',$category);
        }
        
        if ($name != '---Pilih Nama---'&& $name != null) {
            $orders = $orders->where('products.id','=',$name);
        }

        if (!empty($start_date) && !empty($end_date)) {
            $orders = $orders->whereBetween('orders.date',[$start_date,$end_date]);
        }
        
        $orders = $orders->get();
        // ->where('products.id','=',$name, 'AND' ,'products.category_id','=',$category)
        return $orders;
    }


    public function cetak($tglawal, $tglakhir){   
    
    $Tglawal = $tglawal;
    $Tglakhir = $tglakhir;
    $orders = Order_Product::join('orders','order_product.order_id','=','orders.id')
    ->join ('products','order_product.product_id','=','products.id')
    ->select('order_product.id','products.name','products.price','order_product.quantity','order_product.subtotal','orders.date','orders.status','orders.created_at')
    ->whereBetween('orders.date',[$tglawal,$tglakhir] )
    ->orderBy('orders.created_at', 'ASC')
    ->get();
    // $orders = OwnerController::filter($start_date, $end_date, $name, $category);
    // dd($orders)->get();
	$pdf = PDF::loadview('order.laporan_tercetak',compact('orders','tglawal','tglakhir'))->setOptions(['defaultFont' => 'sans-serif']);
	return $pdf->stream('laporan-pegawai-pdf');
}


public function kategori(Request $request){
    $category = Product::where("category_id",$request->category_id)->pluck('id','name');
    return response()->json($category);

}



}



// Akhir Backup Owner Controller


<!-- Backup Laporan Blade -->
<div class="container-fluid">
                <div class="row">   
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                    <div class="box">
                        <div class="box-header">
                            <h1 class="text-3xl font-bold">Data Penjualan Produk</h1>
                        </div>
                        <div>
                            <a href="/owner/laporan" class="btn btn-primary">Reset Filter</a>
                        </div>
                        
                        <form action="/owner/laporan/cari" method="GET" >
                            {{-- <input type="text" class="form-control" name="cari" placeholder="Search..." value=""> --}}
                            <input type="date" class="form-control" id="start_date" name="start_date" placeholder="Search..." value="">
                            <input type="date" class="form-control" id="end_date" name="end_date" placeholder="Search..." value="">
                            <div class="row mb-3">
                        <div class="col-3">
                            <label  class="form-label">Kategori</label>
                            </div>
                            <div class="col-9">
                            <select class="form-control" name="category" id="category">
                                <option selected>---Pilih Kategori---</option>
                                @foreach ($produk as $p)
                                    <option  value="{{$p->id}}">{{$p->id}}</option>
                                @endforeach
                            </select>
                            </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-3">
                                <label  class="form-label">Nama</label>
                                </div>
                                <div class="col-9">
                                <select class="form-control" name="name" id="name">
                                    <option selected>---Pilih Nama---</option>
                                </select>
                                </div>
                                </div>
                                <button type="submit" style="all:unset;margin-bottom: 28px;">Submit</button>

                               
                            </form>
                            {{-- <button id="button-cetak">
                                CETAK PDF
                            </button> --}}
                        {{-- <a href="/owner/laporan/cetak/"+document.getElementById('start_date').value + "" class="btn btn-primary" target="_blank">CETAK PDF</a> --}}
                      

                            {{-- <button class="btn btn-success" onclick="this.href='/owner/laporan/cetak/' + document.getElementById('start_date').value +'/' + document.getElementById('end_date').value + '/' + document.getElementById('name').value + '/' + document.getElementById('category').value" target="_blank" style="text-decoration: none;color: white;">
                             
                                gCetak <i class="fa-solid fa-print" style="margin-left: 5px"></i></button>
                         --}}
                        <div class="box">
                            <div class="my-2">
                             <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                 <i class="fa-solid fa-print" style="margin-right: 11px;"></i>Cetak
                             </button> 
                        </div>
                        <table class="table" id="table_id">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ID</th>
                                        <th>Nama Barang</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Total Harga</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                @foreach($orders as $order)
                                <tbody>
                            
                                    <td>{{ $loop->iteration}}</td>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ $order->price }}</td>
                                    <td>{{ $order->quantity }}</td>
                                    <td>{{ $order->subtotal }}</td>
                                    <td>{{ $order->date }}</td>
                                </tbody>
                                @endforeach
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- {{$orders->links()}} --}}
                </div>
            </div> 

            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Cetak Laporan Pertanggal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
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
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">
                        <a href="" onclick="this.href='/order/cetak_pertanggal/' + document.getElementById('tglawal').value +
                        '/' + document.getElementById('tglakhir').value" target="_blank" style="text-decoration: none;color: white;">
                        Cetak <i class="fa-solid fa-print" style="margin-left: 5px"></i></a></button>
                    </div>
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

    var myModal = document.getElementById('myModal')
    var myInput = document.getElementById('myInput')
        myModal.addEventListener('shown.bs.modal', function () {
            myInput.focus()
        })



        </script>
// Backup Laporan Blade