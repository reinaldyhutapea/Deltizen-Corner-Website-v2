<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Models\Confirm;
use Illuminate\Http\Request;

use Cart;
class BerandaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function productList2()
    {
        $products = Product::all();
        $orders = Order::all();
        $confirm  = DB::table('confirms')
        ->select('*')
        ->where('status_order','=','menunggu verifikasi')
        ->get();

        return view('dashboard', compact('products','orders','confirm'));
    }
}
