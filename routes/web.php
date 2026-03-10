<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ConfirmController;
use App\Http\Controllers\ConfirmAdminController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['throttle:10,1'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login_process'])->name('login.submit');
});
Route::post('/logout', [LogoutController::class, 'perform'])->name('logout.perform');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

/*
|--------------------------------------------------------------------------
| Public Routes (Customer/Guest)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'welcome'])->name('welcome');

// Menu Routes
Route::prefix('menu')->group(function () {
    Route::get('/', [HomeController::class, 'all'])->name('products.index');
    Route::get('/semua', [HomeController::class, 'semua'])->name('products.semua');
    Route::get('/makanan', [HomeController::class, 'makanan'])->name('products.makanan');
    Route::get('/minuman', [HomeController::class, 'minuman'])->name('products.minuman');
    Route::get('/promo', [HomeController::class, 'promo'])->name('products.promo');
    Route::get('/cari', [HomeController::class, 'cari'])->name('products.cari');
});

// Product Detail (Public)
Route::get('/product/detail_front/{id}', [HomeController::class, 'detail_front'])->name('product.detail_front');

// Invoice Routes (Public - untuk customer lihat pesanan)
Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
Route::get('/invoice/list', [InvoiceController::class, 'list'])->name('invoice.list');

// Cart Routes
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'cartList'])->name('cart.list');
    Route::post('/', [CartController::class, 'addToCart'])->name('cart.store');
    Route::post('/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/count', [CartController::class, 'cartCount'])->name('cart.count');
    Route::post('/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/remove', [CartController::class, 'removeCart'])->name('cart.remove');
    Route::post('/clear', [CartController::class, 'clearAllCart'])->name('cart.clear');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/checkout', [CartController::class, 'processCheckout'])->name('cart.process');
    Route::post('/bayar', [CartController::class, 'bayar'])->name('cart.bayar');
    Route::get('/guest-login', [CartController::class, 'guestLogin'])->name('cart.guest-login');
});

// Confirmation & Payment Routes
Route::get('/confirm/{id}', [ConfirmController::class, 'index'])->name('confirm.index');
Route::post('/confirm/store', [ConfirmController::class, 'store'])->name('confirm.store');
Route::get('/pembayaran/{id}', [HomeController::class, 'pembayaran'])->name('pembayaran');

/*
|--------------------------------------------------------------------------
| Authenticated Customer Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/invoice/detail/{id}', [InvoiceController::class, 'detail'])->name('invoice.detail');
});

/*
|--------------------------------------------------------------------------
| Owner Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:owner'])->prefix('owner')->group(function () {
    Route::get('/index', [OwnerController::class, 'index0'])->name('owner.index');
    Route::get('/profil', [OwnerController::class, 'profil'])->name('owner.profil');
    Route::post('/profil/change_password', [OwnerController::class, 'store'])->name('change.password');

    // Laporan Routes
    Route::prefix('laporan')->group(function () {
        Route::get('/penjualan', [OwnerController::class, 'penjualan'])->name('owner.laporan_penjualan');
        Route::get('/penjualan/cetak', [OwnerController::class, 'penjualan_cetak'])->name('penjualan.cetak');
        Route::get('/pesanan', [OwnerController::class, 'index2'])->name('laporan.data');
        Route::get('/pesanan/cetak', [OwnerController::class, 'pesanan_cetak'])->name('pesanan.cetak');
        Route::get('/pesanan/tercetak', [OwnerController::class, 'cari2'])->name('pesanan.tercetak');
        Route::get('/pesanan/{id}', [OwnerController::class, 'pesananLaporanDetail'])->name('pesanan.data.detail');
        Route::get('/cari', [OwnerController::class, 'cari'])->name('owner.laporan.cari');
        Route::get('/kategori', [OwnerController::class, 'kategori'])->name('owner.laporan.kategori');
    });

    // Data Routes
    Route::prefix('data')->group(function () {
        Route::get('/produk', [OwnerController::class, 'produkOwner'])->name('produk.data');
        Route::get('/admin', [OwnerController::class, 'adminOwner'])->name('owner.dataAdmin');
        Route::post('/admin', [OwnerController::class, 'storeAdmin'])->name('owner.storeAdmin');
        Route::get('/pelanggan', [OwnerController::class, 'pelangganOwner'])->name('pelanggan.data');
        Route::get('/penjualan', [OwnerController::class, 'penjualanLaporan'])->name('penjualan.data');
        Route::get('/pesanan', [OwnerController::class, 'pesananLaporan'])->name('pesanan.data');
    });

    // View Routes
    Route::get('/produk', [OwnerController::class, 'index3'])->name('owner.produk');
    Route::get('/pelanggan', [OwnerController::class, 'index4'])->name('owner.pelanggan');
    Route::get('/admin', [OwnerController::class, 'index5'])->name('owner.admin');

    // Print Routes
    Route::get('/order/cetak_pertanggal/{tglawal}/{tglakhir}', [OwnerController::class, 'cetak'])->name('order.cetak_pertanggal');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/profil', [AdminController::class, 'profil'])->name('admin.profil');
    Route::post('/profil/change_password', [AdminController::class, 'store'])->name('admin.password');

    // Order Management
    Route::prefix('order')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('admin.order.index');
        Route::get('/data', [OrderController::class, 'produkData'])->name('admin.order.data');
        Route::get('/record', [OrderController::class, 'records'])->name('order.record');
        Route::get('/cetak', [OrderController::class, 'cetak'])->name('order.cetak');
        Route::get('/detail/{id}', [OrderController::class, 'detail'])->name('admin.order.detail');
        Route::post('/{id}/update-status', [OrderController::class, 'updateStatus'])->name('admin.order.updateStatus');
    });

    // Invoice for Admin
    Route::get('/invoice/detail/{id}', [OrderController::class, 'invoiceDetail'])->name('admin.invoice.detail');

    // Product Management
    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.index');
        Route::get('/data', [ProductController::class, 'produkData'])->name('product2.data');
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/destroy/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
        Route::get('/detail/{id}', [ProductController::class, 'detail'])->name('product.detail');
        Route::patch('/stoks/{id}', [ProductController::class, 'changeStoks'])->name('change.stoks');
    });

    // Category Management
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/destroy/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
        Route::get('/detail/{id}', [CategoryController::class, 'detail'])->name('category.detail');
    });

    // Confirmation Admin
    Route::prefix('confirmAdmin')->group(function () {
        Route::get('/', [ConfirmAdminController::class, 'index'])->name('confirmAdmin');
        Route::get('/detail/{id}', [ConfirmAdminController::class, 'detail'])->name('confirmAdmin.detail');
        Route::post('/terima/{order_id}', [ConfirmAdminController::class, 'terima'])->name('confirmAdmin.terima');
        Route::post('/tolak/{order_id}', [ConfirmAdminController::class, 'tolak'])->name('confirmAdmin.tolak');
    });
});
