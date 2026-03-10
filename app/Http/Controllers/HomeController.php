<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Category ID Constants - untuk menghindari hardcoded values
     */
    const CATEGORY_MAKANAN = 1;
    const CATEGORY_MINUMAN = 2;
    const CATEGORY_PROMO = 3;

    /**
     * Halaman utama dengan produk promo
     */
    public function welcome()
    {
        $products = Product::with('category')
            ->where('stoks', 1)
            ->where('category_id', self::CATEGORY_PROMO)
            ->paginate(12);

        return view('front.home', compact('products'));
    }

    /**
     * Alias untuk welcome (backward compatibility)
     */
    public function index()
    {
        return $this->welcome();
    }

    /**
     * Menampilkan produk makanan
     */
    public function makanan()
    {
        $products = Product::with('category')
            ->where('stoks', 1)
            ->where('category_id', self::CATEGORY_MAKANAN)
            ->get();

        return view('front.menu', compact('products'));
    }

    /**
     * Menampilkan produk minuman
     */
    public function minuman()
    {
        $products = Product::with('category')
            ->where('stoks', 1)
            ->where('category_id', self::CATEGORY_MINUMAN)
            ->get();

        return view('front.menu', compact('products'));
    }

    /**
     * Menampilkan produk promo
     */
    public function promo()
    {
        $products = Product::with('category')
            ->where('stoks', 1)
            ->where('category_id', self::CATEGORY_PROMO)
            ->get();

        return view('front.menu', compact('products'));
    }

    /**
     * Menampilkan semua produk
     */
    public function semua()
    {
        $products = Product::with('category')
            ->where('stoks', 1)
            ->get();

        return view('front.menu', compact('products'));
    }

    /**
     * Menampilkan semua produk dengan urutan kategori
     */
    public function all()
    {
        $products = Product::with('category')
            ->where('stoks', 1)
            ->orderBy('category_id', 'ASC')
            ->get();

        return view('front.menu', compact('products'));
    }

    /**
     * Pencarian produk - Fixed SQL Injection vulnerability
     */
    public function cari(Request $request)
    {
        $request->validate([
            'cari' => 'nullable|string|max:100'
        ]);

        $cari = $request->input('cari', '');
        $message = null;

        // Menggunakan Eloquent dengan parameter binding (aman dari SQL Injection)
        $products = Product::with('category')
            ->select('id', 'name', 'description', 'price', 'stock', 'image', 'stoks', 'category_id')
            ->when($cari, function ($query) use ($cari) {
                return $query->where('name', 'like', '%' . $cari . '%');
            })
            ->where('stoks', 1)
            ->get();

        if ($products->isEmpty()) {
            $message = "Produk tidak ditemukan.";
        }

        $categories = Category::all();

        return view('front.menu', compact('products', 'message', 'categories'));
    }

    /**
     * Detail produk untuk customer
     */
    public function detail_front($id)
    {
        $product = Product::with('category')->findOrFail($id);

        return view('front.detail_product', compact('product'));
    }

    /**
     * Halaman pembayaran
     */
    public function pembayaran($id)
    {
        $order = Order::with(['products', 'user'])->findOrFail($id);

        return view('front.pembayaran', compact('order'));
    }
}
